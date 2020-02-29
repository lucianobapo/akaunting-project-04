<?php

namespace Modules\Inventory\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Module\Module;
use App\Utilities\CacheUtility;

class Menu
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
            // Push to a stack
            $view->getFactory()->startPush('scripts', view('inventory::partials.all.menu'));
        }
    }
}
