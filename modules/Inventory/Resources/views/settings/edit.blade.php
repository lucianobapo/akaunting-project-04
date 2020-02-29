@extends('layouts.admin')

@section('title', trans_choice('general.settings', 2))

@section('content')
    <div class="row">
        {!! Form::open(['route' => 'inventory.settings.update', 'files' => true, 'role' => 'form']) !!}

        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans_choice('inventory::general.warehouses', 1) }}</h3>
                </div>
                <div class="box-body">
                    {{ Form::selectGroup('default_warehouse', trans('inventory::warehouses.default'), 'building', $warehouses, old('default_warehouse', setting('inventory.default_warehouse'))) }}
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-footer">
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            {!! Form::button('<span class="fa fa-save"></span> &nbsp;' . trans('general.save'), ['type' => 'submit', 'class' => 'btn btn-success  button-submit', 'data-loading-text' => trans('general.loading')]) !!}
                            <a href="{{ url('/') }}" class="btn btn-default"><span class="fa fa-times-circle"></span> &nbsp;{{ trans('general.cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#default_warehouse").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('inventory::general.warehouses', 1)]) }}"
            });
        });
    </script>
@endpush
