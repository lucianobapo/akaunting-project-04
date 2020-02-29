<?php

namespace Modules\Inventory\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Inventory\Models\Item as Model;
use Modules\Inventory\Models\Warehouse;
use App\Models\Module\Module;
use App\Utilities\CacheUtility;

class Invoice
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $cache = new CacheUtility();

        $modules = $cache->remember('modules_pluck', function () {
            return Module::all()->pluck('alias')->toArray();
        }, [Module::class]);


        if (in_array('inventory', $modules)) {
            $warehouses = $cache->remember('warehouses_pluck', function () {
                return Warehouse::enabled()->pluck('name', 'id');
            }, [Warehouse::class]);

            // Push to a stack
            if ($view->getName() == 'income.invoices.edit') {
                $view->getFactory()->startPush('scripts', view('inventory::partials.invoice.edit', compact('warehouses')));
            } else {
                $view->getFactory()->startPush('scripts', view('inventory::partials.invoice.create', compact('warehouses')));
            }
        }
    }
}
