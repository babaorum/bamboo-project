<?php

namespace app\engine\models;

use R;
use Walrus\core\WalrusModel;
use Walrus\core\WalrusForm;

class User extends WalrusModel
{
    public function getUsers()
    {
        $users = R::findAll('users');
        return $users;
    }

    public function getUser($id)
    {
        $user = R::load('users', $id);
        if ($user->id !== 0)
        {
            return $user;
        }
        return null;
    }

    public function getUserByEmail($email)
    {
        $user = R::load('users', $email);
        if ($user->id !== 0)
        {
            return $user;
        }
        return null;
    }
}