<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class Contest extends Model
{
    public $fillable = [
        'title', 'user_id', 'form_id', 'groups','nominations', 'is_active'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
