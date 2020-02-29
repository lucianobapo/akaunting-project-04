<?php

namespace Modules\Inventory\Observers\Common;

use App\Models\Common\Item as ItemModel;
use Modules\Inventory\Models\WarehouseItem;
use Modules\Inventory\Models\Item as Model;
use Modules\Inventory\Models\History;
use Auth;

class Item
{

    /**
     * Listen to the created event.
     *
     * @param  Model $item
     *
     * @return void
     */
    public function created(ItemModel $item)
    {
        $request = request();

        if (!$request->has('track_inventory')) {
            logger('track_inventory not set');
            return false;
        }

        Model::create([
            'company_id' => $item->company_id,
            'item_id' => $item->id,
            'opening_stock' => $request->get('opening_stock'),
            'opening_stock_value' => $request->get('opening_stock_value'),
            'reorder_level' => $request->get('reorder_level'),
            'vendor_id' => $request->get('vendor_id')
        ]);

        $warehouse_id = setting('inventory.default_warehouse');

        if ($request->has('warehouse_id')) {
            $warehouse_id = $request->get('warehouse_id');
        }

        WarehouseItem::create([
            'company_id' => $item->company_id,
            'warehouse_id' => $warehouse_id,
            'item_id' => $item->id,
        ]);

        $user = Auth::user();

        History::create([
            'company_id' => $item->company_id,
            'user_id' => $user->id,
            'item_id' => $item->id,
            'type_id' => $item->id,
            'type_type' => get_class($item),
            'warehouse_id' => $warehouse_id,
            'quantity' => $request->get('opening_stock'),
        ]);
    }

    public function saved(ItemModel $item)
    {
        $method = request()->getMethod();

        if ($method == 'PATCH') {
            $this->updated($item);
        }
    }

    /**
     * Listen to the created event.
     *
     * @param  Model $item
     *
     * @return void
     */
    public function updated(ItemModel $item)
    {
        $inventory_item = Model::where('item_id', $item->id)->first();

        $request = request();

        if (!$request->has('opening_stock')) {
            logger('opening_stock not set');
            return false;
        }

        if (!empty($inventory_item)) {
            $inventory_item->update([
                'company_id' => $item->company_id,
                'item_id' => $item->id,
                'opening_stock' => $request->get('opening_stock'),
                'opening_stock_value' => $request->get('opening_stock_value'),
                'reorder_level' => $request->get('reorder_level'),
                'vendor_id' => $request->get('vendor_id')
            ]);
        } else {
            Model::create([
                'company_id' => $item->company_id,
                'item_id' => $item->id,
                'opening_stock' => $request->get('opening_stock'),
                'opening_stock_value' => $request->get('opening_stock_value'),
                'reorder_level' => $request->get('reorder_level'),
                'vendor_id' => $request->get('vendor_id')
            ]);
        }

        $warehouse_id = setting('inventory.default_warehouse');

        $inventory_warehouse = WarehouseItem::where('item_id', $item->id)->first();

        if ($request->has('warehouse_id')) {
            $warehouse_id = $request->get('warehouse_id');
        }

        if (!empty($inventory_item)) {
            $inventory_warehouse->update([
                'company_id' => $item->company_id,
                'warehouse_id' => $warehouse_id,
                'item_id' => $item->id,
            ]);
        } else {
            WarehouseItem::create([
                'company_id' => $item->company_id,
                'warehouse_id' => $warehouse_id,
                'item_id' => $item->id,
            ]);
        }

        $user = Auth::user();

        $history = History::where('type_id', $item->id)
                        ->where('type_type', get_class($item))
                        ->where('item_id', $item->id)
                        ->first();

        if ($history) {
            $history->update([
                'company_id' => $item->company_id,
                'user_id' => $user->id,
                'item_id' => $item->id,
                'type_id' => $item->id,
                'type_type' => get_class($item),
                'warehouse_id' => $warehouse_id,
                'quantity' => $request->get('opening_stock'),
            ]);
        } else {
            History::create([
                'company_id' => $item->company_id,
                'user_id' => $user->id,
                'item_id' => $item->id,
                'type_id' => $item->id,
                'type_type' => get_class($item),
                'warehouse_id' => $warehouse_id,
                'quantity' => $request->get('opening_stock'),
            ]);
        }
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model $item
     *
     * @return void
     */
    public function deleted(ItemModel $item)
    {
        Model::where('item_id', $item->id)->delete();
        WarehouseItem::where('item_id', $item->id)->delete();

        History::where('type_id', $item->id)
            ->where('type_type', get_class($item))
            ->where('item_id', $item->id)
            ->delete();
    }
}
