<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;
use Walrus\core\WalrusHelpers;

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

    public function editTask($project_id, $id, $errors = array())
    {
        $taskModel = $this->model('task');
        $formFields = $taskModel->getForm($id)->getFields();
        $task = $taskModel->getTask($id);
        if (!is_null($task))
        {
            $formUpdateHelper = WalrusHelpers::getHelper('FormUpdate', true);
            $formFields = $formUpdateHelper->putDataIntoForm($formFields, $task);


            $this->register('project_id', $project_id);
            $this->register('errors', $errors);
            $this->register('task', $task->export());
            $this->register('formTask', $formFields);
            $this->setView('update');
        }
    }

    public function putTask($project_id, $id)
    {
        $taskModel = $this->model('task');
        $response = $taskModel->update($project_id, $id);
        if(!is_object($response) && $response !== false)
        {
            $this->reroute('task', 'editTask', array($project_id, $id, $response));
        }
        
        $this->go('/projects/'.$project_id);
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
