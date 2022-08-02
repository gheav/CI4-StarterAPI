<?php

namespace App\Libraries;

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use App\Models\CommonModel;
use CodeIgniter\I18n\Time;

class JsonWebToken
{
    public static string $SECRET_KEY = "GHEAV818-dlsfgkslkLMlkjILKHJ9hljhfuiiuRGbjsdwe";

    public static function signatureEncode($uid)
    {
        $CommonModel  = new CommonModel();
        $sessionID  = password_hash($uid, PASSWORD_BCRYPT);
        $issuedAt   = new Time();
        $expire     = $issuedAt->modify('+60 minutes')->getTimestamp();
        $payload = [
            "jti"       => $sessionID, // JWT ID
            "iat"       => time(),
            "uid"       => palladium($uid),
            "exp"       => $expire
        ];
        $token = JWT::encode($payload, JsonWebToken::$SECRET_KEY, 'HS256');
        $CommonModel->setSession($uid, $sessionID);
        return $token;
    }

    public static function signatureDecode()
    {
        $request        = \Config\Services::request();
        $Xsignature     = $request->getHeaderLine('X-Signature');
        try {
            $decoded        = JWT::decode($Xsignature, new Key(JsonWebToken::$SECRET_KEY, 'HS256'));
            $decoded_array  = (array) $decoded;
            return $decoded_array;
        } catch (\Throwable $th) {
            header("Content-type: application/json");
            echo json_encode([
                'status'  => false,
                'message' => 'Invalid X-Signature.'
            ]);
            die;
        }
    }
}
