<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class ProjectController extends WalrusController
{
	public function run()
    {
    	$result = $this->model('project')->index();

		if(empty($result))
        {
            $this->register('error', 'There\'s no project');
        }
        else
        {
            $this->register('projects', $result);
        }

        $this->setView('list');
    }
}
