<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\ContestForm;
use App\Models\Form;

use App\Models\User;

class Contest extends Model
{
    public $fillable = [
        'title', 'user_id', 'form_id', 'groups','nominations', 'is_active', 'open'
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function contestForm() : HasOne {
        return $this->HasOne(ContestForm::class);
    }
}
