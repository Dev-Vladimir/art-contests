<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class FormBuilderService{

    private static $validation_rules = [];
    private static $validation_messages = [];

    public static function makeValidationRules($settings){
        // dd($settings);
        $validation_rules = [];
        $validation_messages = [];
        foreach ($settings as $field){
            self::getFieldRules($field);
        }
        self::GetRules();
    }

    public static function formToHTML($json_data){
        $content = '';
        foreach ($json_data->fields as $field){
            $content .= self::getFieldHTML($field);
        }
        return $content;
    }

    public static function makeApplicationForm($contest, $form){
        $content = '';
        if (!empty($contest->nominations)) $content .= self::getSelect('nominations', $contest->nominations);
        if (!empty($contest->groups)) $content .= self::getSelect('groups', $contest->groups);
        return $content . $form->content;
    }

    private static function getFieldHTML($field){
        return view('form-builder.' . $field->type, compact('field'))->render();
    }

    private static function getSelect($select_name, $items){
        $select_items = explode('|', $items);
        return view('form-builder.select-items', compact('select_items', 'select_name'))->render();
    }

    private static function getFieldRules($field){
        $name = $field->name;
        $rules = [];
        if ($field->required) {
            $rules[] = 'required';
            self::addMessage($name . '.required', 'Поле ' . $field->title . 'Обязательно для заполнения!');
        } 
        dd('ok');
        if ($field->type == 'text' || $field->type == 'textarea') $rules[] = $field->type == 'text' ? 'max:255' : 'max:16000';
        //надо еще дописать для файлов и селектов
        self::addRule($name, implode('|', $rules));
    }

    private static function addRule($name, $rule){
        self::$validation_rules[$name] = $rule; 
    }

    private static function addMessage($name, $rule){
        self::$validation_messages[$name] = $rule;
    }

    private static function GetRules(){
        dd([
            self::$validation_rules,
            self::$validation_messages
        ]);
        return [
            self::$validation_rules,
            self::$validation_messages
        ];
    }
}
?>