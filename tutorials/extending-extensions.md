### Extending Extensions

To override/extend logic from an existing extension would be to create a new extension and start overriding any logic needed on there.

1. Create a new extension `:vendor/:extension`
2. Add `platform/:extension` to the require array on `extension.php` to ensure the the new extension is registered, booted and installed after `platform/:extension`.

> **Note** `:vendor`, `:Vendor` used on this page refer to your custom vendor name, `:extension`, `:Extension` refer to the extension in question.

#### Overriding the model

1. Create a new service provider and add it to the providers array on `extension.php` and add the following code to the `register` method of your new service provider.
2. Create a new model. (can extend the default model)

```
$this->app->bind('Platform\:Extension\Models\:Model', ':yourModel');
```

#### Overriding a controller

Overriding a controller requires re-defining the routes to point to the new controller.

1. Create a new controller that extends the default controller under your extension.
2. Override or add new methods to the new controller.
3. Redefine the routes you want to be handled by your new controller on `extension.php` and make sure to reference your new controller.

##### Example

The code below will override the `/` routes (GET, POST) to use the new controller.

```
Route::group(['namespace' => ':Vendor\:Extension\Controllers'], function()
{
    Route::group([
        'prefix'    => admin_uri().'/:extension',
        'namespace' => 'Admin',
    ], function()
    {
        Route::get('/' , ['as' => 'admin.:extension.all', 'uses' => ':ExtensionController@index']);
        Route::post('/', ['as' => 'admin.:extension.all', 'uses' => ':ExtensionController@executeAction']);
    });
});
```

#### Overriding repositories, event and data handlers, or validators

Overriding repositories, event handlers or data handlers requires overriding their binding in the IoC container.

#### Default bindings

- Repository - `platform.:extension`
- DataHandler - `platform.:extension.handler.data`
- EventHandler - `platform.:extension.handler.event`
- Validator - `platform.:extension.validator`

##### Example

Overriding the `UserRepository` would require overriding the offset `platform.users` by adding the following code to the provider's `register` method of your new extension.

```
$this->app->bind('platform.users', ':Vendor\Users\Repositories\UserRepository');
```

Voila! You've successfully extended a Platform extension.

Code well, rock on!
