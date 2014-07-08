<?php

namespace app\engine\models;

use R;
use Walrus\core\WalrusModel;
use Walrus\core\WalrusForm;

class Task extends WalrusModel
{
    public function getTasks($project_id)
    {
        return R::find('tasks', 'projects_id = :project_id', ['project_id' => $project_id]);
    }
    
    public function getTask($id)
    {
        $task = R::load('tasks', $id);
        if ($task->id !== 0)
        {
            return $task;
        }
        return null;
    }

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
                $task->status = 'do';
                $task->archive = false;
                $project->ownTasks[] = $task;
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

    public function update($project_id, $id)
    {
        $projectModel = $this->model('project');
        $project = $projectModel->getProject($project_id);
        
        $task = $this->getTask($id);
        if (!is_null($project) && $task->projects_id === $project->id)
        {
            $form = new WalrusForm('form_task');
            $errors = $this->check($project_id, $task->name);

            if($form->check() && empty($errors))
            {
                $task->import($_POST, 'name,description,status,color,deadline');
                R::store($task);
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

    public function archive($id)
    {
        $task = $this->getTask($id);
        
        if(!is_null($task))
        {
            $task->archive = true;
            R::store($task);
            return $task;
        }
        return false;
    }

    public function unarchive($id)
    {
        $task = $this->getTask($id);
        if(!is_null($task))
        {
            $task->archive = false;
            R::store($task);
            return $task;
        }
        return false;
    }

    public function delete($id)
    {
        $task = $this->getTask($id);

        if(!is_null($task))
        {
            R::trash($task);

            $task_exist = $this->getTask($id);

            if (is_null($task_exist))
            {
                return $id;
            }
        }

        return false;
    }

    public function check($project_id, $exception = null)
    {
        $errors = array();
        $task = R::findOne('tasks', 'name = :name AND projects_id = :project_id', [':name' => $_POST['name'], 'project_id' => $project_id]);
        if (empty($_POST['name']))
        {
            $errors['name'] = 'Le nom ne doit pas être vide';
        }
        if (!is_null($task) && ($exception == null || $task->name !== $exception))
        {
            $errors['name'][] = 'Le nom d\'une t&acirc;che doit &ecirc;tre unique'; 
        }
        if (isset($_POST['status']) && !in_array($_POST['status'], array('do','doing','done')))
        {
            $errors['status'][] = 'Le statut donné n\'est pas valide';
        }
        if(isset($_POST['color']) && !in_array($_POST['color'], array('','blue','green','yellow','orange','red')))
        {
            $errors['color'][] = 'La couleur donnée n\'est pas valide';
        }
        if (isset($_POST['deadline']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_POST['deadline']) === false)
        {
            $errors['deadline'][] = 'La deadline n\'est pas au bon format';
        }

        return $errors;
    }
}
