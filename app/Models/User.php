<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Form;
use App\Models\Contest;
use App\Models\Subscription;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'full_name',
        'email',
        'password',
        'address',
        'pending_email',
        'phone',
        'website',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function forms(): HasMany {  
        return $this->hasMany(Form::class);  
    }
    
    public function contests() :hasMany {
        return $this->hasMany(Contest::class);
    }

    public function subscriptions() :HasMany {
        return $this->hasMany(Subscription::class);
    }

    public function isAdmin() {
        return $this->role === 3;
    }

    public function isBanned(): bool{
        return !is_null($this->banned_at);
    }

    public function activeSubscription(){
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>', now());
            })
            ->latest();
    }

    public function currentPlan(){
        return $this->activeSubscription?->plan;
    }


    public function getActiveContestsCount(): int
    {
        return $this->contests()->where('is_active', true)->count();
    }

    /**
     * Проверить, можно ли активировать новый конкурс
     */
    public function canActivateContest(): bool
    {
        if ($this->isBanned()) {
            return false;
        }
        
        $activeCount = $this->getActiveContestsCount();
        $limit = $this->currentPlan()?->contests_limit ?? 0;
        
        return $activeCount < $limit;
    }

    /**
     * Получить количество оставшихся слотов для активных конкурсов
     */
    public function getRemainingActiveSlots(): int
    {
        $activeCount = $this->getActiveContestsCount();
        $limit = $this->currentPlan()?->contests_limit ?? 0;
        
        return max(0, $limit - $activeCount);
    }

    /**
     * Проверить, может ли пользователь создать конкурс (всегда true, но с предупреждением)
     */
    public function canCreateContest(): bool
    {
        return !$this->isBanned(); // создавать можно всегда, активировать - по лимиту
    }

}
