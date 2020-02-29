<?php

namespace Modules\Inventory\Providers;

use App\Models\Common\Item;
use App\Models\Income\InvoiceItem;
use App\Models\Expense\BillItem;
use Modules\Inventory\Models\History as InventoryHistory;
use Modules\Inventory\Models\Item as InventoryItem;
use Modules\Inventory\Models\WarehouseItem as InventoryWarehouseItem;
use Modules\Inventory\Models\Warehouse as InventoryWarehouse;

use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Items
        Item::observe('Modules\Inventory\Observers\Common\Item');

        // Invoices
        InvoiceItem::observe('Modules\Inventory\Observers\Income\InvoiceItem');

        // Bills
        BillItem::observe('Modules\Inventory\Observers\Expense\BillItem');

        // Inventory
        InventoryHistory::observe('Modules\Inventory\Observers\InventoryHistory');
        InventoryItem::observe('Modules\Inventory\Observers\InventoryItem');
        InventoryWarehouseItem::observe('Modules\Inventory\Observers\InventoryWarehouseItem');
        InventoryWarehouse::observe('Modules\Inventory\Observers\InventoryWarehouse');
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
