<?php

namespace app\helpers;

class GetField extends \Twig_Extension
{
    public function getFieldFilter($field, $id = null, $cssClasses = null,$dataName = null, $dataValue = null, $addAttrName = null, $addAttrValue = null, $addAttrSingle = null)
    {
        $output = null;
        // Attributes send as arguments
        $class = (!empty($cssClasses)) ? 'class="'.$cssClasses.'"' : '';
        $id = (!empty($id)) ? 'id="'.$id.'"' : '';
        $data = (!empty($dataName) && !empty($dataValue)) ? 'data-'.$dataName.'="'.$dataValue.'"' : '';
        $addAttr = (!empty($addAttrName) && !empty($addAttrValue)) ? ''.$addAttrName.'="'.$addAttrValue.'"' : '';
        $addAttrSingle = (!empty($addAttrSingle)) ? ''.$addAttrSingle.'' : '';
        $attr = $id.' '.$class.' '.$addAttr.' '.$addAttrSingle;


        // Attributes generic to multiple form tags
        $name = (!empty($field['class'])) ? 'name="'.$field['class'].'"' : '';
        $value = (!empty($field['value'])) ? 'value="'.$field['value'].'"' : '';

        if ($field['type'] == 'select')
        {
            $options = null;
            foreach ($field['options'] as $option)
            {
                $val = (!empty($option['value'])) ? 'value="'.$option['value'].'"' : '';
                $label = (!empty($option['label'])) ? $option['label'] : 'label...';
                $selected = ($field['value'] == $option['value'])? 'selected':'';
                $option = '<option '.$selected.' '.$val.'>'.$label.'</option>';
                $options .= $option;
            }

            $output = '<select '.$attr.' '.$name.' '.$data.'>'.$options.'</select>';
        }
        elseif ($field['type'] == 'textarea')
        {
            $output = '<textarea '.$attr.' '.$name.'></textarea>';
        }
        else
        {
            $type = (!empty($field['type'])) ? 'type="'.$field['type'].'"' : '';

            $output = '<input '.$attr.' '.$name.' '.$type.' '.$value.'>';
        }

        return $output;
    }

    public function getName()
    {
        return 'get_field_extension';
    }
}