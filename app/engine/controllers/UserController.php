<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class UserController extends WalrusController
{
    protected $userModel;
    protected $projectModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = $this->model('user');
        $this->projectModel = $this->model('project');
    }

    public function home()
    {
        if (empty($_SESSION['user']['id']))
        {
            $this->reroute('user', 'login');
        }
        
        $result = $this->projectModel->getProjects();

        if(empty($result))
        {
            $this->register('noProject', 'Il n\'y a pas encore de projet');
        }
        else
        {
            $this->register('projects', $result);
        }

        //@todelete on fix on upstream remote
        $this->register('session', $_SESSION);

        $this->setView('home');
    }

    public function login()
    {
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
                $user = $this->userModel->create($user);
                
                $_SESSION['user'] = $user->export();
                $this->go('http://bamboo-project.dev:8080');
            }
        }

        $this->register('authUrl', $authUrl);
        $this->setView('login');
    }
}
