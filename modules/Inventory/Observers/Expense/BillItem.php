<?php

namespace Modules\Inventory\Observers\Expense;

use App\Models\Expense\BillItem as BillItemModel;
use Modules\Inventory\Models\History as Model;
use Auth;

class BillItem
{
    /**
     * Listen to the created event.
     *
     * @param  Model $item
     *
     * @return void
     */
    public function created(BillItemModel $bill_item)
    {
        $user = Auth::user();

        $item = $bill_item->item;

        if (empty($item)) {
            return false;
        }

        Model::where('type_type', get_class($bill_item))
            ->where('type_id', $bill_item->id)
            ->delete();

        $warehouse_id = setting('inventory.default_warehouse');

        Model::create([
            'company_id' => $bill_item->company_id,
            'user_id' => $user->id,
            'item_id' => $item->id,
            'type_id' => $bill_item->id,
            'type_type' => get_class($bill_item),
            'warehouse_id' => $warehouse_id,
            'quantity' => $bill_item->quantity,
        ]);
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model $item
     *
     * @return void
     */
    public function deleted(BillItemModel $bill_item)
    {
        Model::where('type_type', get_class($bill_item))
            ->where('type_id', $bill_item->id)
            ->delete();
    }
}
