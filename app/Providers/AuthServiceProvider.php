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
         // Просмотр формы (может пригодиться)
        Gate::define('view-form', function (?User $user, Form $form) {
            // если $user = null, то доступ запрещен
            // dd($user);
            return $user && ($user->id === (int)$form->user_id || $user->isAdmin());
        });

        // Редактирование формы
        Gate::define('edit-form', function (User $user, Form $form) {
            // dd($user->id, $form->user_id);
            return $user->id == (int)$form->user_id || $user->isAdmin();
        });

        // Обновление формы (обычно аналогично edit)
        Gate::define('update-form', function (User $user, Form $form) {
            return $user->id === (int)$form->user_id || $user->isAdmin();
        });

        // Удаление формы
        Gate::define('delete-form', function (User $user, Form $form) {
            return $user->id === (int)$form->user_id || $user->isAdmin();
        });
         // Просмотр конкурса (может пригодиться)
        Gate::define('view-contest', function (?User $user, Contest $contest) {
            // если $user = null, то доступ запрещен
            // dd($user);
            return $user && ($user->id === (int)$contest->user_id || $user->isAdmin());
        });

        // Редактирование конкурса
        Gate::define('edit-contest', function (User $user, Contest $contest) {
            // dd($user->id, $form->user_id);
            return $user->id == (int)$contest->user_id || $user->isAdmin();
        });

        // Обновление конкурса (обычно аналогично edit)
        Gate::define('update-contest', function (User $user, Contest $contest) {
            return $user->id === (int)$contest->user_id || $user->isAdmin();
        });

        // Удаление конкурса
        Gate::define('delete-contest', function (User $user, Contest $contest) {
            return $user->id == (int)$contest->user_id || $user->isAdmin();
        });
    }
}
