@foreach ($attributes as $attribute)
	@if (in_array($attribute->type, array('select', 'radio', 'checkbox')))
	<div class="form-group">
		<label for="{{{ $attribute->name }}}" class="col-lg-3 control-label">{{{ $attribute->name }}}</label>
		<div class="col-lg-9 ">
			{{ generateInput("attribute[{$attribute->name}]", $attribute, null, array('class' => 'form-control', 'id' => $attribute->name)) }}

			<span class="help-block">
				{{{ $errors->first($attribute->value, ':message') ?: null }}}
			</span>
		</div>
	</div>
	@else
	@foreach ($attribute->options as $option)

	<?php
		$data = $user->attributes()->where('name', $option->value)->first();
		$name = in_array($attribute->type, array('select', 'radio', 'checkbox')) ? $attribute->name : $option->value;
		$value = ! is_null($data) ? $data->value : null;
	?>

	<div class="form-group">
		<label for="{{{ $name }}}" class="col-lg-3 control-label">{{{ $option->name }}}</label>
		<div class="col-lg-9">
			{{ generateInput("attribute[{$name}]", $attribute, $value, array('class' => 'form-control', 'id' => $name)) }}

			<span class="help-block">
				{{{ $errors->first($option->value, ':message') ?: null }}}
			</span>
		</div>
	</div>
	@endforeach
	@endif
@endforeach
