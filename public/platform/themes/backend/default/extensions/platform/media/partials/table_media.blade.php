@foreach ($rows as $row)
	<tr>
		<td class="span1">
			@if ($choose)
				{{ Form::$choose('__media_chosen__', $row['id'], false, array('class' => 'media-chosen', 'data-id' => $row['id'], 'data-name' => $row['name'], 'data-file-path' => $row['file_path'], 'data-file-name' => $row['file_name'], 'data-file-extension' => $row['file_extension'], 'data-full-path' => $row['full_path'], 'data-url' => $row['url'], 'data-thumbnail-url' => $row['thumbnail_url'], 'data-mime' => $row['mime'], 'data-size' => $row['size'], 'data-size-human' => $row['size_human'], 'data-width' => $row['width'], 'data-height' => $row['height'])) }}
			@else
				{{ $row['id'] }}
			@endif
		</td>
		<td class="span1">{{ $row['extension'] }}</td>
		<td class="span1">{{ $row['name'] }}</td>
		<td class="span1">{{ $row['file_path'] }}</td>
		<td class="span1">{{ $row['file_name'] }}</td>
		<td class="span1">{{ $row['file_extension'] }}</td>
		<td class="span1">{{ $row['mime'] }}</td>
		<td class="span1">{{ $row['size'] }}</td>
		<td class="span1">{{ $row['width'] }}</td>
		<td class="span1">{{ $row['height'] }}</td>
		<td class="span2">{{ date('g:ia - m.d.y', $row['created_at']) }}</td>
		@if ( ! $choose)
			<td class="span2">
				<div class="btn-group">
					<a class="btn btn-mini" href="{{ URL::to_secure(ADMIN.'/media/view/'.$row['id']) }}">{{ Lang::line('button.view') }}</a>
					<a id="modal-confirm" class="btn btn-mini btn-danger" href="{{ URL::to_secure(ADMIN.'/media/delete/'.$row['id']) }}">{{ Lang::line('button.delete') }}</a>
				</div>
			</td>
		@endif
	</tr>
@endforeach
