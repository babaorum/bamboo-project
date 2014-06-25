<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class UserController extends WalrusController
{
	public function home()
	{
        $this->setView('home');
    }
}
