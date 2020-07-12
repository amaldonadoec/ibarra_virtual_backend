<?php

namespace App\Providers;

use App\Http\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.master', function ($view) {
            $user = Auth::user();
            $menu = new Menu();
            $menu = $menu->buildMenu($user);
            $view->with('menu', $menu);
            $view->with('log_in_name', $user->name);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
