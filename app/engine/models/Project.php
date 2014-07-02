<?php

namespace app\engine\models;

use R;
use Walrus\core\WalrusModel;
use Walrus\core\WalrusForm;

class Project extends WalrusModel
{
	public function getProjects()
	{
		$projects = R::findAll('projects');
		return $projects;
	}

    public function new()
    {
        $form = new WalrusForm('form_project');
        $form->check();

        return $form;
    }
    
    public function create()
    {
        $form = new WalrusForm('form_project');
        $errors = $this->check();
        
        if($form->check() && empty($errors))
        {
            $project = R::dispense('projects');
            $project->import($_POST, 'name,description');
            R::store($project);
            return $project;
        }
        elseif(!$form->check())
        {
            $errors = array_merge($errors, $form->check());
        }

        return $errors;
    }

    public function check()
    {
        $errors = array();
        $project = R::findOne('projects', 'name = :name', [':name' => $_POST['name']]);
        if (!is_null($project))
        {
            $errors['name'] = 'Le nom d\'un projet doit &ecirc;tre unique'; 
        }

        return $errors;
    }
}
