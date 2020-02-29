@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('erpnet-profiting-milk::general.title', 1)]))

@section('content')
    @if (($recurring = $model->recurring) && ($next = $recurring->next()))
        <div class="callout callout-info">
            <h4>{{ trans('recurring.recurring') }}</h4>

            <p>{{ trans('recurring.message', [
                    'type' => mb_strtolower(trans_choice('erpnet-profiting-milk::general.title', 1)),
                    'date' => $next->format($date_format)
                ]) }}
            </p>
        </div>
    @endif

    <!-- Default box -->
    <div class="box box-success">
        {!! Form::model($model, [
            'method' => 'PATCH',
            'files' => true,
            'route' => ['production.update', $model->id],
            'role' => 'form',
            'class' => 'form-loading-button'
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('posted_at', trans('general.date'), 'calendar', ['id' => 'posted_at', 'class' => 'form-control', 'required' => 'required', 'data-inputmask' => '\'alias\': \'yyyy-mm-dd\'', 'data-mask' => '', 'autocomplete' => 'off'], Date::parse($model->posted_at)->toDateString()) }}

            {{ Form::textGroup('quantity', trans('general.quantity'), 'money', ['required' => 'required', 'autofocus' => 'autofocus']) }}

            {{ Form::selectGroup('vendor_id', trans_choice('general.vendors', 1), 'user', $vendors) }}
         	
         	{{ Form::selectGroup('category_id', trans_choice('general.categories', 1), 'folder-open-o', $categories) }}

            {{ Form::textareaGroup('description', trans('general.description')) }}

            {{ Form::recurring('edit', $model) }}

            {{ Form::textGroup('reference', trans('general.reference'), 'file-text-o',[]) }}

            {{ Form::fileGroup('attachment', trans('general.attachment')) }}
        </div>
        <!-- /.box-body -->

        @permission('update-productions')
            <div class="box-footer">
                {{ Form::saveButtons(route('production.index')) }}
            </div>
            <!-- /.box-footer -->
        @endpermission
    </div>

      {!! Form::close() !!}
@endsection

@push('js')
    <script src="{{ asset('vendor/almasaeed2010/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    @if (language()->getShortCode() != 'en')
    <script src="{{ asset('vendor/almasaeed2010/adminlte/plugins/datepicker/locales/bootstrap-datepicker.' . language()->getShortCode() . '.js') }}"></script>
    @endif
    <script src="{{ asset('public/js/bootstrap-fancyfile.js') }}"></script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/almasaeed2010/adminlte/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-fancyfile.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){            

            //Date picker
            $('#posted_at').datepicker({
                format: 'yyyy-mm-dd',
                todayBtn: 'linked',
                weekStart: 1,
                autoclose: true,
                language: '{{ language()->getShortCode() }}'
            });

            $("#category_id").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.categories', 1)]) }}"
            });

            $("#vendor_id").select2({
                placeholder: {
                    id: '-1', // the value of the option
                    text: "{{ trans('general.form.select.field', ['field' => trans_choice('general.vendors', 1)]) }}"
                }
            });


            $('#attachment').fancyfile({
                text  : '{{ trans('general.form.select.file') }}',
                style : 'btn-default',
                @if($model->attachment)
                placeholder : '{{ $model->attachment->basename }}'
                @else
                placeholder : '{{ trans('general.form.no_file_selected') }}'
                @endif
            });

            @if($model->attachment)
                $.ajax({
                    url: '{{ url('uploads/' . $model->attachment->id . '/show') }}',
                    type: 'GET',
                    data: {column_name: 'attachment'},
                    dataType: 'JSON',
                    success: function(json) {
                        if (json['success']) {
                            $('.fancy-file').after(json['html']);
                        }
                    }
                });
    
                @permission('delete-common-uploads')
                    $(document).on('click', '#remove-attachment', function (e) {
                        confirmDelete("#attachment-{!! $model->attachment->id !!}", "{!! trans('general.attachment') !!}", "{!! trans('general.delete_confirm', ['name' => '<strong>' . $model->attachment->basename . '</strong>', 'type' => strtolower(trans('general.attachment'))]) !!}", "{!! trans('general.cancel') !!}", "{!! trans('general.delete')  !!}");
                    });
                @endpermission
            @endif
        });

        
    </script>
@endpush
