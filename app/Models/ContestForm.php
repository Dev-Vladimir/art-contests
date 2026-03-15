<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestForm extends Model
{
    protected $fillable = ['user_id', 'form_id', 'generated_form_id', 'title', 'validate_rules', 'content'];
}