<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Form;
use App\Models\Contest;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        // Общая логика для проверки прав (свой ресурс или админ)
        $canAccess = function ($user, $resource) {
            // Если пользователь не авторизован - доступ запрещен
            if (!$user) {
                return false;
            }
            return $user->id === (int)$resource->user_id || $user->isAdmin();
        };

        // Общая логика для пользователей (свой профиль или админ)
        $canAccessUser = function (User $currentUser, User $targetUser) {
            return $currentUser->id === $targetUser->id || $currentUser->isAdmin();
        };

        // ===== ГЕЙТЫ ДЛЯ FORM =====

        // Просмотр формы
        Gate::define('view-form', function (?User $user, Form $form) use ($canAccess) {
            if ($user->isBanned()) return false;
            return $canAccess($user, $form);
        });

        // Редактирование формы
        Gate::define('edit-form', function (User $user, Form $form) use ($canAccess) {
            if ($user->isBanned()) return false;
            return $canAccess($user, $form);
        });

        // Обновление формы
        Gate::define('update-form', function (User $user, Form $form) use ($canAccess) {
            if ($user->isBanned()) return false;
            return $canAccess($user, $form);
        });

        // Удаление формы
        Gate::define('delete-form', function (User $user, Form $form) use ($canAccess) {
            if ($user->isBanned()) return false;
            return $canAccess($user, $form);
        });


        // ===== ГЕЙТЫ ДЛЯ CONTEST =====

        // Просмотр конкурса
        Gate::define('view-contest', function (?User $user, Contest $contest) use ($canAccess) {
            if ($user->isBanned()) return false;
            return $canAccess($user, $contest);
        });

        // Редактирование конкурса
        Gate::define('edit-contest', function (User $user, Contest $contest) use ($canAccess) {
            if ($user->isBanned()) return false;
            return $canAccess($user, $contest);
        });

        // Обновление конкурса
        Gate::define('update-contest', function (User $user, Contest $contest) use ($canAccess) {
            if ($user->isBanned()) return false;
            return $canAccess($user, $contest);
        });

        // Удаление конкурса
        Gate::define('delete-contest', function (User $user, Contest $contest) use ($canAccess) {
            if ($user->isBanned()) return false;
            return $canAccess($user, $contest);
        });

        //активация конкурса
        Gate:define('activate-contest', function(User $user, Contest $contest) use ($canAccess){
            $access = $canAccess($user, $contest);
            if (!$access) return false;
            if ($user->isBanned()) return false;
            return $user->canActivateContest();
        });

        //деактивация конкурса
        Gate::define('deactivate-contest', function (User $user, Contest $contest) use ($canAccess) {
            if ($user->isBanned()) return false;
            return $canAccess($user, $contest);
        });


        // ===== ГЕЙТЫ ДЛЯ USER =====

        // Просмотр профиля пользователя
        Gate::define('view-user', function (?User $currentUser, User $targetUser) use ($canAccessUser) {
            // Если пользователь не авторизован - доступ запрещен
            if (!$currentUser) {
                return false;
            }
            return $canAccessUser($currentUser, $targetUser);
        });

        // Редактирование пользователя
        Gate::define('edit-user', function (User $currentUser, User $targetUser) use ($canAccessUser) {
            if ($currentUser->isBanned()) return false;
            return $canAccessUser($currentUser, $targetUser);
        });

        // Обновление пользователя
        Gate::define('update-user', function (User $currentUser, User $targetUser) use ($canAccessUser) {
            if ($currentUser->isBanned()) return false;
            return $canAccessUser($currentUser, $targetUser);
        });

        // Смена пароля
        Gate::define('change-password', function (User $currentUser, User $targetUser) use ($canAccessUser) {
            if ($currentUser->isBanned()) return false;
            return $canAccessUser($currentUser, $targetUser);
        });

        // Смена email
        Gate::define('change-email', function (User $currentUser, User $targetUser) use ($canAccessUser) {
            if ($currentUser->isBanned()) return false;
            return $canAccessUser($currentUser, $targetUser);
        });

        Gate::define('delete-user', function (User $currentUser, User $targetUser) use ($canAccessUser) {
            if ($currentUser->isBanned()) return false;
            return $canAccessUser($currentUser, $targetUser);
        });
        Gate::define('change-plan', function (User $currentUser, User $targetUser) use ($canAccessUser) {
            if ($currentUser->isBanned()) return false;
            return $canAccessUser($currentUser, $targetUser);
        });
    }
}
