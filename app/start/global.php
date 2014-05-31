<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Require The Errors File
|--------------------------------------------------------------------------
|
| Next we'll load the file responsible for error handling. This allow
| us to have error handling setup before we boot our application.
|
*/

require __DIR__.'/errors.php';

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return show_error_page(503);
});

/*
|--------------------------------------------------------------------------
| Require The Functions File
|--------------------------------------------------------------------------
|
| We will require a file which you can define any custom functions for
| your application, before any usage of these functions occurs. This
| is just  a convenient way to organize your code.
|
*/

require app_path().'/functions.php';

/*
|--------------------------------------------------------------------------
| Require The Hooks File
|--------------------------------------------------------------------------
|
| Next we will load the hooks file for your Platform application. This
| file contains a number of events which you can hook into.
|
*/

require app_path().'/hooks.php';

/*
|--------------------------------------------------------------------------
| Boot Platform
|--------------------------------------------------------------------------
|
| Now that we have our functions and hooks registered, we'll boot Platform.
|
*/

Platform::boot();

/*
|--------------------------------------------------------------------------
| Require The Overrides File
|--------------------------------------------------------------------------
|
| Next we'll load the overrides file, which is a convenient place to
| override functionality in Laravel, Platform, all packages and
| Extensions.
|
*/

require app_path().'/overrides.php';

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|--------------------------------------------------------------------------
| Require The Widgets File
|--------------------------------------------------------------------------
|
| Next we will load the widgets file for the application. This gives
| us a nice separate location to register our custom widgets.
|
*/

require app_path().'/widgets.php';
