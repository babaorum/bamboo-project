<?php

namespace app\engine\api;

use Walrus\core\WalrusAPI;

class ProjectController extends WalrusAPI
{
	public function postProject()
	{
		$projectModel = $this->model('project');
		$response = $projectModel->create();
		if ($response instanceof RedBean_OODBBean)
		{
			die(var_dump(expression))
		}
		else
		{
			
		}
	}
}
