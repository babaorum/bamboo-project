<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class TaskController extends WalrusController
{
    public function postTask($project_id)
    {
        $taskModel = $this->model('task');
        $response = $taskModel->create($project_id);

        $errors = array();
        if(!is_object($response) && $response !== false)
        {
            $errors = $response;
        }
        $this->reroute('project', 'boardProject', array($project_id, $errors));
    }

    public function archiveTask($project_id, $id)
    {
        $taskModel = $this->model('task');
        $response = $taskModel->archive($id);

        $this->reroute('project', 'boardProject', array($project_id));
    }

    public function deleteTask($project_id, $id)
    {
        $taskModel = $this->model('task');
        $response = $taskModel->delete($id);

        $this->reroute('project', 'boardProject', array($project_id));
    }
}
