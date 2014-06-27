<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;
use RedBean_OODBBean;

class ProjectController extends WalrusController
{
    public function postProject()
    {
        $projectModel = $this->model('project');
        $response = $projectModel->create();
        
        if (is_object($response))
        {
            die (var_dump(array('project' => $response->export())));
        }
        else
        {
            die (var_dump(array('errors' => $response)));
        }
    }
}
