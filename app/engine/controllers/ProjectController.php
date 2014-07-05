<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class ProjectController extends WalrusController
{
    //@todelete
    public function postProject()
    {
        $projectModel = $this->model('project');
        $response = $projectModel->create();
        
        $this->go('/');
    }

    public function deleteProject($id)
    {
        $projectModel = $this->model('project');
        $response = $projectModel->delete($id);
        
        $this->go('/');
    }
}
