<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
use Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('create-task', function (User $user) {
            return true;
        });

        Gate::define('update-task', function (User $user, Task $task) {
            return $user->is_admin || $task->user_id === $user->id;
        });

        Gate::define('delete-task', function (User $user, Task $task) {
            return $user->is_admin || $task->user_id === $user->id;
        });
    }
}
