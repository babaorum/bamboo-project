<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class UserController extends WalrusController
{
    public function home()
    {
        $projectModel = $this->model('project');
        if (empty($_SESSION['user']['id']))
        {
            $this->reroute('user', 'login');
        }

        $formProject = $projectModel->getForm();
        $projects = $projectModel->getProjects();
        if(empty($projects))
        {
            $this->register('noProject', 'Il n\'y a pas encore de projet');
        }
        else
        {
            $this->register('projects', $projects);
        }

        $this->register('formProject', $formProject->getFields());
        $this->setView('home');
    }

    public function login()
    {
        $userModel = $this->model('user');
        $include_path = get_include_path();
        set_include_path($include_path. PATH_SEPARATOR ."../../vendor/Google/src/");
        include_once('Google/Client.php');
        include_once('Google/Service/Plus.php');
        set_include_path($include_path);

        $client = new \Google_Client();
        $client->setClientId("140508511015-mb4svv1rk6e940gs70cpuc2ad744k3ra.apps.googleusercontent.com");
        $client->setClientSecret("IOnnpvWpIcWfrvkcGbGmlZDB");
        $client->setRedirectUri("http://localhost:8080/bamboo-project/app/www/index.php/login");
        $client->setScopes(array('email', 'profile'));
        $client->setApprovalPrompt('auto');
        $authUrl = $client->createAuthUrl();
        
        if (!empty($_GET['code']))
        {
            $client->authenticate( $_GET['code']);
            
            if ($client->getAccessToken())
            {
                $client->setAccessToken($client->getAccessToken());

                $plus = new \Google_Service_Plus($client);
                $user = $plus->people->get('me');
                $user = $userModel->create($user);
                
                header('Location: http://bamboo-project.dev:8080/log/'.$user->id);
                die();
            }
        }

        $this->register('authUrl', $authUrl);
        $this->setView('login');
    }

    public function loged($id)
    {
        $userModel = $this->model('user');
        $user = $userModel->getUser($id);
        if(!is_null($user))
        {
            $_SESSION['user'] = $user->export();
        }
        
        $this->go('/');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        $this->reroute('user', 'login');
    }
}
