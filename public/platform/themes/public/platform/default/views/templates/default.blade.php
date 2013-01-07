<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Bootstrap, from Twitter</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		{{ Asset::queue('bootstrap', 'css/bootstrap.css') }}
		{{ Asset::queue('style', 'less/style.less', 'bootstrap') }}
		{{ Asset::queue('jquery', 'js/jquery.js') }}
		{{ Asset::queue('bootstrap', 'js/bootstrap.js', 'jquery') }}
		{{ Asset::queue('script', 'js/script.js', array('bootstrap', 'jquery')) }}

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		@yield('assets')

		<style>
		{{ Theme::outputStyles() }}
		</style>

	</head>

	<body>

		@yield('content')

		<script>
		{{ Theme::outputScripts() }}
		</script>
	</body>
</html>
