<?php

namespace app\engine\api;

use Walrus\core\WalrusAPI;

class ProjectController extends WalrusAPI
{
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
