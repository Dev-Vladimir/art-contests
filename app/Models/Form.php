<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Form extends Model
{
    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'title', 'form_settings', 'user_id',
    ];
}
