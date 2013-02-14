<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<h1>{{ Config::get('platform.site.title') }}</h1>

		<h2>Activate Account</h2>

		<p>Please follow the link provided below to activate your account.</p>

		<p><a href="{{ $activationLink }}">{{ $activationLink }}</a></p>

		<p>Regards, <br>{{ Config::get('platform.site.title') }}</p>
	</body>
</html>
