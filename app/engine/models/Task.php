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
}
