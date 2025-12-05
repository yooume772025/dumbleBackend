<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $appInstalled = filter_var(env('APP_INSTALLED', false), FILTER_VALIDATE_BOOLEAN);

        if ($appInstalled) {
            View::composer(
                '*',
                function ($view) {
                    try {
                        $webSettings = DB::table('web_settings')->where('id', 1)->first();
                        $view->with('webSettings', $webSettings);
                    } catch (\Exception $e) {
                        $view->with('webSettings', null);
                    }
                }
            );
        } else {
            View::share('webSettings', null);
            View::share('menus', []);
        }
    }
}
