<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Inventory\Http\Requests\ItemGroup as Request;
use Modules\Inventory\Http\Requests\ItemGroupOptionAdd as OptionAddRequest;
use Modules\Inventory\Http\Requests\ItemGroupOptionValues as OptionValuesRequest;
use Modules\Inventory\Http\Requests\ItemGroupItemAdd as ItemAddRequest;
use App\Models\Common\Item;
use Modules\Inventory\Models\Item as Model;
use Modules\Inventory\Models\ItemGroupOption;
use Modules\Inventory\Models\ItemGroupOptionItem;
use Modules\Inventory\Models\ItemGroupOptionValue;
use App\Models\Setting\Category;
use App\Models\Setting\Currency;
use App\Models\Setting\Tax;
use App\Traits\Uploads;
use App\Utilities\Import;
use App\Utilities\ImportFile;
use Modules\Inventory\Models\ItemGroup;
use Modules\Inventory\Models\Option;

class ItemGroups extends Controller
{
    use Uploads;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $item_groups = ItemGroup::with('category')->collect();

        $categories = Category::enabled()->orderBy('name')->type('item')->pluck('name', 'id');

        return view('inventory::item-groups.index', compact('item_groups', 'categories'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return redirect()->route('items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::enabled()->orderBy('name')->type('item')->pluck('name', 'id');

        $taxes = Tax::enabled()->orderBy('name')->get()->pluck('title', 'id');

        $options = Option::enabled()->orderBy('name')->pluck('name', 'id');

        $currency = Currency::where('code', '=', setting('general.default_currency', 'USD'))->first();

        return view('inventory::item-groups.create', compact('categories', 'taxes', 'options', 'currency'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $item_group = ItemGroup::create($request->input());

        // Upload picture
        if ($request->file('picture')) {
            $media = $this->getMedia($request->file('picture'), 'item-groups');

            $item_group->attachMedia($media, 'picture');
        }

        // Add item group option
        if ($request->has('option')) {
            foreach ($request->get('option') as $request_option) {
                $item_group_option = ItemGroupOption::create([
                    'company_id' => $item_group->company_id,
                    'item_group_id' => $item_group->id,
                    'option_id' => $request_option['name']
                ]);

                if (!empty($request_option['value'])) {
                    foreach ($request_option['value'] as $request_option_value) {
                        $item_group_option_value = ItemGroupOptionValue::create([
                            'company_id' => $item_group->company_id,
                            'item_group_id' => $item_group->id,
                            'item_group_option_id' => $item_group_option->id,
                            'option_id' => $request_option['name'],
                            'option_value_id' => $request_option_value,
                        ]);
                    }
                }
            }
        }

        // Add Items
        if ($request->has('item')) {
            foreach ($request->get('item') as $request_item) {
                $item = Item::create([
                    'company_id' => $item_group->company_id,
                    'name' => $request_item['name'],
                    'sku' => $request_item['sku'],
                    'description' => $request->get('description'),
                    'sale_price' => $request_item['sale_price'],
                    'purchase_price' => $request_item['purchase_price'],
                    'quantity' => $request_item['opening_stock'],
                    'category_id' => $request->get('category_id'),
                    'tax_id'=> $request->get('tax_id'),
                    'enabled' => $request->get('enabled')
                ]);

                $item_inventory = Model::create([
                    'company_id' => $item->company_id,
                    'item_id' => $item->id,
                    'opening_stock' => $request_item['opening_stock'],
                    'opening_stock_value' => $request_item['opening_stock_value'],
                    'reorder_level' => $request_item['reorder_level'],
                    'vendor_id' => 0
                ]);

                $item_group_item = ItemGroupOptionItem::create([
                    'company_id' => $item->company_id,
                    'item_id' => $item->id,
                    'option_id' => $item_group_option->option_id,
                    'option_value_id' => $request_item['value_id'],
                    'item_group_id' => $item_group->id,
                    'item_group_option_id' => $item_group_option->id,
                ]);
            }
        }

        $message = trans('messages.success.added', ['type' => trans_choice('inventory::general.item_groups', 1)]);

        flash($message)->success();

        return redirect()->route('item-groups.index');
    }

    /**
     * Duplicate the specified resource.
     *
     * @param  Item  $item
     *
     * @return Response
     */
    public function duplicate(ItemGroup $item_group)
    {
        $clone = $item_group->duplicate();

        $item_group_option = $clone->options->first();

        foreach ($clone->items as $item) {
            $item->item_group_option_id = $item_group_option->id;
            $item->save();
        }

        foreach ($clone->option_values as $option_value) {
            $option_value->item_group_option_id = $item_group_option->id;
            $option_value->save();
        }

        foreach ($item_group->items as $request_item) {
            $item = Item::create([
                'company_id' => $clone->company_id,
                'name' => $request_item->item->name,
                'sku' => $request_item->item->sku,
                'description' => $request_item->item->description,
                'sale_price' => $request_item->item->sale_price,
                'purchase_price' => $request_item->item->purchase_price,
                'quantity' => $request_item->item->quantity,
                'category_id' => $request_item->item->category_id,
                'tax_id'=> $request_item->item->tax_id,
                'enabled' => $request_item->item->enabled,
            ]);

            $item_inventory = $request_item->item->belongsTo('Modules\Inventory\Models\Item', 'id', 'item_id')->first();

            $item_inventory = Model::create([
                'company_id' => $item->company_id,
                'item_id' => $item->id,
                'opening_stock' => $item_inventory->opening_stock,
                'opening_stock_value' => $item_inventory->opening_stock_value,
                'reorder_level' => $item_inventory->reorder_level,
                'vendor_id' => $item_inventory->vendor_id
            ]);

            $item_group_item = ItemGroupOptionItem::create([
                'company_id' => $item->company_id,
                'item_id' => $item->id,
                'option_id' => $item_group_option->option_id,
                'option_value_id' => $request_item->option_value_id,
                'item_group_id' => $clone->id,
                'item_group_option_id' => $item_group_option->id,
            ]);
        }

        $message = trans('messages.success.duplicated', ['type' => trans_choice('inventory::general.item_groups', 1)]);

        flash($message)->success();

        return redirect()->route('item-groups.edit', $clone->id);
    }

    /**
     * Import the specified resource.
     *
     * @param  ImportFile  $import
     *
     * @return Response
     */
    public function import(ImportFile $import)
    {
        if (!Import::createFromFile($import, 'Inventory\ItemGroup')) {
            return redirect('common/import/inventory/item-groups');
        }

        $message = trans('messages.success.imported', ['type' => trans_choice('inventory::general.item_groups', 2)]);

        flash($message)->success();

        return redirect()->route('item-groups.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Item  $item
     *
     * @return Response
     */
    public function edit(ItemGroup $item_group)
    {
        $categories = Category::enabled()->orderBy('name')->type('item')->pluck('name', 'id');

        $taxes = Tax::enabled()->orderBy('name')->get()->pluck('title', 'id');

        $options = Option::enabled()->orderBy('name')->pluck('name', 'id');

        $currency = Currency::where('code', '=', setting('general.default_currency', 'USD'))->first();

        $select_option = $item_group->options()->first();

        $items = ItemGroupOptionItem::where('item_group_id', $item_group->id)->get();

        return view('inventory::item-groups.edit', compact('item_group', 'categories', 'taxes', 'options', 'select_option', 'values', 'currency', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Item  $item
     * @param  Request  $request
     *
     * @return Response
     */
    public function update(ItemGroup $item_group, Request $request)
    {
        $item_group->update($request->input());

        // Upload picture
        if ($request->file('picture')) {
            $media = $this->getMedia($request->file('picture'), 'item-groups');

            $item_group->attachMedia($media, 'picture');
        }

        $items = ItemGroupOptionItem::where('item_group_id', $item_group->id)->pluck('item_id')->toArray();

        foreach ($request->get('item') as $item_id => $request_item) {
            if (!in_array($item_id, $items)) {
                continue;
            }

            $item = Item::where('id', $item_id)->first();

            $item->update([
                'company_id' => $item_group->company_id,
                'name' => $request_item['name'],
                'sku' => $request_item['sku'],
                'description' => $request->get('description'),
                'sale_price' => $request_item['sale_price'],
                'purchase_price' => $request_item['purchase_price'],
                'quantity' => $request_item['opening_stock'],
                'category_id' => $request->get('category_id'),
                'tax_id'=> $request->get('tax_id'),
                'enabled' => $request->get('enabled')
            ]);

            $item_inventory = Model::where('item_id', $item_id)->first();

            $item_inventory->update([
                'company_id' => $item->company_id,
                'item_id' => $item->id,
                'opening_stock' => $request_item['opening_stock'],
                'opening_stock_value' => $request_item['opening_stock_value'],
                'reorder_level' => $request_item['reorder_level'],
                'vendor_id' => 0
            ]);
        }

        $message = trans('messages.success.updated', ['type' => trans_choice('inventory::general.item_groups', 1)]);

        flash($message)->success();

        return redirect()->route('item-groups.index');
    }

    /**
     * Enable the specified resource.
     *
     * @param  ItemGroup  $item_group
     *
     * @return Response
     */
    public function enable(ItemGroup $item_group)
    {
        $item_group->enabled = 1;
        $item_group->save();

        foreach ($item_group->items as $item_group_item) {
            $item = $item_group_item->item;

            $item->enabled = 1;
            $item->save();
        }

        $message = trans('messages.success.enabled', ['type' => trans_choice('inventory::general.item_groups', 1)]);

        flash($message)->success();

        return redirect()->route('item-groups.index');
    }

    /**
     * Disable the specified resource.
     *
     * @param  ItemGroup  $item_group
     *
     * @return Response
     */
    public function disable(ItemGroup $item_group)
    {
        $item_group->enabled = 0;
        $item_group->save();

        foreach ($item_group->items as $item_group_item) {
            $item = $item_group_item->item;

            $item->enabled = 0;
            $item->save();
        }

        $message = trans('messages.success.disabled', ['type' => trans_choice('inventory::general.item_groups', 1)]);

        flash($message)->success();

        return redirect()->route('item-groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ItemGroup  $item_group
     *
     * @return Response
     */
    public function destroy(ItemGroup $item_group)
    {
        foreach ($item_group->items as $item) {
            $relationships = $this->countRelationships($item, [
                'invoice_items' => 'invoices',
                'bill_items' => 'bills',
            ]);

            if (!empty($relationships)) {
                break;
            }
        }

        if (empty($relationships)) {
            $item_group->delete();

            $message = trans('messages.success.deleted', ['type' => trans_choice('inventory::general.item_groups', 1)]);

            flash($message)->success();
        } else {
            $message = trans('messages.warning.deleted', ['name' => $item_group->name, 'text' => implode(', ', $relationships)]);

            flash($message)->warning();
        }

        return redirect()->route('item-groups.index');
    }

    /**
     * Export the specified resource.
     *
     * @return Response
     */
    public function export()
    {
        \Excel::create('items', function ($excel) {
            $excel->sheet('items', function ($sheet) {
                $sheet->fromModel(Item::filter(request()->input())->get()->makeHidden([
                    'id', 'company_id', 'item_id', 'created_at', 'updated_at', 'deleted_at'
                ]));
            });
        })->download('xlsx');
    }

    public function addOption(OptionAddRequest $request)
    {
        $option_row = $request->get('option_row');

        $options = Option::enabled()->orderBy('name')->pluck('name', 'id');

        $html = view('inventory::item-groups.option', compact('option_row', 'options'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'data'    => [],
            'message' => 'null',
            'html'    => $html,
        ]);
    }

    public function addItem(ItemAddRequest $request)
    {
        $item_row = $request->get('item_row');
        $name = $request->get('name');
        $option_id = $request->get('option_id');
        $_values = $request->get('values');
        $text_value = $request->get('text_value');

        $option = Option::with('values')->where('id', $option_id)->first();

        $values = [];

        if ($_values) {
            foreach ($option->values as $value) {
                if (in_array($value->id, $_values)) {
                    $values[$value->id] = !empty($name) ? $name . ' - ' . $value->name : $value->name;
                }
            }
        }

        if ($text_value) {
            $values[] = !empty($name) ? $name . ' - ' . $text_value : $text_value;
        }

        $html = view('inventory::item-groups.item', compact('item_row', 'option', 'values'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'data'    => [],
            'message' => 'null',
            'html'    => $html,
        ]);
    }

    public function getOptionValues(OptionValuesRequest $request)
    {
        $option_id = $request->get('option_id');

        $option = Option::with('values')->where('id', $option_id)->first();

        $values = $option->values()->orderBy('name')->pluck('name', 'id');

        return response()->json([
            'success' => true,
            'error'   => false,
            'data'    => [
                'option' => $option,
                'values' => $values
            ],
            'message' => null,
            'html'    => null,
        ]);
    }
}
