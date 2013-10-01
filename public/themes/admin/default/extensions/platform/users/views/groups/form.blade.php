@extends('layouts/default')

{{-- Page title --}}
@section('title', trans("platform/users::groups/general.{$pageSegment}.title"))

{{-- Queue assets --}}
{{ Asset::queue('validate', 'js/platform/validate.js', 'jquery') }}
{{ Asset::queue('tabs', 'js/bootstrap/tab.js', 'jquery') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
<script type="text/javascript">
	H5F.setup(document.getElementById('groups-form'));
</script>
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-12">

		{{-- Page header --}}
		<div class="page-header">

			<h1>{{{ trans("platform/users::groups/general.{$pageSegment}.title") }}} <small>{{{ ! empty($group) ? $group->name : null }}}</small></h1>

		</div>

		{{-- Groups form --}}
		<form id="groups-form" class="form-horizontal" action="{{ Request::fullUrl() }}" method="post" accept-char="UTF-8" autocomplete="off">

			{{-- CSRF Token --}}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			{{-- Tabs --}}
			<ul class="nav nav-tabs" data-toogle="tab">
				<li class="active"><a href="#general">{{{ trans('platform/users::general.tabs.general') }}}</a></li>
				<li><a href="#permissions">{{{ trans('platform/users::general.tabs.permissions') }}}</a></li>
			</ul>

			{{-- Tabs content --}}
			<div class="tab-content tab-bordered">

				{{-- General tab --}}
				<div class="tab-pane active" id="general">

					{{-- Name --}}
					<div class="form-group{{ $errors->first('name', ' has-error') }}">
						<label for="name" class="col-lg-2 control-label">{{{ trans('platform/users::groups/form.name') }}}</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="name" id="name" placeholder="{{{ trans('platform/users::groups/form.name') }}}" value="{{{ Input::old('name', ! empty($group) ? $group->name : null) }}}">

							<span class="help-block">
								{{{ $errors->first('name', ':message') ?: trans('platform/users::groups/form.name_help') }}}
							</span>
						</div>
					</div>

					{{-- Form actions --}}
					<div class="form-group">

						<div class="col-lg-offset-2 col-lg-10">
							<button class="btn btn-success" type="submit">{{{ trans('button.save') }}}</button>

							<a class="btn btn-default" href="{{{ URL::toAdmin('users/groups') }}}">{{{ trans('button.cancel') }}}</a>

							@if( ! empty($group))
							<div class="pull-right">
								<a class="btn btn-danger" data-toggle="modal" data-target="modal-confirm" href="{{ URL::toAdmin("users/groups/delete/{$group->id}") }}">{{{ trans('button.delete') }}}</a>
							</div>
							@endif
						</div>

					</div>

				</div>

				{{-- Attributes tab --}}
				<div class="tab-pane" id="attributes">

				</div>

			</div>

		</form>

	</div>

</div>

@stop
