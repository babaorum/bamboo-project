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
        
        if (is_object($response))
        {
            return array('project' => $response->export());
        }
        else
        {
            return array('errors' => $response);
        }
    }
}
