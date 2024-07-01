<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema; // Importar Schema
use App\Models\User;
use App\Models\Message;

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
        // Verificar si la aplicación no se está ejecutando en la consola y si la tabla 'users' existe
        if (!$this->app->runningInConsole() && Schema::hasTable('users')) {
            View::share('users', User::all());
        }

        // Para los mensajes, también verificar si la tabla 'messages' existe
        view()->composer('*', function ($view) {
            if (!$this->app->runningInConsole() && Schema::hasTable('messages') && auth()->check()) {
                $messages = Message::where('receiver_id', auth()->user()->id)->get();
                $view->with('messages', $messages);
            }
        });
    }
}