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

    public function getProject($id)
    {
        $project = R::load('projects', $id);
        if ($project->id !== 0)
        {
            return $project;
        }
        return null;
    }

    public function getForm()
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

    public function update($id)
    {
        $project = $this->getProject($id);
        if(!is_null($project))
        {
            $form = new WalrusForm('form_project');
            $errors = $this->check($project->name);
            if($form->check() && empty($errors))
            {
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
        return false;
    }

    public function delete($id)
    {
        $project = $this->getProject($id);

        if (!is_null($project))
        {
            R::trash( $project );

            $project_exist = $this->getProject($id);

            if (is_null($project_exist))
            {
                return $id;
            }
        }

        return false;
    }

    public function check($exception = null)
    {
        $errors = array();
        $project = R::findOne('projects', 'name = :name', [':name' => $_POST['name']]);
        if (!is_null($project->name) && ($exception == null || $project->name !== $exception))
        {
            $errors['name'][] = 'Le nom d\'un projet doit &ecirc;tre unique'; 
        }

        return $errors;
    }

    public function addUser($value='')
    {
        # code...
    }
}
