<?php

namespace App\Providers;

use App\Models\Flag;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->composeFlags();
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

    /**
     *
     * Compose flags though the selected partials only
     * @return array
     */
    private function composeFlags()
    {
        //Example for global variables for all controllers
        return view()->composer('admin.partials.flags', function($view){
             $view->with('flags', [ 'foo', 'bar']);
        });
    }
}
