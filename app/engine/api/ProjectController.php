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

    public function deleteProject()
    {
        $projectModel = $this->model('project');
        $response = $projectModel->delete();

        if(is_numeric($response))
        {
            return array(
                'code' => 204,
                'project_id' => $response
            );
        }

        return array(
            'code' => 400
        );
    }
}
