<?php

namespace Modules\Inventory\Observers\Income;

use App\Models\Income\InvoiceItem as InvoiceItemModel;
use Modules\Inventory\Models\History as ModelInventoryHistory;
use Modules\Inventory\Models\Item as ModelInventoryItem;
use Auth;

class InvoiceItem
{

    /**
     * Listen to the created event.
     *
     * @param  ModelInventoryHistory $invoice_item
     *
     * @return void
     */
    public function created(InvoiceItemModel $invoice_item)
    {        
        $item = $invoice_item->item;

        if (empty($item)) {
            return false;
        }

        //Don't create history for items without Inventory track
        if (is_null(ModelInventoryItem::where('item_id', $item->id)->first())) {
            return false;
        }

        ModelInventoryHistory::where('type_type', get_class($invoice_item))
            ->where('type_id', $invoice_item->id)
            ->delete();

        $warehouse_id = setting('inventory.default_warehouse');

        $user = Auth::user();

        ModelInventoryHistory::create([
            'company_id' => $invoice_item->company_id,
            'user_id' => $user->id,
            'item_id' => $item->id,
            'type_id' => $invoice_item->id,
            'type_type' => get_class($invoice_item),
            'warehouse_id' => $warehouse_id,
            'quantity' => $invoice_item->quantity,
        ]);
    }

    /**
     * Listen to the deleted event.
     *
     * @param  ModelInventoryHistory $invoice_item
     *
     * @return void
     */
    public function deleted(InvoiceItemModel $invoice_item)
    {
        ModelInventoryHistory::where('type_type', get_class($invoice_item))
            ->where('type_id', $invoice_item->id)
            ->delete();
    }
}
