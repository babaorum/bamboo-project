<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;
use Walrus\core\WalrusHelpers;

class TaskController extends WalrusController
{
    protected $user = null;

    public function __construct()
    {
        parent::__construct();

        if (empty($_SESSION['user']['id']))
        {
            $this->reroute('user', 'login');
        }
        else
        {
            $this->user = $this->model('user')->getUser($_SESSION['user']['id']);
        }
    }
    
    public function postTask($project_id)
    {
        $projectModel = $this->model('project');
        $taskModel = $this->model('task');
        $errors = array();
        if($projectModel->checkProjectUserRelation($project_id, $this->user))
        {
            $response = $taskModel->create($project_id);

            if(!is_object($response) && $response !== false)
            {
                $errors = $response;
            }
        }
        $this->reroute('project', 'boardProject', array($project_id, $errors));
    }

    public function editTask($project_id, $id, $errors = array())
    {
        $projectModel = $this->model('project');
        $taskModel = $this->model('task');
        if($projectModel->checkProjectUserRelation($project_id, $this->user))
        {
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
                return $this->setView('update');
            }
        }
        $this->reroute('project', 'boardProject', array($project_id));
    }

    public function putTask($project_id, $id)
    {
        $projectModel = $this->model('project');
        $taskModel = $this->model('task');
        if($projectModel->checkProjectUserRelation($project_id, $this->user))
        {
            $response = $taskModel->update($project_id, $id);
            if(!is_object($response) && $response !== false)
            {
                $this->reroute('task', 'editTask', array($project_id, $id, $response));
            }
        }
        
        $this->go('/projects/'.$project_id);
    }

    public function archiveTask($project_id, $id)
    {
        $projectModel = $this->model('project');
        $taskModel = $this->model('task');
        if($projectModel->checkProjectUserRelation($project_id, $this->user))
        {
            $response = $taskModel->archive($id);
        }

        $this->reroute('project', 'boardProject', array($project_id));
    }

    public function unarchiveTask($project_id, $id)
    {
        $projectModel = $this->model('project');
        $taskModel = $this->model('task');
        if($projectModel->checkProjectUserRelation($project_id, $this->user))
        {
            $response = $taskModel->unarchive($id);
        }

        $this->reroute('project', 'boardProject', array($project_id));
    }

    public function deleteTask($project_id, $id)
    {
        $projectModel = $this->model('project');
        $taskModel = $this->model('task');
        if($projectModel->checkProjectUserRelation($project_id, $this->user))
        {
            $response = $taskModel->delete($id);
        }

        $this->reroute('project', 'boardProject', array($project_id));
    }
}
