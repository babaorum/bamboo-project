<?php

namespace app\engine\controllers;

use Walrus\core\WalrusController;

class ProjectController extends WalrusController
{
	public function getProjectForm()
	{
		$form = new WalrusForm('form_project');
		$form->check();
		
		die(var_dump($form->render()));
		$this->register('projectForm', 'coucou');
        $this->setView('world');
	}
}
