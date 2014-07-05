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

    public function deleteProject($id)
    {
        $projectModel = $this->model('project');
        $response = $projectModel->delete($id);
        
        $this->go('/');
    }

    public function boardProject($id)
    {
        $projectModel = $this->model('project');
        $project = $projectModel->getProject($id);
		if(!is_null($project))
		{
			$this->register('project', $project->export());
			$this->setView('project');
		}
		else
		{
			$this->reroute('user', 'home');
		}
    }
}
