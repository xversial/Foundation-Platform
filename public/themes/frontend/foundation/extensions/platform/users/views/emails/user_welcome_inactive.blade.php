<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<p>Hello {{ $user->first_name }},</p>

		<p>Please keep this e-mail for your records.</p>

		<p>Your account information is as follows:</p>

		<p>----------------------------</p>

		<p>Email: {{ $user->email }}</p>

		<p>Website URL: {{ URL::to('/') }}</p>

		<p>----------------------------</p>

		<p>Please visit the following link in order to activate your account:</p>

		<p><a href="{{ $activationLink }}">{{ $activationLink }}</a></p>

		<p>Your password has been securely stored in our database and cannot be retrieved. In the event that it is forgotten, you will be able to reset it using the email address associated with your account.</p>

		<p>Thank you for registering.</p>

		<p>@setting('platform.site.title')</p>
	</body>
</html>
