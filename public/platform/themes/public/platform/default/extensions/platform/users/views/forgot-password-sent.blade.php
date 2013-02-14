@extends('templates/default')

<!-- Site title -->
@section('title')
@parent
- Forgot Password
@stop

<!-- Queue assets -->
{{ Asset::queue('platform-validate', 'js/vendor/platform/validate.js', 'jquery') }}

<!-- -->
@section('scripts')
<script>
	jQuery(document).ready(function($) {
		Validate.setup($('#forgot-password-form'));
	});
</script>
@stop

<!-- Page content -->
@section('content')
Password reset confirmation sent successfully!

We’ve sent an email to {{ $userEmail }} containing a temporary link that will allow you to reset your password for the next 24 hours.

<br>

Please check your spam folder if the email doesn’t appear within a few minutes.
@stop
