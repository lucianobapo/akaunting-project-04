@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('inventory::general.manufacturers', 1)]))

@section('content')
    <!-- Default box -->
    <div class="box box-success">
        {!! Form::model($manufacturer, [
            'method' => 'PATCH',
            'url' => ['inventory/manufacturers', $manufacturer->id],
            'role' => 'form',
            'class' => 'form-loading-button'
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('name', trans('general.name'), 'id-card-o') }}

            {{ Form::textareaGroup('description', trans('general.description')) }}

            {{ Form::radioGroup('enabled', trans('general.enabled')) }}

            @stack('create_vendor_input_start')
            <div  id="customer-create-vendor" class="form-group col-md-12 margin-top">
                @if ($manufacturer->manufacturer_vendors()->count())
                    <strong>{{ trans('inventory::manufacturers.vendor_created') }}</strong> &nbsp; {{ Form::checkbox('create_vendor', '1', 1, ['id' => 'create_vendor', 'disabled' => 'disabled']) }}
                @else
                    <strong>{{ trans('inventory::manufacturers.allow_vendor') }}</strong> &nbsp; {{ Form::checkbox('create_vendor', '1', null, ['id' => 'create_vendor']) }}
                @endif
            </div>
            @stack('create_vendor_input_end')

            @if ($manufacturer->manufacturer_vendors()->count())
            {{ Form::selectGroup('vendor_id', trans_choice('general.vendors', 1), 'user', $vendors, $manufacturer->manufacturer_vendors()->first()->vendor_id) }}
            @else
            @stack('vendor_id_input_start')
            <div class="vendor form-group col-md-6 hidden required {{ $errors->has('vendor_id') ? 'has-error' : ''}}">
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
            @endif
        </div>
        <!-- /.box-body -->

        @permission('update-inventory-manufacturers')
        <div class="box-footer">
            {{ Form::saveButtons('inventory/manufacturers') }}
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

        $(document).ready(function(){
            @if (old('create_vendor'))
            $('.vendor.form-group.col-md-6').removeClass('hidden');
            @endif

            $('#name').focus();

            $('#vendor_id').select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.vendors', 1)]) }}"
            });

            $('#create_vendor').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%'
            });

            $('#create_vendor').on('ifClicked', function (event) {
                if (!$(this).prop('checked')) {
                    $('.vendor.form-group.col-md-6').removeClass('hidden');
                } else {
                    $('.vendor.form-group.col-md-6').addClass('hidden');
                }
            });
        });

        @if (empty($manufacturer->vendor))
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
        @endif
    </script>
@endpush
