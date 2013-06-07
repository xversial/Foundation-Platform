@if ($errors->any())
<div class="alert alert-error alert-block">
	<button type="button" class="close" data-dismiss="alert"><i class="icon-collapse-alt"></i></button>
	<h4>Error
		<span>
			@if ($message = $errors->first(0, ':message'))
				{{ $message }}
			@else
				Please check the form below for errors
			@endif
		</span>
	</h4>
</div>
@endif

@if ($notifications = Session::get('notifications') and $notifications->has('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert"><i class="icon-collapse-alt"></i></button>
	<h4>Success
		<span>
			@foreach ($notifications->get('success') as $message)
				{{ $message }}
			@endforeach
		</span>
	</h4>
</div>
@endif

@if ($notifications = Session::get('notifications') and $notifications->has('error'))
<div class="alert alert-error alert-block">
	<button type="button" class="close" data-dismiss="alert"><i class="icon-collapse-alt"></i></button>
	<h4>Error
		<span>
			@foreach ($notifications->get('error') as $message)
				{{ $message }}
			@endforeach
		</span>
	</h4>
</div>
@endif
