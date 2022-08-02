<?php

namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{
    public function getAuthKey()
    {
        return $this->db->table('application')->getWhere(['id' => 1])->getRowArray();
    }
    public function getUserSession($userID, $session)
    {
        return $this->db->table("users")->getWhere(['id' => $userID, 'session' => $session])->getRowArray();
    }

    public function setSession($userID, $session)
    {
        return $this->db->table('users')->update(['session' => $session], ['id' => $userID]);
    }

    public function getUsers($username = false, $userID = false)
    {
        if ($userID) {
            return $this->db->table("users")->select('fullname,username,created_at')->getWhere(['id' => $userID])->getRowArray();
        } else if ($username) {
            return $this->db->table("users")->getWhere(['username' => $username])->getRowArray();
        } else {
            return $this->db->table("users")->select('fullname,username,created_at')->get()->getRowArray();
        }
    }
    public function createUser($userData)
    {
        return $this->db->table('users')->insert([
            'fullname'      => $userData['fullname'],
            'username'      => $userData['username'],
            'password'      => password_hash($userData['password'], PASSWORD_DEFAULT),
            'created_at'    => date('Y-m-d h:i:s')
        ]);
    }
}
