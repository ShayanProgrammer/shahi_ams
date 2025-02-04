<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = auth()->user(); // Get the authenticated user, for example
            $view->with('user', $user);
        });
    }

    public function register()
    {
        //
    }
}
