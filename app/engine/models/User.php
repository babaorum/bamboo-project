<?php

namespace app\engine\models;

use R;
use Walrus\core\WalrusModel;

class User extends WalrusModel
{
    public function getUser($data, $column_name = 'id')
    {
        if($column_name === 'id')
        {
            $user = R::load('users', $data);
        }
        else
        {
            $user = R::findOne('users', "$column_name = ?", [$data]);
        }
        
        if ($user->id !== 0)
        {
            return $user;
        }
        return null;
    }

    public function create($user)
    {
        $mail = $user->getEmails()[0]['value'];
        $lastname = $user->getName()->familyName;
        $firstname = $user->getName()->givenName;
        $picture = $user->getImage()->url;

        if (!empty($mail) && !empty($lastname) && !empty($firstname) && !empty($picture))
        {
            $user = $this->getUser($mail, 'mail');

            if (is_null($user))
            {
                $user = R::dispense('users');
                $user->lastname = $lastname;
                $user->firstname = $firstname;
                $user->mail = $mail;
                $user->picture = $picture;
                
                R::store($user);
            }

            return $user;
        }

        return false;
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
