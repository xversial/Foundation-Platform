<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>
			503 Service Unavailable
		</title>

		{{-- Call custom inline styles --}}
		@section('styles')

		<style>
			body {
				background:#f7f7f7;
				text-align: center;
				padding-top:5%;
			}

			h1 {
				font-size:92px;
				padding:0;
				margin:0;
			}

			h2 {
				color: rgb(51, 51, 51);
				display: inline;
				font-family: 'Open Sans', sans-serif;
				font-size: 44px;
				font-style: normal;
				height: auto;
				line-height: 71px;
				text-align: center;
				margin:0;
				padding:0;
			}

			p {
				color: rgb(51, 51, 51);
				font-size: 34px;
				font-style: normal;
				height: auto;
				line-height: 54px;
				text-align: center;
				margin:0;
				margin-bottom: 20px;
				padding:0;
			}

			.btn {
				-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
				-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
				box-shadow:inset 0px 1px 0px 0px #ffffff;
				background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #f9f9f9), color-stop(1, #e9e9e9) );
				background:-moz-linear-gradient( center top, #f9f9f9 5%, #e9e9e9 100% );
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e9e9e9');
				background-color:#f9f9f9;
				-moz-border-radius:8px;
				-webkit-border-radius:8px;
				border-radius:8px;
				border:1px solid #dcdcdc;
				display:inline-block;
				color:#666666;
				font-family:arial;
				font-size:20px;
				font-weight:bold;
				padding:14px 20px;
				text-decoration:none;
				text-shadow:1px 1px 0px #ffffff;
			}.btn:hover {
				background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #e9e9e9), color-stop(1, #f9f9f9) );
				background:-moz-linear-gradient( center top, #e9e9e9 5%, #f9f9f9 100% );
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#e9e9e9', endColorstr='#f9f9f9');
				background-color:#e9e9e9;
			}.btn:active {
				position:relative;
				top:1px;
			}
		</style>

		@show

	</head>

	<body>

		<div class="error">

			<h1>503</h1>
			<h2>Service Unavailable</h2>

			<p>
				Something couldn't <strong>connect</strong>, wait a few and try again.
			</p>

			<a href="{{ URL::to('/') }}" class="btn">Let's go Home</a>

		</div>

	</body>
</html>
