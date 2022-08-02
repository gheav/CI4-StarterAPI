<?php

namespace App\Controllers;

use App\Libraries\JsonWebToken;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function registration()
    {
        if (!$this->validate([
            'fullname'     => 'required',
            'username'     => 'required|is_unique[users.username]',
            'password'     => 'required',
        ])) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'    => false,
                'message'   => $this->validation->getErrors()
            ]);
        } else {
            $registration        = $this->CommonModel->createUser($this->request->getPost());
            if ($registration) {
                $username       = $this->request->getPost('username');
                $user           = $this->CommonModel->getUsers(username: $username);
                return $this->response->setStatusCode(200)->setJSON([
                    'status'    => true,
                    'message'   => 'success',
                    'data'      => JsonWebToken::signatureEncode($user['id'])
                ]);
            } else {
                return $this->response->setStatusCode(404)->setJSON([
                    'status'    => false,
                    'message'   => 'Username or Password is Wrong!'
                ]);
            }
        }
    }

    public function login()
    {
        if (!$this->validate(['username'  => 'required', 'password' => 'required'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'    => false,
                'message'   => $this->validation->getErrors()
            ]);
        } else {
            $username       = $this->request->getPost('username');
            $password       = $this->request->getPost('password');
            $user           = $this->CommonModel->getUsers(username: $username);
            if ($user) {
                $userPassword   = $user['password'];
                $verify = password_verify($password, $userPassword);
                if ($verify) {
                    return $this->response->setStatusCode(200)->setJSON([
                        'status'    => true,
                        'message'   => 'success',
                        'data'      => JsonWebToken::signatureEncode($user['id'])
                    ]);
                } else {
                    return $this->response->setStatusCode(404)->setJSON([
                        'status'    => false,
                        'message'   => 'Username or Password is Wrong!'
                    ]);
                }
            } else {
                return $this->response->setStatusCode(404)->setJSON([
                    'status'    => false,
                    'message'   => 'Username or Password is Wrong!'
                ]);
            }
        }
    }

    public function users()
    {
        $user   = $this->CommonModel->getUsers(userID: $this->request->getPost('id'));
        return  $this->response->setJSON([
            'status'    => true,
            'message'   => 'success',
            'data'      => $user
        ]);
    }

    public function logout()
    {
        $this->CommonModel->setSession($this->uid, null);
        return  $this->response->setJSON([
            'status'    => true,
            'message'   => 'success'
        ]);
    }
}
