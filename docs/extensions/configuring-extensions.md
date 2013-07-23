### Configuring Extensions

- [Introduction](#introduction)
- [name](#name)
- [slug](#slug)
- [author](#author)
- [description](#description)
- [version](#version)
- [require](#require)
- [autoload](#autoload)
- [uri](#uri)
- [register](#register)
- [boot](#boot)
- [routes](#routes)
- [permissions](#permissions)
- [widgets](#widgets)
- [plugins](#plugins)
- [settings](#settings)
- [menus](#menus)

<a name="introduction"></a>
#### Introduction

Below we'll go over all of the configuration options for a Platform 2 extension. All configuration options can be set in the `extension.php` file. This works exactly as any other Laravel 4 configuration file. The titles for these configuration options represent the key which can be set in the configuration array.

<a name="name"></a>
#### name

The name for your extension. 

<a name="slug"></a>
#### slug

This is your extension unique identifier and should not be changed as it will be recognized as a new extension. Ideally, this should match the folder structure within the extensions folder, but this is completely optional.

<a name="author"></a>
#### author

The author of the extension.

<a name="description"></a>
#### description

One or two sentences describing the extension for users to view when they are managing the extension.

<a name="version"></a>
#### version

Version should be a string that can be used with the `version_compare` function. This is how the extension's versions are compared.

<a name="require"></a>
#### require

You should list here all the extensions this extension requires to work properly. This is used in conjunction with Composer, so you should put the same extension dependencies on your composer.json require key so that they get resolved using composer, however you can use without composer, at which point you'll have to ensure that the required extensions are available.

	'require' => array(

		'platform/admin',

	),

<a name="autoload"></a>
#### autoload

Here You can define your extension's autoloading logic. It may either be `composer`, `platform` or a Closure.

If composer is defined, your `composer.json` file specifies the autoloading logic.

If platform is defined, your extension receives convention autoloading based on the Platform standards.

If a Closure is defined, it should take two parameters as defined below:

	object Composer\Autoload\ClassLoader      $loader
	object Illuminate\Foundation\Application  $app

<a name="uri"></a>
#### uri

You can specify the URI that this extension will respond to.

You can choose to specify a single string, where the URI will be matched on the 'admin' and 'public' sections of Platform.

	'uri' => 'users',

Or you can provide an array with the 'admin' and 'public' keys to specify a different URI for admin and public sections, you can have as many keys as you need in case your applications needs them.

	'uri' => array(
		'admin'  => 'users',
		'public' => 'accounts',
	),

You can provide an 'override' which is an array of extensions this extension overrides it's URI from.

<a name="register"></a>
#### register

Much like Laravel's service providers, the `register` key is where all the custom logic goes when registering extension functionality. You're required to register them through a closure.

The closure parameters are:

	object Cartalyst\Extensions\ExtensionInterface  $extension
	object Illuminate\Foundation\Application        $app

<a name="boot"></a>
#### boot

The boot method can be used to override application logic or initialize custom functionality. Again, you can do this by providing a closure.

The closure parameters are:

	object Cartalyst\Extensions\ExtensionInterface  $extension
	object Illuminate\Foundation\Application        $app

<a name="routes"></a>
#### routes

Your custom extension routes. This is done exactly the same way as you'd register routes in your `routes.php` file. Just provide the route through a closure.

The closure parameters are:

	object Cartalyst\Extensions\ExtensionInterface  $extension
	object Illuminate\Foundation\Application        $app

<a name="permissions"></a>
#### permissions

List of permissions this extension has. These are shown in the user management area to build a graphical interface where permissions may be selected.

The admin controllers state that permissions should follow the following structure:

	vendor/extension::area.controller@method

For example:

	platform/users::admin.usersController@index
	Platform\Users\Controllers\Admin\UsersController@getIndex

These are automatically generated for controller routes however you are free to add your own permissions and check against them at any time.

When writing permissions, if you put a `'key' => 'value'` pair, the `'value'` will be the label for the permission which is displayed when editing permissions.

For example, a part of the permissions array in the `extension.php` file for the Platform 2 Users extension looks like the following:

	'permissions' => function()
	{
		return array(
			'platform/users::admin.usersController@index'  => Lang::get('platform/users::users/permissions.index'),
			'platform/users::admin.usersController@create' => Lang::get('platform/users::users/permissions.create'),
			'platform/users::admin.usersController@edit'   => Lang::get('platform/users::users/permissions.edit'),
			'platform/users::admin.usersController@delete' => Lang::get('platform/users::users/permissions.delete'),
		);
	},

<a name="widgets"></a>
#### widgets

List of custom widgets associated with the extension. Like routes, the value for the widget key may either be a closure or a class & method name (joined with an @ symbol). Of course, Platform will guess the widget class for you, this is just for custom widgets or if you do not wish to make a new class for a very small widget.

<a name="plugins"></a>
#### plugins

Is configured exactly the same as widgets (see above).

<a name="settings"></a>
#### settings

Register any settings for your extension. You can also configure the namespace and group that a setting belongs to.

For example, part of the Platform 2 Users's extension settings looks like the following:

	'settings' => function()
	{
		return array(
			'users' => array(
				'name' => 'Users'
			),

			'users::general' => array(
				'name' => Lang::get('platform/users::settings.section.general'),
			),

			'users::general.registration' => array(
				'name'    => Lang::get('platform/users::settings.registration.label'),
				'config'  => 'platform/users::registration',
				'info'    => Lang::get('platform/users::settings.registration.info'),
				'type'    => 'radio',
				'options' => array(
					array(
						'value' => false,
						'label' => Lang::get('general.no'),
					),
					array(
						'value' => true,
						'label' => Lang::get('general.yes'),
					),
				),
			),
		);
	},

<a name="menus"></a>
#### menus

You may specify the default various menu hierarchy for your extension. You can provide a recursive array of menu children and their children. These will be created upon installation, synchronized upon upgrading and removed upon uninstallation.

Menu children are automatically put at the end of the menu for extensions installed through the Operations extension.

The default order (for extensions installed initially) can be found by editing `app/config/platform.php`.

For example, the menu structure for the Platform 2 Users extension looks like the following:

	'menus' => array(

		'admin' => array(

			array(
				'slug'     => 'admin-users',
				'name'     => 'Users',
				'class'    => 'icon-user',
				'uri'      => 'users',
				'children' => array(

					array(
						'slug'  => 'admin-users-users',
						'name'  => 'Users',
						'class' => 'icon-user',
						'uri'   => 'users',
					),

					array(
						'slug'  => 'admin-users-groups',
						'name'  => 'Groups',
						'class' => 'icon-group',
						'uri'   => 'users/groups',
					),
				),
			),
		),
	),