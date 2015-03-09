## Overrides

Overrides in Platform 3 give you the ability to easily swap core functionality with your own custom functionality.

### Route Overrides

Because we use an internal REST API, you have the ability to override any route for an API call to your own logic. This makes extending Platform 3 extremely easy and can be done from anywhere.

To override them open the `app/routes.php`.

For example, overriding the page slug route.

	Route::get('page/{slug}', 'My\Custom\PagesController@show')->where('slug', '.*?');

### Model Overrides

The default Platform extensions use the IoC to resolve model instances. You can override these here by simply returning your own model which extends ours.

To override them open the `app/overrides/models.php`.

For example, overriding the default Platform 3 Content model.

	$app['Platform\Content\Models\Content'] = new My\Custom\Models\Content;

### Service Overrides

Each Service Provider and Extension registers a number of application services.

To override them open the `app/overrides/services.php` and customize the behavior of your Platform application.

	$app['foo.bar'] = $app->share(function($app)
	{
		return new My\Foo\Bar;
	});
