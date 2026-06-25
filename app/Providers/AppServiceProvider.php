<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // Importante importar esta clase
use Illuminate\Support\ServiceProvider;
use App\Models\User;

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
        // DEFINICIÓN DEL GATE PARA ADMINS
        Gate::define('admin-only', function (User $user) {
            // Verificamos si el rol_id del usuario logueado es 1 (Administrador)
            return (int) $user->rol_id === 1;
        });
    }
}