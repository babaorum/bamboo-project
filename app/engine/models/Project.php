<?php

namespace app\engine\models;

use R;
use Walrus\core\WalrusModel;

class Project extends WalrusModel
{
	public function index()
	{
		$projects = R::findAll('project');
		return $projects;
	}
}
