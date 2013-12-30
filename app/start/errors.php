<?php

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

if (App::environment() === 'production' or Config::get('app.debug') === false)
{
	App::error(function(Symfony\Component\HttpKernel\Exception\HttpException $exception, $code)
	{
		Log::error($exception);

		return show_error_page($exception->getStatusCode());
	});

	App::error(function(Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception, $code)
	{
		Log::error($exception);

		return show_error_page(404);
	});

	App::error(function(Cartalyst\Api\Http\ApiHttpException $exception, $code)
	{
		Log::error($exception);

		// If the API is throwing a 404 status, we'll actually return a
		// 500 error. The main reason for this, is that the app should
		// be handling all possible API Exceptions that are thrown.
		// If one bubbles back to the user, there is definitely
		// an "internal server error".
		if (($statusCode = $exception->getStatusCode()) == 404)
		{
			$statusCode = 500;
		}

		return show_error_page($statusCode);
	});

	App::error(function(Exception $exception, $code)
	{
		Log::error($exception);

		return show_error_page(500);
	});
}
else
{
	App::error(function(Exception $exception, $code)
	{
		Log::error($exception);
	});
}
