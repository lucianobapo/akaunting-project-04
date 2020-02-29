@stack($name . '_input_start')

    <div class="form-group {{ $col }} {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : ''}}">
        {!! Form::label($name, $text, ['class' => 'control-label']) !!}
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-{{ $icon }}"></i></div>
            {!! Form::select($name, $values, $selected, 
            	array_merge(
            		[
            			'class' => 'form-control', 
            			'placeholder' => trans('general.form.select.field', ['field' => $text])
            		], $attributes)
            ) !!}
            @if(!is_null($button_id))
                <span class="input-group-btn">
                	<button type="button" id="{{ $button_id }}" class="btn btn-default btn-icon"><i class="fa fa-{{ $button_icon }}"></i></button>
            	</span>
        	@endif
        </div>
        {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
    </div>

@stack($name . '_input_end')