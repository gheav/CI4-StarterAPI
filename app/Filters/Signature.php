<?php

namespace App\Filters;

use App\Models\CommonModel;
use App\Libraries\JsonWebToken;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Signature implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        helper('crypto');
        $this->CommonModel  = new CommonModel();
        $Xsignature         = $request->getHeaderLine('X-Signature');
        $signature          = JsonWebToken::signatureDecode();
        $user               = $this->CommonModel->getUserSession(depalladium($signature['uid']), $signature['jti']);
        if (!$Xsignature) {
            header("Content-type: application/json");
            echo json_encode([
                "status"    => false,
                'message' => 'X-Signature Header must be set.'
            ]);
            die;
        } else if (!$user) {
            header("Content-type: application/json");
            echo json_encode([
                "status"    => false,
                'message'   => 'Invalid Session',
                'data'      => $signature
            ]);
            die;
        }
    }


    function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
