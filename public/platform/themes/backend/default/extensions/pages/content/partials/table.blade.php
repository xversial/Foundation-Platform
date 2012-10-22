@foreach ($rows as $row)
	<tr>
		<td class="span1">{{ $row['id'] }}</td>
		<td class="span2">{{ $row['name'] }}</td>
		<td class="span2">{{ $row['slug'] }}</td>
		<td class="span2">
			<div class="btn-group">
			<a class="btn btn-mini" href="{{ URL::to_secure(ADMIN.'/pages/content/edit/'.$row['id']) }}">{{ Lang::line('button.edit') }}</a>
			<a class="btn btn-mini btn-danger" href="{{ URL::to_secure(ADMIN.'/pages/content/delete/'.$row['id']) }}">{{ Lang::line('button.delete') }}</a>
			</div>
		</td>
	</tr>
@endforeach
