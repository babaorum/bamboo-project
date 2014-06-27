<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;
use RedBean_OODBBean;

class UserController extends WalrusController
{
	public function home()
	{
        $formProject = $this->model('project')->newProject();

        $this->register('formProject', $formProject->render());
        $this->setView('home');
    }
}