@extends('layouts/default')

{{-- Page title --}}
@section('title', trans("platform/menus::general.{$pageSegment}.title", array('menu' => ! empty($menu) ? $menu->name : null)))

{{-- Queue assets --}}

{{-- Inline scripts --}}
@section('scripts')
@parent

@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-12">

		{{-- Page header --}}
		<div class="page-header">

			<h1>{{{ trans("platform/menus::general.{$pageSegment}.title") }}} <small>{{{ ! empty($menu) ? $menu->name : null }}}</small></h1>

			<span>{{{ trans("platform/menus::general.{$pageSegment}.description") }}}</span>
		</div>

		<form id="menu-form" action="{{ Request::fullUrl() }}" method="post" accept-char="UTF-8">

			<div class="col-lg-3">

				<fieldset>
					<legend>Menu Details</legend>

					<div class="form-group">
						<label class="control-label" for="menu-name">{{ trans('platform/menus::form.root.name') }}</label>

						<input type="text" name="menu-name" id="menu-name" class="form-control" value="{{{ ! empty($menu) ? $menu->name : null }}}" required>
					</div>

					<div class="form-group">
						<label class="control-label" for="menu-slug">{{ trans('platform/menus::form.root.slug') }}</label>

						<input type="text" name="menu-slug" id="menu-slug" class="form-control" value="{{{ ! empty($menu) ? $menu->slug : null }}}" required>
					</div>

				</fieldset>

			</div>

			{{-- Menu children --}}
			<div class="col-lg-9">

			</div>

		</form>

	</div>

</div>

@stop
