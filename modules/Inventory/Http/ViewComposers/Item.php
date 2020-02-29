<?php

namespace Modules\Inventory\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Inventory\Models\Item as Model;
use Modules\Inventory\Models\Warehouse;
use App\Models\Module\Module;
use App\Utilities\CacheUtility;

class Item
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
            $vendors = [];

            $warehouses = $cache->remember('warehouses_pluck', function () {
                return Warehouse::enabled()->pluck('name', 'id');
            }, [Warehouse::class]);

            // Push to a stack
            if ($view->getName() == 'common.items.edit') {
                $item = $view->getData()['item'];

                $inventory_item = Model::where('item_id', $item->id)->first();

                $view->getFactory()->startPush('enabled_input_end', view('inventory::partials.item.edit', compact('item', 'inventory_item', 'vendors', 'warehouses')));
            } else {
                $view->getFactory()->startPush('enabled_input_end', view('inventory::partials.item.create', compact('vendors', 'warehouses')));
            }
        }
    }
}
