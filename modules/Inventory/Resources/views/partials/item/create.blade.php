    @stack('track_inventory_input_start')
        <div id="item-track-inventory" class="form-group col-md-12 margin-top">
            <strong>{{ trans('inventory::items.track_inventory') }}</strong> &nbsp;  {{ Form::checkbox('track_inventory', '1', 1, ['id' => 'track_inventory']) }}
        </div>
    @stack('track_inventory_input_end')

    {{ Form::textGroup('opening_stock', trans('inventory::items.opening_stock'), 'cubes', [], 1, 'col-md-6 item-inventory-form') }}

    {{ Form::textGroup('opening_stock_value', trans('inventory::items.opening_stock_value'), 'money', [], null, 'col-md-6 item-inventory-form') }}

    {{ Form::textGroup('reorder_level', trans('inventory::items.reorder_level'), 'repeat', [], null, 'col-md-6 item-inventory-form') }}

    @stack('vendor_id_input_start')
        <div class="hidden vendor form-group col-md-6 item-inventory-form {{ $errors->has('vendor_id') ? 'has-error' : ''}}">
            {!! Form::label('vendor_id', trans_choice('general.vendors', 1), ['class' => 'control-label']) !!}
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                {!! Form::select('vendor_id', $vendors, null, array_merge(['id' => 'vendor_id', 'class' => 'form-control', 'placeholder' => trans('general.form.select.field', ['field' => trans_choice('general.vendors', 1)])])) !!}
                <span class="input-group-btn">
                    <button type="button" id="button-vendor" class="btn btn-default btn-icon"><i class="fa fa-plus"></i></button>
                </span>
            </div>
            {!! $errors->first('vendor_id', '<p class="help-block">:message</p>') !!}
        </div>
    @stack('vendor_id_input_end')

    @if ($warehouses->count() >= 2)
        {{ Form::selectGroup('warehouse_id', trans_choice('inventory::general.warehouses', 1), 'building', $warehouses, old('warehouse_id') ? old('warehouse_id') : setting('inventory.default_warehouse'), []) }}
    @endif

@push('js')
    <script src="{{ asset('vendor/almasaeed2010/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/almasaeed2010/adminlte/plugins/iCheck/square/green.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript">
        var fake_quantity = '<div class="form-group col-md-6 required">';
        fake_quantity += '  <label for="fake_quantity" class="control-label">{{ trans_choice('items.quantities', 1) }}</label>';
        fake_quantity += '  <div class="input-group">';
        fake_quantity += '      <div class="input-group-addon"><i class="fa fa-cubes"></i></div>';
        fake_quantity += '      <input class="form-control" placeholder="{{ trans('general.form.select.field', ['field' => trans_choice('items.quantities', 1)]) }}" required="required" disabled="disabled" name="fake_quantity" type="text" value="1" id="fake_quantity">';
        fake_quantity += '   </div>';

        $(document).ready(function(){
            $('#quantity').parent().parent().before(fake_quantity);
            $('#quantity').parent().parent().addClass('hidden');

            @if (old('track_inventory'))
            $('.vendor.form-group.col-md-6').removeClass('hidden');
            @endif

            $('#vendor_id').select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.vendors', 1)]) }}"
            });

            $('#warehouse_id').select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('inventory::general.warehouses', 1)]) }}"
            });

            $('#track_inventory').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%'
            });

            $('#track_inventory').on('ifClicked', function (event) {
                if (!$(this).prop('checked')) {
                    $('.item-inventory-form').removeClass('hidden');

                    $('#quantity').parent().parent().before(fake_quantity);
                    $('#quantity').parent().parent().addClass('hidden');
                } else {
                    $('.item-inventory-form').addClass('hidden');

                    $('#fake_quantity').parent().parent().remove();
                    $('#quantity').parent().parent().removeClass('hidden');
                }
            });
        });

        $(document).on('click', '#button-vendor', function (e) {
            $('#modal-create-vendor').remove();

            $.ajax({
                url: '{{ url("modals/vendors/create") }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(json) {
                    if (json['success']) {
                        $('body').append(json['html']);
                    }
                }
            });
        });
    </script>
@endpush