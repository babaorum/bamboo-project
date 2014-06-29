<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class UserController extends WalrusController
{
    public function home()
    {
    	//@todelete when connexion exist
        $_SESSION['user']['id'] = 1;

        //@tomove and adapt in connexion method
        $userModel = $this->model('user');
        $user = $userModel->getUser($_SESSION['user']['id']);
        $_SESSION['user'] = $user->export();

        $projectModel = $this->model('project');
        
        $result = $projectModel->getProjects();

        if(empty($result))
        {
            $this->register('noProject', 'Il n\'y a pas encore de projet');
        }
        else
        {
            $this->register('projects', $result);
        }

        $this->setView('home');
    }
}
