<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {    
        foreach (glob($this->app->basePath().'/app/Helpers/*.php') as $filename){
            require_once($filename);
        }
    }

    
}
