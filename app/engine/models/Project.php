<?php

namespace app\engine\models;

use R;
use Walrus\core\WalrusModel;

class Project extends WalrusModel
{
    public function getProjects()
    {
        $projects = R::findAll('projects');
        return $projects;
    }
}
