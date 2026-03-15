<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Contest;

class Form extends Model
{
    protected $fillable = [
        'title', 'form_settings', 'user_id', 'content', 'validate_rules'
    ];

    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function contests(): HasMany
    {
        return $this->hasMany(Contest::class);
    }
}
