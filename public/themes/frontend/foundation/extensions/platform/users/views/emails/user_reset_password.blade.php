<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<p>Hello {{ $user->first_name }},</p>

		<p>You are receiving this notification because you have (or someone pretending to be you has) requested a password reset on your account on "@setting('platform.site.title')". If you did not request this notification then please ignore it, if you keep receiving it please contact the administrator.</p>

		<p>Please visit the following link in order to reset your password:</p>

		<p><a href="{{ $resetLink  }}">{{ $resetLink }}</a></p>

		<p>@setting('platform.site.title')</p>
	</body>
</html>
