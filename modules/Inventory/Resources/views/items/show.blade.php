@extends('layouts.admin')

@section('title', $item->name)

@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- Stats -->
            <div class="box box-success">
                <div class="box-body box-profile">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item" style="border-top: 0;">
                            <b>{{ trans_choice('general.invoices', 2) }}</b> <a class="pull-right">{{ $counts['invoices'] }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ trans_choice('general.bills', 2) }}</b> <a class="pull-right">{{ $counts['bills'] }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- Profile -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('inventory::general.information') }}</h3>
                </div>

                <div class="box-body box-profile">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item" style="border-top: 0;">
                            <b>{{ trans('items.sku') }}</b> <a class="pull-right">{{ $item->sku }}</a>
                        </li>

                        <li class="list-group-item">
                            <b>{{ trans('items.sales_price') }}</b> <a class="pull-right">@money($item->sale_price, setting('general.default_currency'), true)</a>
                        </li>

                        <li class="list-group-item">
                            <b>{{ trans('items.purchase_price') }}</b> <a class="pull-right">@money($item->purchase_price, setting('general.default_currency'), true)</a>
                        </li>

                        <li class="list-group-item">
                            <b>{{ trans_choice('general.categories', 1) }}</b> <a class="pull-right">{{ $item->category->name }}</a>
                        </li>

                        @if ($item->tax)
                        <li class="list-group-item">
                            <b>{{ trans_choice('general.taxes', 1) }}</b> <a class="pull-right">{{ $item->tax->name }}</a>
                        </li>
                        @endif

                        <li class="list-group-item">
                            <b>{{ trans_choice('general.statuses', 1) }}</b>
                            <a class="pull-right">
                                @if ($item->enabled)
                                    <span class="label label-success">{{ trans('general.enabled') }}</span>
                                @else
                                    <span class="label label-danger">{{ trans('general.disabled') }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- Address Box -->
            @if ($item_inventory)
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('inventory::general.title') }}</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <ul class="list-group list-group-unbordered">
                        @if ($item_inventory->opening_stock)
                        <li class="list-group-item" style="border-top: 0;">
                            <b>{{ trans('inventory::items.opening_stock') }}</b> <a class="pull-right">{{ $item_inventory->opening_stock }}</a>
                        </li>
                        @endif

                        @if ($item_inventory->opening_stock_value)
                        <li class="list-group-item">
                            <b>{{ trans('inventory::items.opening_stock_value') }}</b> <a class="pull-right">@money($item_inventory->opening_stock_value, setting('general.default_currency'), true)</a>
                        </li>
                        @endif

                        @if ($item_inventory->reorder_level)
                        <li class="list-group-item">
                            <b>{{ trans('inventory::items.reorder_level') }}</b> <a class="pull-right">{{ $item_inventory->reorder_level }}</a>
                        </li>
                        @endif

                        @if ($item_warehouse)
                        <li class="list-group-item">
                            <b>{{ trans_choice('inventory::general.warehouses', 1) }}</b> <a class="pull-right">{{ $item_warehouse->warehouse->name }}</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            @endif
            <!-- /.box -->

            <!-- Edit -->
            <div>
                <a href="{{ url('common/items/' . $item->id . '/edit') }}" class="btn btn-primary btn-block"><b>{{ trans('general.edit') }}</b></a>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->

        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4 col-sm-8 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ trans('general.paid') }}</span>
                            <span class="info-box-number">@money($amounts['paid'], setting('general.default_currency'), true)</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-md-4 col-sm-8 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-paper-plane-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ trans('dashboard.open_invoices') }}</span>
                            <span class="info-box-number">@money($amounts['open'], setting('general.default_currency'), true)</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-md-4 col-sm-8 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-warning"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ trans('dashboard.overdue_invoices') }}</span>
                            <span class="info-box-number">@money($amounts['overdue'], setting('general.default_currency'), true)</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#histories" data-toggle="tab" aria-expanded="true">{{ trans_choice('general.transactions', 2) }}</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane tab-margin active" id="histories">
                                <div class="table table-responsive">
                                    <table class="table table-striped table-hover" id="tbl-histories">
                                        <thead>
                                            <tr>
                                                <th class="col-md-4">{{ trans_choice('general.vendors', 1) }}</th>
                                                <th class="col-md-2">{{ trans('invoices.quantity') }}</th>
                                                <th class="col-md-2">{{ trans('general.actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($item_histories as $item)
                                            <tr>
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
