<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>
			403 Forbidden
		</title>

		{{-- Call custom inline styles --}}
		@section('styles')

		<style>
			body{
				overflow: hidden;
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyBAMAAADsEZWCAAAAElBMVEX///////////////////////+65XQCAAAABnRSTlMFBgcICQT0QHXTAAADPklEQVR4Xl1UtwKtKBAdUk+yJ9kTpAf09or6/7+yvmYTHc2cOWkAhyKNsldwQ04i08ZPl4dKACktiUj/U6zqqPrMgzAhMaHgTKcxZ6+5ei7KDtxVk7O8GrA2wyTOS06dl1JmjHPjWmfweec3SqNMH7dAnV6sNzoqBhcnXjFkCCgH0RRoxq89cQloW3ww8RLGxFED2GvPczV/cBqnyhYc5WJmh3B6dMbjQ4Uzh009QYalisgRhvW+jrNIB7r+XneBzKvuakGnK8zIjUwNiuzF84HeM15qSHhVnSWYYwfFFJ6Y7hKw6bZMtREurDgkMKHth9pI+plVb77U16VNUA7pTIgzdIaf5VjZLKF/dHJWYG1wXvVYSOsRQFK1MO653GEDkZPZCDb7TQ6nw6rvc4sEwco3kI8k1/+NgldXATnFU0JE2RBMIsU4PwqmV4sWpHRBYmLiRr/MzgdSBamqLS1dUuhuJvNsUOoNJQwGGr9mHfh/WwilFNj723zsTCLOlVo9OU8bzDIdlFfLC0nySveiFUNJq1XJGQMa1zF/kJapC0oRClVw7zadAGNHeU7pKW8PJP6YuSWMfzs8p/y5ZucR/6ctaF9dIaMN26fMaEfxbEmIXUHbe6/nbYlU1WfTTaMRRiMnYGlwtIM6IhAp/o8cpXrKPEiw4iHJc8tZVGoQypf89teAqdztyaG8yBHsapJXnWEfLBTwglTwp+XZ3P/iAFY0qhJ6l+CV67d1XFx4IoWAelxbibEMtDj+In/kkWXqN0RR/dyCX3oANp571BomflgFPBcvvRSYe36X9tpH/gDZlCDk8Iq4bjtZkiJWycHUfliD4e+suD0wgv8JGSCkMUL3TA4Mc5WTG452LUqC2TdjyMoTIIkD78ef/riHCuDyJLeyF0sVGy7MVHAbLX4N+vdtv76L24oUeh2C6NtBsnDh18htqKURZUUOt3Oks2QsIN+q7TzPLjzbqC945wlo65AOEzu612eZtAwM+SIchHEdlMOZuZSuzssmeCH8WqK+1xfkHnHi5cQVC+JYpCGqdRUu/ldF873WYo7OBjhiIiI6kUK8tm1I8HIhOE8DDymEbAZNy0657cFbr5cUkfwLq261khXHVoMAAAAASUVORK5CYII=);
				background-color:#821d52;
			}

			.error{
				width:480px;
				height:600px;
				margin:0 auto;
				padding:0 20px;
				/* IE9 SVG, needs conditional override of 'filter' to 'none' */
				background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPHJhZGlhbEdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgY3g9IjUwJSIgY3k9IjUwJSIgcj0iNzUlIj4KICAgIDxzdG9wIG9mZnNldD0iMjAlIiBzdG9wLWNvbG9yPSIjYTgyZDZlIiBzdG9wLW9wYWNpdHk9IjAuNTYiLz4KICAgIDxzdG9wIG9mZnNldD0iNzglIiBzdG9wLWNvbG9yPSIjYTgyZDZlIiBzdG9wLW9wYWNpdHk9IjAiLz4KICA8L3JhZGlhbEdyYWRpZW50PgogIDxyZWN0IHg9Ii01MCIgeT0iLTUwIiB3aWR0aD0iMTAxIiBoZWlnaHQ9IjEwMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
				background: -moz-radial-gradient(center, ellipse cover,  rgba(168,45,110,0.56) 20%, rgba(168,45,110,0) 78%); /* FF3.6+ */
				background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(20%,rgba(168,45,110,0.56)), color-stop(78%,rgba(168,45,110,0))); /* Chrome,Safari4+ */
				background: -webkit-radial-gradient(center, ellipse cover,  rgba(168,45,110,0.56) 20%,rgba(168,45,110,0) 78%); /* Chrome10+,Safari5.1+ */
				background: -o-radial-gradient(center, ellipse cover,  rgba(168,45,110,0.56) 20%,rgba(168,45,110,0) 78%); /* Opera 12+ */
				background: -ms-radial-gradient(center, ellipse cover,  rgba(168,45,110,0.56) 20%,rgba(168,45,110,0) 78%); /* IE10+ */
				background: radial-gradient(ellipse at center,  rgba(168,45,110,0.56) 20%,rgba(168,45,110,0) 78%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8fa82d6e', endColorstr='#00a82d6e',GradientType=1 ); /* IE6-8 fallback on horizontal gradient */

			}

			h1{
				margin:0;

				font-size:240px;
				letter-spacing: 4px;
				color:#fff;
				text-align: center;

				text-shadow:0 -2px 2px #460e2c;
			}

			h2{
				margin:-10px 0 0;

				text-align: center;
				font-size:30px;
				color:#f8f8f8;
				letter-spacing: 3px;
				font-weight: 100;
			}

			p{
				font-size:16px;
				line-height: 28px;
				letter-spacing: 1px;
				color:#f7f7f7;
				margin-bottom:20px;
				text-align: center;
			}

			.btn{
				display:block;

				padding:10px;
				margin:0 auto;

				color:#fff;
				font-weight:200;
				text-align: center;

			}
		</style>

		@show

	</head>

	<body>

		<div class="error">

			<h1>403</h1>
			<h2>No soup for you!</h2>

			<p>
				You're probably not meant to access this page. At least, that's what we think.
			</p>

		</div>


	</body>
</html>
