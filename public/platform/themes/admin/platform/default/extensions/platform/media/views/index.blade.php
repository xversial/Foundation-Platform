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

<table class="table table-bordered">
	<thead>
		<tr>
			<th>Id</th>
			<th>Name</th>
			<th class="span2">File Extension</th>
			<th class="span2">Mime Type</th>
			<th class="span2">Size</th>
			<th class="span2">Width</th>
			<th class="span2">Height</th>
			<th class="span2">{{ Lang::get('table.actions') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($media as $row)
			<tr>
				<td class="span1">
					{{ $row->id }}
				</td>
				<td>
					{{ $row->name }}
				</td>
				<td>
					{{ $row->file_extension }}
				</td>
				<td>
					{{ $row->file_mime_type }}
				</td>
				<td>
					{{ $row->file_size() }}
				</td>
				<td>
					{{ $row->width() }}
				</td>
				<td>
					{{ $row->height() }}
				</td>
				<td>
					<div class="btn-group">
						<a href="{{ URL::to(ADMIN_URI . "/media/view/{$row->id}") }}" class="btn btn-mini">
							{{ Lang::get('button.edit') }}
						</a>
						<a href="{{ URL::to(ADMIN_URI . "/media/delete/{$row->id}") }}" class="btn btn-mini btn-danger">
							{{ Lang::get('button.delete') }}
						</a>
					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8">
				<div class="pull-right">
					{{ $media->links() }}
				</div>
			</td>
		</tr>
	</tfoot>
</table>
@stop
