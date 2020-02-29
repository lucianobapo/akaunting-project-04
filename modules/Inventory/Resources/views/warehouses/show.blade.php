@extends('layouts.admin')

@section('title', $warehouse->name)

@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- Profile -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('auth.profile') }}</h3>
                </div>
                <div class="box-body box-profile">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item" style="border-top: 0;">
                            <b>{{ trans('general.email') }}</b> <a class="pull-right">{{ $warehouse->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ trans('general.phone') }}</b> <a class="pull-right">{{ $warehouse->phone }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- Address Box -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('general.address') }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="text-muted">
                        {{ $warehouse->address }}
                    </p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- Edit -->
            <div>
                <a href="{{ url('inventory/warehouses/' . $warehouse->id . '/edit') }}" class="btn btn-primary btn-block">
                    <b>{{ trans('general.edit') }}</b>
                </a>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->

        <div class="col-md-9">
            <!-- Default box -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="no-margin">{{ trans_choice('general.items', 2) }}</h4>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div class="table table-responsive">
                        <table class="table table-striped table-hover" id="tbl-items">
                            <thead>
                            <tr>
                                <th class="col-md-1 hidden-xs">{{ trans_choice('general.pictures', 1) }}</th>
                                <th class="col-md-3">{{ trans('general.name') }}</th>
                                <th class="col-md-1 hidden-xs">{{ trans_choice('general.categories', 1) }}</th>
                                <th class="col-md-1 hidden-xs">{{ trans_choice('items.quantities', 1) }}</th>
                                <th class="col-md-2 text-right amount-space">{{ trans('items.sales_price') }}</th>
                                <th class="col-md-2 hidden-xs text-right amount-space">{{ trans('items.purchase_price') }}</th>
                                <th class="col-md-1 hidden-xs">{{ trans_choice('general.statuses', 1) }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($warehouse->items as $item)
                                @php $item = $item->item; @endphp
                                <tr>
                                    <td class="hidden-xs"><img src="{{ $item->picture ? Storage::url($item->picture->id) : asset('public/img/akaunting-logo-green.png') }}" class="img-thumbnail" width="50" alt="{{ $item->name }}"></td>
                                    <td><a href="{{ route('items.edit', $item->id) }}">{{ $item->name }}</a></td>
                                    <td class="hidden-xs">{{ $item->category ? $item->category->name : trans('general.na') }}</td>
                                    <td class="hidden-xs">{{ $item->quantity }}</td>
                                    <td class="text-right amount-space">{{ money($item->sale_price, setting('general.default_currency'), true) }}</td>
                                    <td class="hidden-xs text-right amount-space">{{ money($item->purchase_price, setting('general.default_currency'), true) }}</td>
                                    <td class="hidden-xs">
                                        @if ($item->enabled)
                                            <span class="label label-success">{{ trans('general.enabled') }}</span>
                                        @else
                                            <span class="label label-danger">{{ trans('general.disabled') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
