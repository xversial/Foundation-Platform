## Overrides

Overrides in Platform 3 give you the ability to easily swap core functionality with your own custom functionality. You can override any of the Platform 3 defaults within your own custom extension.

### Route Overrides

To override a route defined in another extension, create a custom extension which requires it as a dependency. Within the routes section of `extension.php`, any routes you define in your custom extension will take precedent over those defined in the other extension.

### Model and Service Overrides

The default Platform extensions use the IoC to resolve model instances. You can override these models here by simply returning your own model which extends ours or implements the appropriate interface.

Model or Service overrides should be placed in a service provider within a new extension. For example, these are the steps you would take to override the Users model within Platform:

 - Create a new custom extension (we'll call it `UserOverride`) in the workbench and define `Platform/Access` and `Platform/Users` as dependencies.
 - Within the extension, create `src/Providers/UserOverrideServiceProvider.php` and add `'Platform\Useroverride\Providers\UserOverrideServiceProvider'` to the providers array in extension.php
 - In your new service provider, set the new Users model on the IoC instance:

     	public function boot()
     	{
        	$this->app['sentinel.users']->setModel('My\Custom\Models\User');
     	}
     
Within your custom service provider, you can also override service bindings like this:

	$app['foo.bar'] = $app->share(function($app)
	{
		return new My\Foo\Bar;
	});
