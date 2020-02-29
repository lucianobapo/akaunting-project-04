<tr id="option-row-{{ $option_row }}">
    @stack('actions_td_start')
    <td class="text-center hidden" style="vertical-align: middle;">
        @stack('actions_button_start')
        <button type="button" onclick="$(this).tooltip('destroy'); $('#option-row-{{ $option_row }}').remove(); totalItem();" data-toggle="tooltip" title="{{ trans('general.delete') }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
        @stack('actions_button_end')
    </td>
    @stack('actions_td_end')

    @stack('name_td_start')
    <td {!! $errors->has('option.' . $option_row . '.name') ? 'class="has-error"' : ''  !!}>
        @stack('name_input_start')
        {!! Form::select('option[' . $option_row . '][name]', $options, (old('option.0.name') ? old('option.0.name')  : empty($select_option) ? null : $select_option->option_id), array_merge(['id' => 'option-' . $option_row . '-name', 'class' => 'form-control select-option-name', 'placeholder' => trans('general.form.select.field', ['field' => trans_choice('inventory::general.options', 1)])])) !!}
        {!! $errors->first('option.' . $option_row . '.name', '<p class="help-block">:message</p>') !!}
        @stack('name_input_end')
    </td>
    @stack('name_td_end')

    @stack('value_td_start')
    <td {{ $errors->has('option.' . $option_row . '.value') ? 'class="has-error"' : '' }}>
        @stack('value_input_start')
        @if (empty($select_option))
            <input name="option[{{ $option_row  }}][text_value]" value="" class="form-control text_value typeahead" required="required" placeholder="{{ trans('general.form.enter', ['field' => trans('inventory::options.values')]) }}" type="text" id="option-value-input-{{ $option_row }}" autocomplete="off" disabled>
            {!! Form::select('option[' . $option_row . '][value][]', [], 'default_value', ['id'=> 'option-value-' . $option_row, 'class' => 'hidden form-control option-value-select2 tax-select2', 'multiple' => 'true']) !!}
            {!! $errors->first('option.' . $option_row . '.value', '<p class="help-block">:message</p>') !!}
        @else
            {!! Form::select('option[' . $option_row . '][value][]', $select_option->option->values()->orderBy('name')->pluck('name', 'id'), $select_option->values()->pluck('option_value_id'), ['id'=> 'option-value-' . $option_row, 'class' => 'form-control option-value-select2 tax-select2', 'multiple' => 'true']) !!}
            {!! $errors->first('option.' . $option_row . '.value', '<p class="help-block">:message</p>') !!}
        @endif
    @stack('value_input_end')
    </td>
    @stack('value_td_end')
</tr>
