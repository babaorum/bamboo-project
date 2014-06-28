<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class UserController extends WalrusController
{
    public function home()
    {
        $projectModel = $this->model('project');
        
        $formProject = $projectModel->newProject();
        $projects = $projectModel->getProjects();
        if(empty($projects))
        {
            $this->register('noProject', 'Il n\'y a pas encore de projet');
        }
        else
        {
            $this->register('projects', $projects);
        }

        $this->register('formProject', $formProject->render());
        $this->setView('home');
    }
}
