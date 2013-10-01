@extends('layouts/default')

{{-- Page title --}}
@section('title', trans("platform/content::general.{$pageSegment}.title"))

{{-- Queue assets --}}
{{ Asset::queue('validate', 'js/platform/validate.js', 'jquery') }}
{{ Asset::queue('fseditor', 'js/burakson/jquery.fseditor-min.js', 'jquery') }}
{{ Asset::queue('fseditor', 'css/burakson/fseditor.css', 'styles') }}
{{ Asset::queue('tabs', 'js/bootstrap/tab.js', 'jquery') }}
{{ Asset::queue('slugify', 'js/platform/slugify.js', 'jquery') }}
{{ Asset::queue('content-scripts', 'platform/content::js/scripts.js', 'jquery') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
<script type="text/javascript">
	H5F.setup(document.getElementById('content-form'));
</script>
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-12">

		{{-- Page header --}}
		<div class="page-header">

			<h1>{{{ trans("platform/content::general.{$pageSegment}.title") }}} <small>{{{ ! empty($content) ? $content->name : null }}}</small></h1>

		</div>

		{{-- Content form --}}
		<form id="content-form" class="form-horizontal" action="{{ Request::fullUrl() }}" method="post" accept-char="UTF-8" autocomplete="off">

			{{-- CSRF Token --}}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			{{-- Tabs --}}
			<ul class="nav nav-tabs" data-toogle="tab">
				<li class="active"><a href="#general">{{{ trans('platform/content::form.tabs.general') }}}</a></li>
				<li><a href="#attributes">{{{ trans('platform/content::form.tabs.attributes') }}}</a></li>
			</ul>

			{{-- Tabs content --}}
			<div class="tab-content tab-bordered">

				{{-- General tab --}}
				<div class="tab-pane active" id="general">

					{{-- Name --}}
					<div class="form-group{{ $errors->first('name', ' has-error') }}">
						<label for="name" class="col-lg-2 control-label">{{{ trans('platform/content::form.name') }}}</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="name" id="name" placeholder="{{{ trans('platform/content::form.name') }}}" value="{{{ Input::old('name', ! empty($content) ? $content->name : null) }}}">

							<span class="help-block">
								{{{ $errors->first('name', ':message') ?: trans('platform/content::form.name_help') }}}
							</span>
						</div>
					</div>

					{{-- Slug --}}
					<div class="form-group{{ $errors->first('slug', ' has-error') }}">
						<label for="slug" class="col-lg-2 control-label">{{{ trans('platform/content::form.slug') }}}</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="slug" id="slug" placeholder="{{{ trans('platform/content::form.slug') }}}" value="{{{ Input::old('slug', ! empty($content) ? $content->slug : null) }}}">

							<span class="help-block">
								{{{ $errors->first('slug', ':message') ?: trans('platform/content::form.slug_help') }}}
							</span>
						</div>
					</div>

					{{-- Enabled --}}
					<div class="form-group{{ $errors->first('enabled', ' has-error') }}">
						<label for="enabled" class="col-lg-2 control-label">{{{ trans('platform/content::form.enabled') }}}</label>
						<div class="col-lg-4">
							<select class="form-control" name="enabled" id="enabled">
								<option value="1"{{ (Input::old('enabled', ! empty($content) ? (int) $content->enabled : 1) == 1 ? ' selected="selected"' : null) }}>{{{ trans('general.enabled') }}}</option>
								<option value="0"{{ (Input::old('enabled', ! empty($content) ? (int) $content->enabled : 1) == 0 ? ' selected="selected"' : null) }}>{{{ trans('general.disabled') }}}</option>
							</select>

							<span class="help-block">
								{{{ $errors->first('enabled', ':message') ?: trans('platform/content::form.enabled_help') }}}
							</span>
						</div>
					</div>

					{{-- Type --}}
					<div class="form-group{{ $errors->first('type', ' has-error') }}">
						<label for="type" class="col-lg-2 control-label">{{{ trans('platform/content::form.type') }}}</label>
						<div class="col-lg-4">
							<select class="form-control" name="type" id="type">
								<option value="database"{{ Input::old('type', ! empty($content) ? $content->type : 'database') == 'database' ? ' selected="selected"' : null }}>{{{ trans('platform/content::form.database') }}}</option>
								<option value="filesystem"{{ Input::old('type', ! empty($content) ? $content->type : 'database') == 'filesystem' ? ' selected="selected"' : null }}>{{{ trans('platform/content::form.filesystem') }}}</option>
							</select>

							<span class="help-block">
								{{{ $errors->first('type', ':message') ?: trans('platform/content::form.type_help') }}}
							</span>
						</div>
					</div>

					{{-- Type : Database --}}
					<div class="type-database{{ Input::old('type', ! empty($content) ? $content->type : 'database') == 'filesystem' ? ' hide' : null }}">

						<div class="form-group{{ $errors->first('value', ' has-error') }}">
							<label for="value" class="col-lg-2 control-label">{{{ trans('platform/content::form.value') }}}</label>
							<div class="col-lg-10">
								<textarea style="height: 160px;" class="form-control" name="value" id="value">{{{ Input::old('value', ! empty($content) ? $content->value : null) }}}</textarea>

								<span class="help-block">
									{{{ $errors->first('value', ':message') ?: trans('platform/content::form.value_help') }}}
								</span>
							</div>
						</div>

					</div>

					{{-- Type : Filesystem --}}
					<div class="type-filesystem{{ Input::old('type', ! empty($content) ? $content->type : 'database') == 'database' ? ' hide' : null }}">

						{{-- File --}}
						<div class="form-group{{ $errors->first('file', ' error') }}">
							<label for="file" class="col-lg-2 control-label">{{{ trans('platform/content::form.file') }}}</label>
							<div class="col-lg-4">
								<select class="form-control" name="file" id="file"{{ Input::old('type', ! empty($content) ? $content->type : null) == 'filesystem' ? ' required' : null }}>
								@foreach ($files as $value => $name)
									<option value="{{ $value }}"{{ Input::old('file', ! empty($content) ? $content->file : null) == $value ? ' selected="selected"' : null}}>{{ $name }}</option>
								@endforeach
								</select>

								<span class="help-block">
									{{{ $errors->first('file', ':message') ?: trans('platform/content::form.file_help') }}}
								</span>
							</div>
						</div>

					</div>

					{{-- Form actions --}}
					<div class="form-group">

						<div class="col-lg-offset-2 col-lg-10">
							<button class="btn btn-success" type="submit">{{{ trans('button.save') }}}</button>

							<a class="btn btn-default" href="{{{ URL::toAdmin('content') }}}">{{{ trans('button.cancel') }}}</a>

							@if ( ! empty($content) and $pageSegment != 'copy')
							<div class="pull-right">
								<a class="btn btn-danger" data-toggle="modal" data-target="modal-confirm" href="{{ URL::toAdmin("content/delete/{$content->slug}") }}">{{{ trans('button.delete') }}}</a>

								<a class="btn btn-info" href="{{ URL::toAdmin("content/copy/{$content->slug}") }}">{{{ trans('button.copy') }}}</a>
							</div>
							@endif
						</div>

					</div>

				</div>

				{{-- Attributes tab --}}
				<div class="tab-pane" id="attributes">


<div class="row">

  <!-- Navigation Buttons -->
  <div class="col-md-3">
    <ul class="nav nav-pills nav-stacked" data-toogle="tab">
      <li class="active"><a href="#color">Color</a></li>
 <li><a href="#profile">Size</a></li>    </ul>
  </div>

  <!-- Content -->
  <div class="col-md-9">
    <div class="tab-content">
      <div class="tab-pane active" id="color">

<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Option</th>
								<th>Value</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<select class="form-control" name="attribute[1][id]">
										{{ $attributes }}
									</select>
								</td>
								<td>
									<input class="form-control" name="attribute[1][value]" type="text">
								</td>
								<td>
									<button class="btn btn-danger btn-sm" data-remove-option>Remove</button>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td><button class="btn btn-info btn-sm">Add Option</button></td>
							</tr>
						</tfoot>
					</table>



      </div>
      <div class="tab-pane" id="profile">Profile</div>
    </div>
  </div>

</div>






				</div>

			</div>

		</form>

	</div>

</div>

@stop
