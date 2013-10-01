<div class="form-group">

	<label for="{{ $setting['css_id'] }}" class="col-lg-3 control-label">
		{{ $setting['name'] }}

		@if ($info = $setting['info'])
		<i class="icon-info" data-toggle="popover" data-content="{{{ $info }}}"></i>
		@endif
	</label>

	<div class="col-lg-9">

		@if ($setting['type'] == 'dropdown')

			<select class="form-control" name="{{ $setting['form_name'] }}" id="{{ $setting['css_id'] }}">
				@foreach ($setting['options'] as $option)
					<option value='{{ $option["value"] }}' {{ $option['value'] === $setting['value'] ? 'selected' : '' }}>
						{{ array_get($option, 'label', $option['value']) }}
					</option>
				@endforeach
			</select>

		@elseif ($setting['type'] == 'radio')

			@foreach ($setting['options'] as $option)

				<label class="radio-inline">
					<input type="radio" name="{{ $setting['form_name'] }}" value='{{ $option["value"] }}' {{ $option['value'] === $setting['value'] ? 'checked' : '' }}>
					{{ array_get($option, 'label', $option['value']) }}
				</label>

			@endforeach

		@elseif ($setting['type'] == 'textarea')

			<textarea class="form-control" name="{{ $setting['form_name'] }}" id="{{ $setting['css_id'] }}">{{ $setting['value'] }}</textarea>

		@else

			<input class="form-control" type="text" name="{{ $setting['form_name'] }}" id="{{ $setting['css_id'] }}" value="{{ $setting['value'] }}">

		@endif

	</div>
</div>
