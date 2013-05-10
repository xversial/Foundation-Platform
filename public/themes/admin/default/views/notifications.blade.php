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

	@if ($notifications = Session::get('notifications') and $notifications->has('success'))
		@foreach ($notifications->get('success') as $message)
			<div class="alert alert-success alert-block">
				{{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
				{{ $message }}
			</div>
		@endforeach
	@endif

	@if ($notifications = Session::get('notifications') and $notifications->has('error'))
		@foreach ($notifications->get('error') as $message)
			<div class="alert alert-error alert-block">
				{{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
				{{ $message }}
			</div>
		@endforeach
	@endif

</section>
