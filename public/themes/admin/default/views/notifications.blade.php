<section id="notifications">
	<br>

	@if ($errors->any())
		<div class="alert alert-error alert-block">
			{{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
			@if ($message = $errors->first(0, ':message'))
				{{ $message }}
			@else
				Please check the form below for errors
			@endif
		</div>
	@endif

	@if ($messages = Session::get('messages') and $messages->has('success'))
		@foreach ($messages->get('success') as $message)
			<div class="alert alert-success alert-block">
				{{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
				{{ $message }}
			</div>
		@endforeach
	@endif

	@if ($messages = Session::get('messages') and $messages->has('error'))
		@foreach ($messages->get('error') as $message)
			<div class="alert alert-error alert-block">
				{{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
				{{ $message }}
			</div>
		@endforeach
	@endif

</section>
