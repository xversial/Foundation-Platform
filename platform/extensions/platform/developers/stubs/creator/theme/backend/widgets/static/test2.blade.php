<div>
	<p>This widget lists all installed extension names:</p>
	<ul>
		@foreach ($extensions as $extension_name => $vendors)
			<li>
				{{ $extension_name }}
			</li>
		@endforeach
	</ul>
</div>