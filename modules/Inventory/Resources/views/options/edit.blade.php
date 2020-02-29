@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('inventory::general.options', 1)]))

@section('content')
    <!-- Default box -->
    <div class="box box-success">
        {!! Form::model($option, [
            'method' => 'PATCH',
            'url' => ['inventory/options', $option->id],
            'role' => 'form',
            'class' => 'form-loading-button'
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('name', trans('general.name'), 'id-card-o') }}

            {{ Form::selectGroup('type', trans_choice('general.types', 1), 'exchange', $types) }}

            @php
            $class = ($option->type == 'text' || $option->type == 'textarea') ? ' hidden' : '';
            @endphp
            <div id="option-values" class="form-group col-md-12{{ $class }}">
                {!! Form::label('items', trans('inventory::options.values'), ['class' => 'control-label']) !!}
                <div class="table-responsive">
                    <table class="table table-bordered" id="items">
                        <thead>
                            <tr style="background-color: #f9f9f9;">
                                <th width="5%"  class="text-center">{{ trans('general.actions') }}</th>
                                <th width="40%" class="text-left">{{ trans('general.name') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                        @php $item_row = 0; @endphp
                            @if ($option->values)
                                @foreach($option->values as $value)
                                <tr id="item-row-{{ $item_row }}">
                                    <td class="text-center" style="vertical-align: middle;">
                                        <button type="button" onclick="$(this).tooltip('destroy'); $('#item-row-{{ $item_row }}').remove();" data-toggle="tooltip" title="{{ trans('general.delete') }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                </td>
                                    <td>
                                        <input value="{{ $value->name }}" class="form-control typeahead" placeholder="{{ trans('general.form.enter', ['field' => trans_choice('invoices.item_name', 1)]) }}" name="item[{{ $item_row }}][name]" type="text" id="item-name-{{ $item_row }}" autocomplete="off">
                                    </td>
                                </tr>
                                @php $item_row++; @endphp
                                @endforeach
                            @endif
                            <tr id="item-row-{{ $item_row }}">
                                <td class="text-center" style="vertical-align: middle;">
                                    <button type="button" onclick="$(this).tooltip('destroy'); $('#item-row-{{ $item_row }}').remove();" data-toggle="tooltip" title="{{ trans('general.delete') }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                </td>
                                <td>
                                    <input value="" class="form-control typeahead" placeholder="{{ trans('general.form.enter', ['field' => trans_choice('invoices.item_name', 1)]) }}" name="item[{{ $item_row }}][name]" type="text" id="item-name-{{ $item_row }}" autocomplete="off">
                                </td>
                            </tr>
                            @php $item_row++; @endphp
                            <tr id="addItem">
                                <td class="text-center"><button type="button" id="button-add-item" data-toggle="tooltip" title="{{ trans('general.add') }}" class="btn btn-xs btn-primary" data-original-title="{{ trans('general.add') }}"><i class="fa fa-plus"></i></button></td>
                                <td class="text-right"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{ Form::radioGroup('enabled', trans('general.enabled')) }}
        </div>
        <!-- /.box-body -->

        @permission('update-inventory-options')
        <div class="box-footer">
            {{ Form::saveButtons('inventory/options') }}
        </div>
        <!-- /.box-footer -->
        @endpermission

        {!! Form::close() !!}
    </div>
@endsection

@push('js')
    <script src="{{ asset('vendor/almasaeed2010/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/almasaeed2010/adminlte/plugins/iCheck/square/green.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';
        var item_row = '{{ $item_row }}';

        $(document).ready(function(){
            $('#name').focus();

            $("#type").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.types', 1)]) }}"
            });
        });

        $(document).on('change', '#type', function (e) {
            type = $(this).val();

            if (type == 'select' || type == 'radio' ||type == 'checkbox') {
                $('#option-values').removeClass('hidden');
            } else {
                $('#option-values').addClass('hidden');
            }
        });

        $(document).on('click', '#button-add-item', function (e) {
            var item_html  = '<tr id="item-row-' + item_row +'">';
            item_html += '  <td class="text-center" style="vertical-align: middle;">';
            item_html += '      <button type="button" onclick="$(this).tooltip(\'destroy\'); $(\'#item-row-' + item_row + '\').remove();" data-toggle="tooltip" title="{{ trans('general.delete') }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';
            item_html += '  </td>';
            item_html += '  <td>';
            item_html += '      <input value="" class="form-control typeahead" placeholder="{{ trans('general.form.enter', ['field' => trans_choice('invoices.item_name', 1)]) }}" name="item[' + item_row +'][name]" type="text" id="item-name-' + item_row +'" autocomplete="off">';
            item_html += '  </td>';
            item_html += '</tr>';

            $('#items tbody #addItem').before(item_html);

            item_row++;
        });
    </script>
@endpush
