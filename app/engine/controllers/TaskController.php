<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class TaskController extends WalrusController
{
    public function postTask($project_id)
    {
        $taskModel = $this->model('task');
        $response = $taskModel->create($project_id);
        
        $this->go('/');
    }
}
