@extends('layouts.admin')

@section('title', trans_choice('inventory::general.histories', 2))

@section('content')
    <!-- Default box -->
    <div class="box box-success">
        <div class="box-header with-border">
            {!! Form::open(['url' => 'inventory/histories', 'role' => 'form', 'method' => 'GET']) !!}
            <div class="pull-left">
                <span class="title-filter hidden-xs">{{ trans('general.search') }}:</span>
                {!! Form::text('search', request('search'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans('general.search_placeholder')]) !!}
                {!! Form::button('<span class="fa fa-filter"></span> &nbsp;' . trans('general.filter'), ['type' => 'submit', 'class' => 'btn btn-sm btn-default btn-filter']) !!}
            </div>

            <div class="pull-right">
                <span class="title-filter hidden-xs">{{ trans('general.show') }}:</span>
                {!! Form::select('limit', $limits, request('limit', setting('general.list_limit', '25')), ['class' => 'form-control input-filter input-sm', 'onchange' => 'this.form.submit()']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-header -->

        <div class="box-body">
            <div class="table table-responsive">
                <table class="table table-striped table-hover" id="tbl-histories">
                    <thead>
                        <tr>
                            <th class="col-md-4">{{ trans_choice('general.items', 1) }}</th>
                            <th class="col-md-4">{{ trans_choice('general.vendors', 1) }}</th>
                            <th class="col-md-2">{{ trans('invoices.quantity') }}</th>
                            <th class="col-md-2">{{ trans('general.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($histories as $item)
                        <tr>
                            <td>
                                <a href="{{ url('common/items/' . $item->item_id) }}">{{ $item->item->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('warehouses.show', [$item->warehouse_id]) }}">{{ $item->warehouse->name }}</a>
                            </td>
                            <td>
                                {{ $item->quantity }}
                            </td>
                            <td>
                                <a href="{{ url($item->action_url) }}">{{ $item->action_text }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            @include('partials.admin.pagination', ['items' => $histories, 'type' => 'histories', 'title' => trans_choice('inventory::general.histories', 2)])
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@endsection
