@if (!empty($items))
    @foreach($items as $item)
        @php $item_inventory = $item->item->belongsTo('Modules\Inventory\Models\Item', 'id', 'item_id')->first(); @endphp
        <tr id="item-row-{{ $item_row }}">
            @stack('name_td_start')
            <td {!! $errors->has('item.' . $item_row . '.name') ? 'class="has-error"' : ''  !!}>
                @stack('name_input_start')
                <input value="{{ $item->item->name }}" class="form-control typeahead" required="required" placeholder="{{ trans('general.form.enter', ['field' => trans_choice('invoices.item_name', 1)]) }}" name="item[{{ $item->item_id }}][name]" type="text" id="item-name-{{ $item_row }}" autocomplete="off">
                <input value="{{ $item->option_value_id }}" name="item[{{ $item->item_id }}][value_id]" type="hidden" id="item-value-id-{{ $item_row }}">
                {!! $errors->first('item.' . $item_row . '.name', '<p class="help-block">:message</p>') !!}
                @stack('name_input_end')
            </td>
            @stack('name_td_end')

            @stack('sku_td_start')
            <td {!! $errors->has('item.' . $item->item_id . '.sku') ? 'class="has-error"' : ''  !!}>
                @stack('sku_input_start')
                <input value="{{ $item->item->sku }}" class="form-control typeahead" required="required" placeholder="{{ trans('general.form.enter', ['field' => trans('items.sku')]) }}" name="item[{{ $item->item_id }}][sku]" type="text" id="item-sku-{{ $item_row }}" autocomplete="off">
                {!! $errors->first('item.' . $item->item_id . '.sku', '<p class="help-block">:message</p>') !!}
                @stack('sku_input_end')
            </td>
            @stack('sku_td_end')

            @stack('opening_stock_td_start')
            <td {{ $errors->has('item.' . $item->item_id . '.opening_stock') ? 'class="has-error"' : '' }}>
                @stack('opening_stock_input_start')
                <input value="{{ $item_inventory->opening_stock }}" class="form-control text-center" required="required" name="item[{{ $item->item_id }}][opening_stock]" type="text" id="item-opening-stock-{{ $item_row }}">
                {!! $errors->first('item.' . $item->item_id . '.opening_stock', '<p class="help-block">:message</p>') !!}
                @stack('opening_stock_input_end')
            </td>
            @stack('opening_stock_td_end')

            @stack('opening_stock_value_td_start')
            <td {{ $errors->has('item.' . $item->item_id . 'opening_stock_value') ? 'class="has-error"' : '' }}>
                @stack('opening_stock_value_input_start')
                <input value="{{ $item_inventory->opening_stock_value }}" class="form-control text-right input-price" required="required" name="item[{{ $item->item_id }}][opening_stock_value]" type="text" id="item-opening-stock-value-{{ $item_row }}">
                {!! $errors->first('item.' . $item->item_id . 'opening_stock_value', '<p class="help-block">:message</p>') !!}
                @stack('opening_stock_value_input_end')
            </td>
            @stack('opening_stock_value_td_end')

            @stack('sale_price_td_start')
            <td {{ $errors->has('item.' . $item->item_id . 'sale_price') ? 'class="has-error"' : '' }}>
                @stack('sale_price_input_start')
                <input value="{{ $item->item->sale_price }}" class="form-control text-right input-price" required="required" name="item[{{ $item->item_id }}][sale_price]" type="text" id="item-sale-price-{{ $item_row }}">
                {!! $errors->first('item.' . $item->item_id . 'sale_price', '<p class="help-block">:message</p>') !!}
                @stack('sale_price_input_end')
            </td>
            @stack('sale_price_td_end')

            @stack('purchase_price_td_start')
            <td {{ $errors->has('item.' . $item->item_id . 'purchase_price') ? 'class="has-error"' : '' }}>
                @stack('purchase_price_input_start')
                <input value="{{ $item->item->purchase_price }}" class="form-control text-right input-price" required="required" name="item[{{ $item->item_id }}][purchase_price]" type="text" id="item-purchase-price-{{ $item_row }}">
                {!! $errors->first('item.' . $item->item_id . 'purchase_price', '<p class="help-block">:message</p>') !!}
                @stack('purchase_price_input_end')
            </td>
            @stack('purchase_price_td_end')

            @stack('reorder_level_td_start')
            <td {{ $errors->has('item.' . $item->item_id . '.reorder_level') ? 'class="has-error"' : '' }}>
                @stack('reorder_level_input_start')
                <input value="{{ $item_inventory->reorder_level }}" class="form-control text-right" name="item[{{ $item->item_id }}][reorder_level]" type="text" id="item-reorder-level-{{ $item_row }}">
                {!! $errors->first('item.' . $item->item_id . '.reorder_level', '<p class="help-block">:message</p>') !!}
                @stack('reorder_level_input_end')
            </td>
            @stack('reorder_level_td_end')
        </tr>
        @php $item_row++; @endphp
    @endforeach
@else
    @foreach($values as $value_id => $value_name)
        <tr id="item-row-{{ $item_row }}">
            @stack('name_td_start')
            <td {!! $errors->has('item.' . $item_row . '.name') ? 'class="has-error"' : ''  !!}>
                @stack('name_input_start')
                <input value="{{ empty($item) ? $value_name : $item->name }}" class="form-control typeahead" required="required" placeholder="{{ trans('general.form.enter', ['field' => trans_choice('invoices.item_name', 1)]) }}" name="item[{{ $item_row }}][name]" type="text" id="item-name-{{ $item_row }}" autocomplete="off">
                <input value="{{ $value_id }}" name="item[{{ $item_row }}][value_id]" type="hidden" id="item-value-id-{{ $item_row }}">
                {!! $errors->first('item.' . $item_row . '.name', '<p class="help-block">:message</p>') !!}
                @stack('name_input_end')
            </td>
            @stack('name_td_end')

            @stack('sku_td_start')
            <td {!! $errors->has('item.' . $item_row . '.sku') ? 'class="has-error"' : ''  !!}>
                @stack('sku_input_start')
                <input value="{{ empty($item) ? '' : $item->sku }}" class="form-control typeahead" required="required" placeholder="{{ trans('general.form.enter', ['field' => trans('items.sku')]) }}" name="item[{{ $item_row }}][sku]" type="text" id="item-sku-{{ $item_row }}" autocomplete="off">
                {!! $errors->first('item.' . $item_row . '.sku', '<p class="help-block">:message</p>') !!}
                @stack('sku_input_end')
            </td>
            @stack('sku_td_end')

            @stack('opening_stock_td_start')
            <td {{ $errors->has('item.' . $item_row . '.opening_stock') ? 'class="has-error"' : '' }}>
                @stack('opening_stock_input_start')
                <input value="{{ empty($item) ? 1 : $item->opening_stock }}" class="form-control text-center" required="required" name="item[{{ $item_row }}][opening_stock]" type="text" id="item-opening-stock-{{ $item_row }}">
                {!! $errors->first('item.' . $item_row . '.opening_stock', '<p class="help-block">:message</p>') !!}
                @stack('opening_stock_input_end')
            </td>
            @stack('opening_stock_td_end')

            @stack('opening_stock_value_td_start')
            <td {{ $errors->has('item.' . $item_row . 'opening_stock_value') ? 'class="has-error"' : '' }}>
                @stack('opening_stock_value_input_start')
                <input value="{{ empty($item) ? '' : $item->opening_stock_value }}" class="form-control text-right input-price" required="required" name="item[{{ $item_row }}][opening_stock_value]" type="text" id="item-opening-stock-value-{{ $item_row }}">
                {!! $errors->first('item.' . $item_row . 'opening_stock_value', '<p class="help-block">:message</p>') !!}
                @stack('opening_stock_value_input_end')
            </td>
            @stack('opening_stock_value_td_end')

            @stack('sale_price_td_start')
            <td {{ $errors->has('item.' . $item_row . 'sale_price') ? 'class="has-error"' : '' }}>
                @stack('sale_price_input_start')
                <input value="{{ empty($item) ? '' : $item->sale_price }}" class="form-control text-right input-price" required="required" name="item[{{ $item_row }}][sale_price]" type="text" id="item-sale-price-{{ $item_row }}">
                {!! $errors->first('item.' . $item_row . 'sale_price', '<p class="help-block">:message</p>') !!}
                @stack('sale_price_input_end')
            </td>
            @stack('sale_price_td_end')

            @stack('purchase_price_td_start')
            <td {{ $errors->has('item.' . $item_row . 'purchase_price') ? 'class="has-error"' : '' }}>
                @stack('purchase_price_input_start')
                <input value="{{ empty($item) ? '' : $item->purchase_price }}" class="form-control text-right input-price" required="required" name="item[{{ $item_row }}][purchase_price]" type="text" id="item-purchase-price-{{ $item_row }}">
                {!! $errors->first('item.' . $item_row . 'purchase_price', '<p class="help-block">:message</p>') !!}
                @stack('purchase_price_input_end')
            </td>
            @stack('purchase_price_td_end')

            @stack('reorder_level_td_start')
            <td {{ $errors->has('item.' . $item_row . '.reorder_level') ? 'class="has-error"' : '' }}>
                @stack('reorder_level_input_start')
                <input value="{{ empty($item) ? '' : $item->reorder_level }}" class="form-control text-right" name="item[{{ $item_row }}][reorder_level]" type="text" id="item-reorder-level-{{ $item_row }}">
                {!! $errors->first('item.' . $item_row . '.reorder_level', '<p class="help-block">:message</p>') !!}
                @stack('reorder_level_input_end')
            </td>
            @stack('reorder_level_td_end')
        </tr>
        @php $item_row++; @endphp
    @endforeach
@endif