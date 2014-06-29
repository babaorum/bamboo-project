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
			$user = R::findOne("$column_name = :data", [':data' => $data]);
		}
		return $user;
	}

}
