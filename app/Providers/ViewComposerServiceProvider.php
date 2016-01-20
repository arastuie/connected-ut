<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeLoginBar();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function composeLoginBar()
    {
        view()->composer('master', function($view)
        {
            if(Auth::check())
                $user = Auth::user()->name;
            else
                $user = null;

            $view->with('user', $user);
        });
    }
}
