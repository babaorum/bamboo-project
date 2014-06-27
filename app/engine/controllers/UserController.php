<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class UserController extends WalrusController
{
	public function home()
	{
		$project = $this->model('project')
		
		$result = $project->getProjects();

		if(empty($result))
        {
            $this->register('noProject', 'Il n\'y a pas encore de projet');
        }
        else
        {
            $this->register('projects', $result);
        }

        $this->setView('home');
    }
}
