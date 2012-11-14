@foreach ($rows as $row)
	<tr>
		<td class="span1">{{ $row['id'] }}</td>
		<td class="span2">{{ $row['name'] }}</td>
		<td class="span2">{{ $row['slug'] }}</td>
		<td class="span2">{{ $row['template'] }}</td>
		<td class="span2">{{ $row['status'] }}</td>
		<td class="span2">
			<div class="btn-group">
			<a class="btn btn-mini" href="{{ URL::to_admin('pages/edit/' . $row['id']) }}">{{ Lang::line('button.edit') }}</a>
			<a class="btn btn-mini btn-info" href="{{ URL::to_admin('pages/copy/'.$row['id']) }}">Copy</a>
			@if ($row['id'] != Platform::get('platform/pages::default.page'))
				<a id="modal-confirm" class="btn btn-mini btn-danger" href="{{ URL::to_admin('pages/delete/' . $row['id']) }}">{{ Lang::line('button.delete') }}</a>
			@endif
			</div>
		</td>
	</tr>
@endforeach
