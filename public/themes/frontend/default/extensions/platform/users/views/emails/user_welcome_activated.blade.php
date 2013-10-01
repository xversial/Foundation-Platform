<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<p>Hello {{ $user->first_name }},</p>

		<p>Your account on "@setting('platform.site.title')" has been activated by an administrator, you may login now.</p>

		<p>Your password has been securely stored in our database and cannot be retrieved. In the event that it is forgotten, you will be able to reset it using the email address associated with your account.</p>

		<p>@setting('platform.site.title')</p>
	</body>
</html>
