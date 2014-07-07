<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;
use Walrus\core\WalrusHelpers;

class ProjectController extends WalrusController
{
    //@todelete
    public function postProject()
    {
        $projectModel = $this->model('project');
        $response = $projectModel->create();
        
        $this->go('/');
    }

    public function getFormProject($id, $errors = array())
    {
        $projectModel = $this->model('project');
        
        $formFields = $projectModel->getForm()->getFields();

        if ($id !== null)
        {
            $project = $projectModel->getProject($id);
            if (!is_null($project))
            {
                $formUpdateHelper = WalrusHelpers::getHelper('FormUpdate', true);
                $formFields = $formUpdateHelper->putDataIntoForm($formFields, $project);

                $this->register('errors', $errors);
                $this->register('project', $project->export());
                $this->register('formProject', $formFields);
                $this->setView('update');
            }
            else
            {
                $this->go('/');
            }
        }
        else
        {
            $this->go('/');
        }
    }

    public function putProject($id)
    {
        $projectModel = $this->model('project');
        $response = $projectModel->update($id);
        if(!is_object($response) && $response !== false)
        {
            $this->reroute('project', 'getFormProject', array($id, $response));
        }
        
        $this->go('/');
    }

    public function deleteProject($id)
    {
        $projectModel = $this->model('project');
        $response = $projectModel->delete($id);
        
        $this->go('/');
    }

    public function boardProject($id, $errors = array())
    {
        $projectModel = $this->model('project');
        $taskModel = $this->model('task');

        $project = $projectModel->getProject($id);
        if(!is_null($project))
        {
            $formTask = $taskModel->getForm();
            $tasks = $taskModel->getTasks($id);

            $this->register('formTask', $formTask->getFields());
            $this->register('tasks', $tasks);
            $this->register('project', $project->export());
            $this->setView('project');
        }
        else
        {
            $this->reroute('user', 'home');
        }
    }
}
