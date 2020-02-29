@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('inventory::general.warehouses', 1)]))

@section('content')
    <!-- Default box -->
    <div class="box box-success">
        {!! Form::model($warehouse, [
            'method' => 'PATCH',
            'url' => ['inventory/warehouses', $warehouse->id],
            'role' => 'form',
            'class' => 'form-loading-button'
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('name', trans('general.name'), 'id-card-o') }}

            {{ Form::textGroup('email', trans('general.email'), 'envelope', []) }}

            {{ Form::textGroup('phone', trans('general.phone'), 'phone', []) }}

            {{ Form::textareaGroup('address', trans('general.address')) }}

            {{ Form::radioGroup('enabled', trans('general.enabled')) }}
        </div>
        <!-- /.box-body -->

        @permission('update-inventory-warehouses')
        <div class="box-footer">
            {{ Form::saveButtons('inventory/warehouses') }}
        </div>
        <!-- /.box-footer -->
        @endpermission

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        $(document).ready(function(){
            $('#name').focus();
        });
    </script>
@endpush
