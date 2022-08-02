<?php

function palladium($plainText)
{
    $encrypter  = \Config\Services::encrypter();
    $ciphertext = $encrypter->encrypt($plainText);
    return base64_encode($ciphertext);
}

function depalladium($chipertext)
{
    $encrypter = \Config\Services::encrypter();
    $plaintext = $encrypter->decrypt(base64_decode($chipertext));
    return $plaintext;
}
