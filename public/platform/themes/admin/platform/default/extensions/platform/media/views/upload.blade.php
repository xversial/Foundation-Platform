@extends('templates/default')

@section('title')
{{ Lang::get('platform/media::general.title') }}
@stop

@section('assets')

@stop

@section('scripts')

@stop

@section('content')
<div class="page-header">
	<h3>
		{{ Lang::get('platform/media::general.title') }}

		<div class="pull-right">
			<a href="{{ URL::to(ADMIN_URI . '/media/upload') }}" class="btn btn-info btn-small">{{ Lang::get('button.upload') }}</a>
		</div>
	</h3>
</div>

<form method="post" enctype="multipart/form-data">

<input type="file" name="files" id="files">

<input type="submit" name="submit" value="Upload!" />

</form>
@stop
