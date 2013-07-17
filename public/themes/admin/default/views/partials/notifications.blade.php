<div class="notifications">
	@if ($errors->any())
		<p class="notify notify--error">
			@if ($message = $errors->first(0, ':message'))
				<p><i class="icon-exclamation"></i> {{ $message }}</p>
			@else
				<p><i class="icon-exclamation"></i> Please check the form below for errors </p>
			@endif
		</p>
	@endif

	@if ($notifications = Session::get('notifications') and $notifications->has('error'))
		@foreach ($notifications->get('error') as $message)
			<p class="notify notify--warning">
				<i class="icon-warning-sign"></i> {{ $message }}
			</p>
		@endforeach
	@endif

	@if ($notifications = Session::get('notifications') and $notifications->has('success'))
		@foreach ($notifications->get('success') as $message)
			<p  class="notify notify--success">
				<i class="icon-ok-sign"></i> {{ $message }}
			</p>
		@endforeach
	@endif
</div>
