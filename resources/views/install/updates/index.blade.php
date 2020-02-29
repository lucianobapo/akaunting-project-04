@extends('layouts.admin')

@section('title', trans_choice('general.updates', 2))

@section('new_button')
<span class="new-button"><a href="{{ url('install/updates/check') }}" class="btn btn-default btn-sm"><span class="fa fa-history"></span> &nbsp;{{ trans('updates.check') }}</a></span>
@endsection

@section('content')
@if (!empty($core->errors))
    @foreach($core->errors as $alias => $error)
        @php $callout_class = ($alias == 'core_modules') ? 'callout-warning' : 'callout-danger'; @endphp
        <div class="callout {{ $callout_class }}">
            <p>{!! $error !!}</p>
        </div>
    @endforeach
@endif
@if (!empty($expires))
    @foreach ($expires as $error)
        <div class="callout callout-danger">
            <p>{!! $error !!}</p>
        </div>
    @endforeach
@endif
@if (!empty($requirements))
    @foreach ($requirements as $error)
        <div class="callout callout-danger">
            <p>{!! $error !!}</p>
        </div>
    @endforeach
@endif
@if (empty($core->errors) && empty($expires) && empty($requirements))
    <div class="callout callout-warning">
        <p>It is <strong>HIGHLY RECOMMENDED</strong> that files and database are backed up prior to applying this MAJOR update.</p>
    </div>
@endif

<!-- Default box -->
<div class="box box-success">
    <div class="box-header with-border">
        <i class="fa fa-gear"></i>
        <h3 class="box-title">Akaunting</h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        @if (empty($core))
        {{ trans('updates.latest_core') }}
        @else
            @if (empty($core->errors) && empty($requirements))
            {{ trans('updates.new_core') }}
            &nbsp;&nbsp;<a href="{{ url('install/updates/update', ['alias' => 'core', 'version' => $core->data->latest]) }}" id="update" data-toggle="tooltip" title="{{ trans('updates.update', ['version' => $core->data->latest]) }}" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> &nbsp;{{ trans('updates.update', ['version' => $core->data->latest]) }}</a>
            <a href="{{ url('install/updates/changelog') }}" id="changelog" data-toggle="tooltip" title="{{ trans('updates.changelog') }}" class="btn btn-default btn-xs popup"><i class="fa fa-exchange"></i> &nbsp;{{ trans('updates.changelog') }}</a>
            @else
            {{ trans('updates.new_core') }}
            &nbsp;&nbsp;
            <button type="button" class="btn btn-warning btn-xs" disabled>
                <i class="fa fa-refresh"></i> &nbsp;{{ trans('updates.update', ['version' => $core->data->latest]) }}
            </button>
            @if (empty($expires) && empty($requirements))
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{ url('install/updates/update', ['alias' => 'core', 'version' => $core->data->latest]) }}" id="update" data-toggle="tooltip" title="WARNING: Files of not compatible apps will be deleted." class="btn btn-danger btn-xs"><i class="fa fa-warning"></i> &nbsp; FORCE UPDATE</a>
            @endif
            @endif
        @endif
    </div>
    <!-- /.box-body -->

</div>
<!-- /.box -->

<!-- Default box -->
<div class="box box-success">
    <div class="box-header with-border">
        <i class="fa fa-rocket"></i>
        <h3 class="box-title">{{ trans_choice('general.modules', 2) }}</h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <div class="table table-responsive">
            <table class="table table-striped table-hover" id="tbl-translations">
                <thead>
                    <tr>
                        <th class="col-md-4">{{ trans('general.name') }}</th>
                        <th class="col-md-2">{{ trans_choice('general.categories', 1) }}</th>
                        <th class="col-md-2">{{ trans('updates.installed_version') }}</th>
                        <th class="col-md-2">{{ trans('updates.latest_version') }}</th>
                        <th class="col-md-2">{{ trans_choice('general.statuses', 1) }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($modules as $module)
                    <tr>
                        <td>{{ $module->name }}</td>
                        <td>{{ $module->category }}</td>
                        <td>{{ $module->installed }}</td>
                        <td>{{ $module->latest }}</td>
                        <td>
                            @if (!empty($module->errors))
                                <span class="label label-danger">{{ trans('general.not_compatible') }}</span>
                            @else
                                <span class="label label-success">{{ trans('general.avaible') }}</span>
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
@endsection

@push('stylesheet')
    <style>
        .loading-spin {
            margin-left: 10px;
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('#update').click(function(event) {
            $(this).html('Updating Akaunting... Please, don\'t close this window!');
            $(this).tooltip('disable');
            $(this).removeClass('btn-xs');
            $(this).removeClass('btn-warning');
            $(this).addClass('btn-sm');
            $(this).addClass('btn-danger');
            $(this).after('<div class="loading-spin"><i class="fa fa-spinner fa-3x fa-spin fa-fw" aria-hidden="true"></i></div>');

            $('#changelog').hide();

            return true;
        });
    });
</script>
@endpush
