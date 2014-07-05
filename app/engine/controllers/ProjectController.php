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
        
        $formFields = $projectModel->getForm($id)->getFields();

        if ($id !== null)
        {
            $project = $projectModel->getProject($id);
            if ($project->id !== 0)
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
}
