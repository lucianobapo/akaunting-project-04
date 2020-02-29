@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('inventory::general.item_groups', 1)]))

@section('content')
    <!-- Default box -->
    <div class="box box-success">
        {!! Form::model($item_group, [
            'method' => 'PATCH',
            'files' => true,
            'route' => ['item-groups.update', $item_group->id],
            'role' => 'form',
            'class' => 'form-loading-button'
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('name', trans('general.name'), 'id-card-o') }}

            {{ Form::textareaGroup('description', trans('general.description')) }}

            {{ Form::selectGroup('tax_id', trans_choice('general.taxes', 1), 'percent', $taxes, null, []) }}

            {{ Form::selectGroup('category_id', trans_choice('general.categories', 1), 'folder-open-o', $categories, null, []) }}

            {{ Form::fileGroup('picture', trans_choice('general.pictures', 1)) }}

            <div class="form-group col-md-12">
                {!! Form::label('options', trans_choice('inventory::general.options', 2), ['class' => 'control-label']) !!}

                <div class="table-responsive">
                    <table class="table table-bordered" id="options">
                        <thead>
                            <tr style="background-color: #f9f9f9;">
                                @stack('actions_th_start')
                                <th width="5%"  class="text-center hidden">{{ trans('general.actions') }}</th>
                                @stack('actions_th_end')
                                @stack('name_th_start')
                                <th width="20%" class="text-left">{{ trans('general.name') }}</th>
                                @stack('name_th_end')
                                @stack('quantity_th_start')
                                <th width="75%" class="text-center">{{ trans('inventory::options.values') }}</th>
                                @stack('quantity_th_end')
                            </tr>
                        </thead>

                        <tbody>
                            @php $option_row = 0; @endphp
                            <tr id="option-row-{{ $option_row }}">
                                @stack('actions_td_start')
                                <td class="text-center hidden" style="vertical-align: middle;">
                                    @stack('actions_button_start')
                                    <button type="button" onclick="$(this).tooltip('destroy'); $('#option-row-{{ $option_row }}').remove(); totalItem();" data-toggle="tooltip" title="{{ trans('general.delete') }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                    @stack('actions_button_end')
                                </td>
                                @stack('actions_td_end')

                                @stack('name_td_start')
                                <td>
                                    @stack('name_input_start')
                                    {!! Form::select('option_name', $options, empty($select_option) ? null : $select_option->option_id, array_merge(['id' => 'option-' . $option_row . '-name', 'class' => 'form-control select-option-name', 'placeholder' => trans('general.form.select.field', ['field' => trans_choice('inventory::general.options', 1)]), 'disabled' => 'disabled'])) !!}
                                    @stack('name_input_end')
                                </td>
                                @stack('name_td_end')

                                @stack('value_td_start')
                                <td>
                                    @stack('value_input_start')
                                    {!! Form::select('option_value[]', $select_option->option->values()->orderBy('name')->pluck('name', 'id'), $select_option->values()->pluck('option_value_id'), ['id'=> 'option-value-' . $option_row, 'class' => 'form-control option-value-select2 tax-select2', 'multiple' => 'true', 'disabled' => 'disabled']) !!}
                                    @stack('value_input_end')
                                </td>
                                @stack('value_td_end')
                            </tr>
                            @php $option_row++; @endphp
                            @stack('add_item_td_start')
                            <tr id="addOption" class="hidden">
                                <td class="text-center">
                                    <button type="button" id="button-add-option" data-toggle="tooltip" title="{{ trans('general.add') }}" class="btn btn-xs btn-primary" data-original-title="{{ trans('general.add') }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                                <td class="text-right" colspan="2"></td>
                            </tr>
                            @stack('add_item_td_end')
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group col-md-12">
                {!! Form::label('items', trans_choice('general.items', 2), ['class' => 'control-label']) !!}

                <div class="table-responsive">
                    <table class="table table-bordered" id="items">
                        <thead>
                            <tr style="background-color: #f9f9f9;">
                                @stack('name_th_start')
                                <th width="30%" class="text-left">{{ trans('general.name') }}</th>
                                @stack('name_th_end')
                                @stack('sku_th_start')
                                <th width="10%" class="text-center">{{ trans('items.sku') }}</th>
                                @stack('sku_th_end')
                                @stack('opening_stock_th_start')
                                <th width="10%" class="text-center">{{ trans('inventory::items.opening_stock') }}</th>
                                @stack('opening_stock_th_end')
                                @stack('opening_stock_value_th_start')
                                <th width="15%" class="text-right">{{ trans('inventory::items.opening_stock_value') }}</th>
                                @stack('opening_stock_value_th_end')
                                @stack('sales_price_th_start')
                                <th width="10%" class="text-right">{{ trans('items.sales_price') }}</th>
                                @stack('sales_price_th_end')
                                @stack('purchase_price_th_start')
                                <th width="10%" class="text-right">{{ trans('items.purchase_price') }}</th>
                                @stack('purchase_price_th_end')
                                @stack('reorder_level_th_start')
                                <th width="10%" class="text-right">{{ trans('inventory::items.reorder_level') }}</th>
                                @stack('reorder_level_th_end')
                            </tr>
                        </thead>

                        <tbody>
                            @php $item_row = 0; @endphp
                            @if(old('item'))
                                @foreach(old('item') as $old_item)
                                    @php $item = (object) $old_item; @endphp
                                    @include('inventory::item-groups.item')
                                    @php $item_row++; @endphp
                                @endforeach
                            @elseif(!empty($items))
                                @include('inventory::item-groups.item')
                            @else
                                <tr>
                                    <td colspan="7"> Please select options</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{ Form::radioGroup('enabled', trans('general.enabled')) }}
        </div>
        <!-- /.box-body -->

        @permission('update-common-items')
        <div class="box-footer">
            {{ Form::saveButtons('inventory/item-groups') }}
        </div>
        <!-- /.box-footer -->
        @endpermission
        {!! Form::close() !!}
    </div>
@endsection

@push('js')
    <script src="{{ asset('public/js/bootstrap-fancyfile.js') }}"></script>
    <script src="{{ asset('vendor/almasaeed2010/adminlte/plugins/colorpicker/bootstrap-colorpicker.js') }}"></script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-fancyfile.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/almasaeed2010/adminlte/plugins/colorpicker/bootstrap-colorpicker.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';
        var option_row = '{{ $option_row }}';
        var item_row = '{{ $item_row }}';

        $(document).ready(function(){
            $('#enabled_1').trigger('click');

            $('#name').focus();

            $('#tax_id').select2({
                placeholder: {
                    id: '-1', // the value of the option
                    text: "{{ trans('general.form.select.field', ['field' => trans_choice('general.taxes', 1)]) }}"
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                language: {
                    noResults: function () {
                        return '<span id="tax-add-new"><i class="fa fa-plus"></i> {{ trans('general.title.new', ['type' => trans_choice('general.tax_rates', 1)]) }}</span>';
                    }
                }
            });

            $('#option-0-name').select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('inventory::general.options', 1)]) }}"
            });

            $('#option-value-0').select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans('inventory::options.values')]) }}"
            });

            $("#category_id").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.categories', 1)]) }}"
            });

            $('#picture').fancyfile({
                text  : '{{ trans('general.form.select.file') }}',
                style : 'btn-default',
                placeholder : '{{ trans('general.form.no_file_selected') }}'
            });
        });

        $(document).on('click', '#button-add-option', function (e) {
            $.ajax({
                url: '{{ url("inventory/item-groups/addOption") }}',
                type: 'GET',
                dataType: 'JSON',
                data: {option_row: option_row},
                success: function(json) {
                    if (json['success']) {
                        $('#options tbody #addOption').before(json['html']);

                        $('[data-toggle="tooltip"]').tooltip('hide');

                        $('#option-' + option_row + '-name').select2({
                            placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('inventory::general.options', 1)]) }}"
                        });

                        option_row++;
                    }
                }
            });
        });

        $(document).on('change', '.select-option-name', function (e) {
            var select_option_name = $(this).attr('id');

            $.ajax({
                url: '{{ url("inventory/item-groups/getOptionValues") }}',
                type: 'GET',
                dataType: 'JSON',
                data: {option_id: $(this).val()},
                success: function(json) {
                    if (json['success']) {
                        $('#' + select_option_name).parent().parent().find('.typeahead').addClass('hidden');
                        $('#' + select_option_name).parent().parent().find('.option-value-select2').removeClass('hidden');

                        $('#' + select_option_name).parent().parent().find('.option-value-select2').empty();

                        $.each(json['data']['values'], function (id, name) {
                            $('#' + select_option_name).parent().parent().find('.option-value-select2').append($('<option>', {
                                value: id,
                                text : name
                            }));
                        });

                        $('[data-toggle="tooltip"]').tooltip('hide');

                        $('#' + select_option_name).parent().parent().find('.option-value-select2').select2({
                            placeholder: "{{ trans('general.form.select.field', ['field' => trans('inventory::options.values')]) }}"
                        });

                        option_row++;
                    }
                }
            });
        });

        $(document).on('change', '.option-value-select2', function (e) {
            var option_id = $(this).parent().parent().find('.select-option-name').val();

            $.ajax({
                url: '{{ url("inventory/item-groups/addItem") }}',
                type: 'GET',
                dataType: 'JSON',
                data: {item_row: item_row, name: $('#name').val(), option_id: option_id, values: $(this).val()},
                success: function(json) {
                    if (json['success']) {
                        $('#items tbody').html(json['html']);
                    }
                }
            });
        });

        $(document).on('click', '.select2-results__option.select2-results__message', function(e) {
            tax_name = $('.select2-search__field').val();

            $('body > .select2-container.select2-container--default.select2-container--open').remove();

            $('#modal-create-tax').remove();

            $.ajax({
                url: '{{ url("modals/taxes/create") }}',
                type: 'GET',
                dataType: 'JSON',
                data: {name: tax_name},
                success: function(json) {
                    if (json['success']) {
                        $('body').append(json['html']);
                    }
                }
            });
        });

        $(document).on('click', '#button-category', function (e) {
            $('#modal-create-category').remove();

            $.ajax({
                url: '{{ url("modals/categories/create") }}',
                type: 'GET',
                dataType: 'JSON',
                data: {type: 'item'},
                success: function(json) {
                    if (json['success']) {
                        $('body').append(json['html']);
                    }
                }
            });
        });

        $(document).on('hidden.bs.modal', '#modal-create-tax', function () {
            $('#tax_id').select2({
                placeholder: {
                    id: '-1', // the value of the option
                    text: "{{ trans('general.form.select.field', ['field' => trans_choice('general.taxes', 1)]) }}"
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                language: {
                    noResults: function () {
                        return '<span id="tax-add-new"><i class="fa fa-plus-circle"></i> {{ trans('general.title.new', ['type' => trans_choice('general.tax_rates', 1)]) }}</span>';
                    }
                }
            });
        });
    </script>
@endpush

@push('stylesheet')
    <style type="text/css">
        .select2-results__option.select2-results__message:hover {
            color: white;
            background: #6da252;
            cursor: pointer;
        }

        #options .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #f4f4f4;
            color: #444;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }

        #options .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #444;
        }

        #options span.select2.select2-container.select2-container--default .select2-selection.select2-selection--multiple {
            border-color: #d2d6de;
            border-radius: 0;
        }

        #options .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #6da252;
            border-radius: 0;
        }

        #options .select2-search__field {
            padding-left: 15px;
            margin-top: 6px;
        }
    </style>
@endpush
