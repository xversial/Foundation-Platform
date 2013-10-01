@extends('layouts/default')

{{-- Page title --}}
@section('title', trans("platform/attributes::general.{$pageSegment}.title"))

{{-- Queue assets --}}
{{ Asset::queue('validate', 'js/platform/validate.js', 'jquery') }}
{{ Asset::queue('sortable', 'platform/attributes::js/jquery.sortable.js', 'jquery') }}
{{ Asset::queue('attributes', 'platform/attributes::css/style.less') }}
{{ Asset::queue('attributes-scripts', 'platform/attributes::js/scripts.js', 'sortable') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
<script type="text/javascript">
	H5F.setup(document.getElementById('attributes-form'));
</script>
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-12">

		{{-- Page header --}}
		<div class="page-header">

			<h1>{{{ trans("platform/attributes::general.{$pageSegment}.title") }}} <small>{{{ ! empty($attribute) ? $attribute->name : null }}}</small></h1>

		</div>

		{{-- Attributes form --}}
		<form id="content-form" action="{{ Request::fullUrl() }}" method="post" accept-char="UTF-8" autocomplete="off">

			{{-- CSRF Token --}}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="row">

				<div class="col-lg-5">

					{{-- Name --}}
					<div class="form-group{{ $errors->first('name', ' has-error') }}">
						<label for="name" class="col-lg-3 control-label">{{{ trans('platform/attributes::form.name') }}}</label>
						<div class="col-lg-9">
							<input type="text" class="form-control" name="name" id="name" placeholder="{{{ trans('platform/attributes::form.name') }}}" value="{{{ Input::old('name', ! empty($attribute) ? $attribute->name : null) }}}">

							<span class="help-block">
								{{{ $errors->first('name', ':message') ?: trans('platform/attributes::form.name_help') }}}
							</span>
						</div>
					</div>

					{{-- Extension --}}
					<div class="form-group{{ $errors->first('extension', ' has-error') }}">
						<label for="extension" class="col-lg-3 control-label">{{{ trans('platform/attributes::form.extension') }}}</label>
						<div class="col-lg-9">
							<select class="form-control" name="extension" id="extension" required>
								<option value="">---</option>
								@foreach ($extensions as $vendor => $_extensions)
								<optgroup label="{{{ $vendor }}}">
									@foreach ($_extensions as $extension)
									<option value="{{{ $extension->getSlug() }}}"{{ Input::old('extension', ! empty($attribute) ? $attribute->extension : null) == $extension->getSlug() ? ' selected="selected"' : null }}>{{{ $extension->name }}}</option>
									@endforeach
								</optgroup>
								@endforeach
							</select>

							<span class="help-block">
								{{{ $errors->first('extension', ':message') ?: trans('platform/attributes::form.extension_help') }}}
							</span>
						</div>
					</div>

					{{-- Group --}}
					<div class="form-group{{ $errors->first('group', ' has-error') }}">
						<label for="group" class="col-lg-3 control-label">{{{ trans('platform/attributes::form.group') }}}</label>
						<div class="col-lg-9">
							@if ($groups->isEmpty())
							<p class="form-control-static">Click <a href="{{ URL::toAdmin('attributes/groups/create') }}">here</a> to add a new Attribute group.</p>
							@else
							<select class="form-control" name="group" id="group" required>
								<option value="">---</option>
								@foreach ($groups as $group)
								<option value="{{{ $group->id }}}"{{ Input::old('group', ! empty($attribute) ? $attribute->group_id : null) == $group->id ? ' selected="selected"' : null }}>{{{ $group->name }}}</option>
								@endforeach
							</select>

							<span class="help-block">
								{{{ $errors->first('group', ':message') ?: trans('platform/attributes::form.group_help') }}}
							</span>
							@endif
						</div>
					</div>

					{{-- Type --}}
					<div class="form-group{{ $errors->first('type', ' has-error') }}">
						<label for="type" class="col-lg-3 control-label">{{{ trans('platform/attributes::form.type') }}}</label>
						<div class="col-lg-9">
							<select class="form-control" name="type" id="type" class="form-control">
								<option{{ Input::old('type', ! empty($attribute) ? $attribute->type : null) === 'select' ? ' selected="selected"' : null }} value="select">Select</option>
								<option{{ Input::old('type', ! empty($attribute) ? $attribute->type : null) === 'radio' ? ' selected="selected"' : null }} value="radio">Radio</option>
								<option{{ Input::old('type', ! empty($attribute) ? $attribute->type : null) === 'checkbox' ? ' selected="selected"' : null }} value="checkbox">Checkbox</option>
								<optgroup label="Input">
									<option{{ Input::old('type', ! empty($attribute) ? $attribute->type : null) === 'text' ? ' selected="selected"' : null }} value="text">Text</option>
									<option{{ Input::old('type', ! empty($attribute) ? $attribute->type : null) === 'textarea' ? ' selected="selected"' : null }} value="textarea">Textarea</option>
								</optgroup>
								<optgroup label="File">
									<option{{ Input::old('type', ! empty($attribute) ? $attribute->type : null) === 'file' ? ' selected="selected"' : null }} value="file">File</option>
								</optgroup>
							</select>

							<span class="help-block">
								{{{ $errors->first('type', ':message') ?: trans('platform/attributes::form.type_help') }}}
							</span>
						</div>
					</div>

					{{-- Enabled --}}
					<div class="form-group{{ $errors->first('enabled', ' has-error') }}">
						<label for="enabled" class="col-lg-3 control-label">{{{ trans('platform/attributes::form.enabled') }}}</label>
						<div class="col-lg-9">
							<select class="form-control" name="enabled" id="enabled" required>
								<option value="1"{{ (Input::old('enabled', ! empty($attribute) ? (int) $attribute->enabled : 1) === 1 ? ' selected="selected"' : null) }}>{{{ trans('general.enabled') }}}</option>
								<option value="0"{{ (Input::old('enabled', ! empty($attribute) ? (int) $attribute->enabled : 1) === 0 ? ' selected="selected"' : null) }}>{{{ trans('general.disabled') }}}</option>
							</select>

							<span class="help-block">
								{{{ $errors->first('enabled', ':message') ?: trans('platform/attributes::form.enabled_help') }}}
							</span>
						</div>
					</div>

				</div>

				<div class="col-lg-7">

					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th colspan="2">{{{ trans('platform/attributes::form.option.name') }}}</th>
								<th>{{{ trans('platform/attributes::form.option.value') }}}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>

							{{-- Show options here --}}
							@foreach ($options as $id => $option)
							<tr>
								<td><i data-move class="glyphicon glyphicon-move xicon icon-move"></i></td>
								<td><input class="form-control" name="options[{{ $id }}][name]" type="text" value="{{{ $option['name'] }}}"></td>
								<td><input class="form-control" name="options[{{ $id }}][value]" type="text" value="{{{ $option['value'] }}}"></td>
								<td><span data-remove-option class="btn btn-danger btn-sm">{{{ trans('button.remove') }}}</span></td>
							</tr>
							@endforeach

							<tr data-option-clone class="hide">
								<td><i data-move class="glyphicon glyphicon-move xicon icon-move"></i></td>
								<td><input class="form-control" name="options[0][name]" type="text"></td>
								<td><input class="form-control" name="options[0][value]" type="text"></td>
								<td><span data-remove-option class="btn btn-danger btn-sm">{{{ trans('button.remove') }}}</span></td>
							</tr>

							<tr data-options-empty{{ count($options) >= 1 ? ' class="hide"' : null }}>
								<td colspan="4">There are no options.</td>
							</tr>

						</tbody>
						<tfoot>
							<tr>
								<td colspan="3"></td>
								<td><span id="addOption" class="btn btn-info btn-sm">{{{ trans('button.add') }}}</span></td>
							</tr>
						</tfoot>
					</table>

				</div>

			</div>

			<div class="row">

				<div class="col-lg-5">

					{{-- Form actions --}}
					<div class="form-group">

						<div class="col-lg-offset-3 col-lg-9">
							<button class="btn btn-success" type="submit">{{{ trans('button.save') }}}</button>
							<a class="btn btn-default" href="{{{ URL::toAdmin('attributes') }}}">{{{ trans('button.cancel') }}}</a>

							@if ( ! empty($attribute))
							<a class="btn btn-danger" data-toggle="modal" data-target="modal-confirm" href="{{ URL::toAdmin("attributes/delete/{$attribute->id}") }}">{{{ trans('button.delete') }}}</a>
							@endif
						</div>

					</div>

				</div>

			</div>

		</form>

	</div>

</div>

@stop
