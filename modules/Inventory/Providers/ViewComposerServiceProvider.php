<?php

namespace Modules\Inventory\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.admin.head', 'Modules\Inventory\Http\ViewComposers\Menu');

        View::composer(['common.items.index'], 'Modules\Inventory\Http\ViewComposers\Index');

        View::composer(['common.items.create', 'common.items.edit'], 'Modules\Inventory\Http\ViewComposers\Item');

        View::composer(['incomes.invoices.create', 'incomes.invoices.edit'], 'Modules\Inventory\Http\ViewComposers\Invoice');
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
