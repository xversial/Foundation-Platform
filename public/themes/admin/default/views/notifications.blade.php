<section id="notifications">

	@if ($errors->any())
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<i class="icon-exclamation error"></i>
			@if ($message = $errors->first(0, ':message'))
				<p class="message">{{ $message }}</p>
			@else
				<p class="message">Please check the form below for errors</p>
			@endif
		</div>
	@endif

	@if ($notifications = Session::get('notifications') and $notifications->has('success'))
		@foreach ($notifications->get('success') as $message)
			<div class="alert alert-success">
				<i class="icon-ok-sign success"></i>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p class="message">{{ $message }}</p>
			</div>
		@endforeach
	@endif

	@if ($notifications = Session::get('notifications') and $notifications->has('error'))
		@foreach ($notifications->get('error') as $message)
			<div class="alert alert-warning">
				<i class="icon-warning-sign warning"></i>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p class="message">{{ $message }}</p>
			</div>
		@endforeach
	@endif

</section>
