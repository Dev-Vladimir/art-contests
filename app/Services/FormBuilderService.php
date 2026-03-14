<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class FormBuilderService{

    public static function formToHTML($json_data){
        $content = '';
        $form_data = json_decode($json_data);
        foreach ($form_data->fields as $field){
            $content .= self::getFieldHTML($field);
        }
        return $content;
    }

    private static function getFieldHTML($field){
        return view('form-builder.' . $field->type)->render();
    }
}


?>