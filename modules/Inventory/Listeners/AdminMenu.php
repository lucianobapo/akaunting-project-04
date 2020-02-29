<?php

namespace Modules\Inventory\Listeners;

use App\Events\AdminMenuCreated;
use Menu;
use Nwidart\Menus\MenuItem;
use App\Models\Module\Module;
use Illuminate\Support\Facades\Cache;
use App\Utilities\CacheUtility;

class AdminMenu
{
    private $menuItems;
    protected $cache;

    /**
     * The constructor.
     *
     * @param Factory    $views
     * @param Repository $config
     */
    public function __construct(MenuItem $menuItems)
    {
        $this->menuItems = $menuItems;
        $this->cache = new CacheUtility;
    }

    /**
     * Handle the event.
     *
     * @param  AdminMenuCreated $event
     * @return void
     */
    public function handle(AdminMenuCreated $event)
    {
        $modules = $this->cache->remember('modules_pluck_alias', function () {
            return Module::all()->pluck('alias')->toArray();
        }, [Module::class]);

        if (!in_array('inventory', $modules)) {
            return false;
        }

        $user = auth()->user();

        if (!$user->can([
            'read-inventory-item-groups',
            'read-common-items',
            'read-inventory-options',
            'read-inventory-manufacturers',
            'read-inventory-warehouses',
        ])) {
            return;
        }

        $attr = ['icon' => 'fa fa-angle-double-right'];

        $event->menu->dropdown(trans('inventory::general.menu.inventory'), function ($sub) use ($user, $attr) {
            if ($user->can('read-common-items')) {
                $sub->url('common/items', trans_choice('general.items', 2), 1, $attr);
            }

            if ($user->can('read-inventory-item-groups')) {
                $sub->url('inventory/item-groups', trans('inventory::general.menu.item_groups'), 2, $attr);
            }

            if ($user->can('read-inventory-options')) {
                $sub->url('inventory/options', trans('inventory::general.menu.options'), 3, $attr);
            }

            /*
            if ($user->can('read-inventory-manufacturers')) {
                $sub->url('inventory/manufacturers', trans('inventory::general.menu.manufacturers'), 4, $attr);
            }
            */

            if ($user->can('read-inventory-warehouses')) {
                $sub->url('inventory/warehouses', trans('inventory::general.menu.warehouses'), 5, $attr);
            }

            if ($user->can('read-inventory-histories')) {
                $sub->url('inventory/histories', trans('inventory::general.menu.histories'), 6, $attr);
            }

            /*
            if ($user->can('read-inventory-reports')) {
                $sub->url('inventory/reports', trans('inventory::general.menu.reports'), 7, $attr);
            }
            */

            if ($user->can('read-inventory-settings')) {
                $sub->url('inventory/settings', trans_choice('general.settings', 2), 8, $attr);
            }
        }, 2.5, [
            'title' => trans('inventory::general.title'),
            'icon' => 'fa fa-cubes',
        ]);
    }
}
