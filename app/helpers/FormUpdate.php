<?php

namespace app\helpers;
use Walrus\core\WalrusHelpers;

class FormUpdate
{
    public function putDataIntoForm($formFields, $data)
    {
        foreach ($formFields as $key => $field)
        {
            if (!empty($data[$key]))
            {
                $formFields[$key]['value'] = $data[$key];
            }
        }

        return $formFields;
    }
}
