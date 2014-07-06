<?php

namespace app\engine\models;

use R;
use Walrus\core\WalrusModel;
use Walrus\core\WalrusForm;

class Task extends WalrusModel
{
    public function getForm()
    {
        $form = new WalrusForm('form_task');
        $form->check();

        return $form;
    }

    public function create($project_id)
    {
        $projectModel = $this->model('project');
        $project = $projectModel->getProject($project_id);
        
        if (!is_null($project))
        {
            $form = new WalrusForm('form_task');
            $errors = $this->check($project_id);
            
            if($form->check() && empty($errors))
            {
                $task = R::dispense('tasks');
                $task->import($_POST, 'name,description,color,deadline');
                $project->ownTasksList[] = $task;
                R::store($project);
                return $task;
            }
            elseif(!$form->check())
            {
                $errors = array_merge($errors, $form->check());
            }

            return $errors;
        }
        return false;
    }

    public function check($project_id)
    {
        $errors = array();
        $task = R::findOne('tasks', 'name = :name AND projects_id = :project_id', [':name' => $_POST['name'], 'project_id' => $project_id]);
        if (!is_null($task))
        {
            $errors['name'][] = 'Le nom d\'une t&acirc;che doit &ecirc;tre unique'; 
        }

        return $errors;
    }
}
