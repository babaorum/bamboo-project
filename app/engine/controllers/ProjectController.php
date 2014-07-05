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
        
        $this->go('/');
    }

    public function getFormProject($id)
    {
    	$view = 'create';
    	$projectModel = $this->model('project');
        
        $formFields = $projectModel->getForm($id)->getFields();

        if ($id !== null)
        {
            $project = $projectModel->getProject($id);
            if ($project->id !== 0)
            {
                $formUpdateHelper = WalrusHelpers::getHelper('FormUpdate', true);
                $formFields = $formUpdateHelper->putDataIntoForm($formFields, $project);
            	$view = 'update';
            }
        }

        $this->register('formProject', $formFields);
        $this->setView($view);
    }

    public function putProject()
    {
    	$projectModel = $this->model('project');
    	$response = $projectModel->update();

    	$this->go('/');
    }

    public function deleteProject($id)
    {
        $projectModel = $this->model('project');
        $response = $projectModel->delete($id);
        
        $this->go('/');
    }
}
