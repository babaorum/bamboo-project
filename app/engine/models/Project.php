<?php

namespace app\engine\models;

use R;
use Walrus\core\WalrusModel;
use Walrus\core\WalrusForm;

class Project extends WalrusModel
{
	public function newProject()
	{
		$form = new WalrusForm('form_project');
		$form->check();

		return $form;
	}
	
	public function create()
	{
		$form = new WalrusForm('form_project');
		if($form->check())
		{

			$project = R::dispense('projects');
			$project->import($_POST, 'title,description');
			R::store($project);
			return $project;
		}

		return $form->check();
	}

	public function check()
	{
		$errors = array();
		$project = R::findOne('projects', 'title = :title', [':title' => $_POST[':title']]);
		if (!is_null($project))
		{
			// $errors[] = 
		}

	}

}
