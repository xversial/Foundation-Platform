<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<h1>{{ Config::get('platform.site.title') }}</h1>

		<h2>Reset Password</h2>

		<p>Please follow the link provided below to change your password to the provided reset password.</p>

		<p><a href="{{ $resetLink  }}">{{ $resetLink }}</a></p>

		<p>Regards, <br>{{ Config::get('platform.site.title') }}</p>
	</body>
</html>
