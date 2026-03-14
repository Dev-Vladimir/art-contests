<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class GeneratedForm extends Model
{
    protected $fillable = ['title', 'user_id', 'form_id', 'content'];

    public static function saveForm($form_id, $form_title, $user_id, $content){
        try{
            // dd($form_title, $user_id, $content);
            self::create([
            'title' => $form_title,
            'user_id' => $user_id,
            'form_id' => $form_id,
            'content' => $content
            ]);
        }catch(\Exception $e){
            Log::error('Ошибка при сохранении формы', [
                'error' => $e->getMessage(),
                'title' => $title,
                'user_id' => $user_id
            ]);
        }
    }
}
