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
			<a href="{{ URL::to(ADMIN_URI . '/media/upload') }}" class="btn btn-info btn-small">{{ Lang::get('platform/media::button.upload') }}</a>
		</div>
	</h3>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ Lang::get('platform/media::table.id') }}</th>
			<th>{{ Lang::get('platform/media::table.file_name') }}</th>
			<th class="span2">{{ Lang::get('platform/media::table.file_extension') }}</th>
			<th class="span2">{{ Lang::get('platform/media::table.file_mime_type') }}</th>
			<th class="span2">{{ Lang::get('platform/media::table.file_size') }}</th>
			<th class="span2">{{ Lang::get('platform/media::table.width') }}</th>
			<th class="span2">{{ Lang::get('platform/media::table.height') }}</th>
			<th class="span2">{{ Lang::get('platform/media::table.created_at') }}</th>
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
					{{ $row->created_at }}
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
