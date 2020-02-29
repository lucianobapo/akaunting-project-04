<?php

namespace Modules\Inventory\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Inventory\Listeners\AdminMenu;
use Modules\Inventory\Listeners\ModuleInstalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['events']->listen(\App\Events\AdminMenuCreated::class, AdminMenu::class);
        $this->app['events']->listen(\App\Events\ModuleInstalled::class, ModuleInstalled::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
