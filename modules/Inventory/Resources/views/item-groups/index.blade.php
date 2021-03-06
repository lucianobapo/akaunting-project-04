@extends('layouts.admin')

@section('title', trans_choice('inventory::general.item_groups', 2))

@section('new_button')
@permission('create-inventory-item-groups')
<span class="new-button"><a href="{{ route('item-groups.create') }}" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> &nbsp;{{ trans('general.add_new') }}</a></span>
@endpermission
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-success">
        <div class="box-header with-border">
            {!! Form::open(['route' => 'item-groups.index', 'role' => 'form', 'method' => 'GET']) !!}
            <div id="items" class="pull-left box-filter">
                <span class="title-filter hidden-xs">{{ trans('general.search') }}:</span>
                {!! Form::text('search', request('search'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans('general.search_placeholder')]) !!}
                {!! Form::select('categories[]', $categories, request('categories'), ['id' => 'filter-categories', 'class' => 'form-control input-filter input-lg', 'multiple' => 'multiple']) !!}
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
                <table class="table table-striped table-hover" id="tbl-item-groups">
                    <thead>
                        <tr>
                            <th class="col-md-1 hidden-xs">{{ trans_choice('general.pictures', 1) }}</th>
                            <th class="col-md-4">@sortablelink('name', trans('general.name'))</th>
                            <th class="col-md-3 hidden-xs">@sortablelink('category', trans_choice('general.categories', 1))</th>
                            <th class="col-md-2 hidden-xs">{{ trans_choice('general.items', 2) }}</th>
                            <th class="col-md-1 hidden-xs">@sortablelink('enabled', trans_choice('general.statuses', 1))</th>
                            <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($item_groups as $item_group)
                        <tr>
                            <td class="hidden-xs"><img src="{{ $item_group->picture ? Storage::url($item_group->picture->id) : asset('public/img/akaunting-logo-green.png') }}" class="img-thumbnail" width="50" alt="{{ $item_group->name }}"></td>
                            <td><a href="{{ route('item-groups.edit', $item_group->id) }}">{{ $item_group->name }}</a></td>
                            <td class="hidden-xs">{{ $item_group->category ? $item_group->category->name : trans('general.na') }}</td>
                            <td class="hidden-xs">{{ $item_group->items->count() }}</td>
                            <td class="hidden-xs">
                                @if ($item_group->enabled)
                                    <span class="label label-success">{{ trans('general.enabled') }}</span>
                                @else
                                    <span class="label label-danger">{{ trans('general.disabled') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('item-groups.edit', $item_group->id) }}">{{ trans('general.edit') }}</a></li>
                                        @if ($item_group->enabled)
                                            <li><a href="{{ route('item-groups.disable', $item_group->id) }}">{{ trans('general.disable') }}</a></li>
                                        @else
                                            <li><a href="{{ route('item-groups.enable', $item_group->id) }}">{{ trans('general.enable') }}</a></li>
                                        @endif
                                        @permission('create-inventory-item-groups')
                                        <li class="divider"></li>
                                        <li><a href="{{ route('item-groups.duplicate', $item_group->id) }}">{{ trans('general.duplicate') }}</a></li>
                                        @endpermission
                                        @permission('delete-inventory-item-groups')
                                        <li class="divider"></li>
                                        <li>{!! Form::deleteLink($item_group, 'inventory/item-groups') !!}</li>
                                        @endpermission
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            @include('partials.admin.pagination', ['items' => $item_groups, 'type' => 'item_groups', 'title' => trans_choice('inventory::item_groups', 2), 'title' => trans_choice('inventory::general.item_groups', 2)])
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#filter-categories").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.categories', 1)]) }}"
            });
        });
    </script>
@endpush
