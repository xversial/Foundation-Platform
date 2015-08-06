### Create Extensions

Because extensions are basically separated app folders there really is no limit to what you can build with them. You could write a media manager extension or a notification handler extension which you can re-use on different Platform 4 applications.

#### Using The Workshop Extension

The easiest way to get started with an extension is to create one though the Workshop extension. To get started browse to `admin/operations/workshop` in your Platform 4 back-end.

You'll notice a series of input fields which will be needed to generate your extension files. We'll go over each one of them.

**Author name and email**

These will be used in your `composer.json` file under the `authors` key.

**Vendor and Name**

These define the namespace for your extension. The Vendor name is a unique identifier like your company or application name. The Name is of course your extension's main name (f.e. `Media` or `Notifications`).

**Description**

Your extension's description.

**Dependencies**

A list with other extensions on which your extension depends on. List them below eachother as `vendor/name`.

**Prepopulating Components**

You can choose to have the Workshop generate some standard files for you like a basic configuration file, some controllers or theme views to get you started with your extension. If you don't want this just leave the checkboxes blank.

**Installation**

After filling in the fields, you can choose to install your extension automatically or manually.

Automatic install will install the component in the workbench directory in your application root. Make sure the folder exists and is writeable before you attempt this.


#### Manually Creating Extensions

Manually creating an extensions takes a bit more work. There are two required files for creating extensions: the `composer.json` file and the `extension.php` file.

See [requirements](#installation) for more info.

Once your extension has been created, it's time to start adding functionality.

At the heart of your extension is `extension.php`. This file holds your providers, routes, database seeds, permissions, widgets, settings, menus, and more.

##### Menus

Menus are defined using a nested array structure. Any menus that you create here are added to the database whenever your extension is installed, sychronized when it's upgraded, and removed when it's uninstalled. Menus that are defined here will be **appended** to any menus that are defined in the core application when the extension is installed through Platform's extensions interface.

The best way to understand how extension menus work is to study some examples. Platform's Menus extension is the perfect place to start: https://github.com/cartalyst/platform-menus/blob/master/extension.php#L244-L398 . Notice that the top-level array keys match the menu names that are visible in the Platform Menus interface. This is how your extension adds menu items to a given menu. To add a new item to your site's primary navigation, for example, simply modify the `menus` array accordingly:

	'menus' => [

		'main' => [

			[
				'slug' => 'main-customer-service',
				'name' => 'Customer Service',
				'uri' => 'customer-service',
				'children' => [

					[
						'slug'  => 'main-service-centers',
						'name'  => 'Service Centers',
						'uri'   => '#',
						'class' => 'dropdown-header',
						'roles' => [
							'registered',
						],

					],

				],

			],

		],

	],

This snippet would add a new "Customer Service" item to the end of the primary navigation menu, which would in turn have one child menu item, "Service Centers".

The key names in the snippet above correspond to the column names in the database, which means that any menu property that can be defined using the Platform interface can also be used here.

Restricting menu visibility to certain roles requires passing the `roles` key an array of role slugs.

> **Note** It is necessary to uninstall/reinstall an extension for any changes to the menu data in `extension.php` to become effective. This is because the menu data is added to the database only upon installing the extension. There are buttons at the top of the Extension interface that may be used to perform the uninstall/reinstall.

> **Note** Menu items are disabled as long as the extension is disabled, once enabled, the menu is automatically enabled and vice versa.

#### Enabling an Extension

After that your extension is added to the extensions folder you can install and enable it through the admin back-end under the operations section. Your extension will be listed amongst the other extensions. Click the edit button to install and enable your extension.

Remember that you can always go back here to disable or uninstall your extension.


#### Registering Widgets

Widgets can be used to provide small pieces of views which can be easily re-used throughout your application or extension.

If you want to register a small widget but don't want to create a class for it you can do it directly in the `extension.php` file.

	'widgets' => array(
		'foo' => function ()
		{
			// return content.
		}
	),

If you'd like to create a separate class for the widget to have some extra functionality you can create a class in the `widgets` folder. By default, Platform 4 will register your widgets by using your class name as the widget key. You can override this by registering the widget in the `extension.php` file.

	'widgets' => array(
		'foo' => 'My\Widget\Namespace\Foo@someMethod',
	),

For more info on creating widgets see [the widgets documentation](#widgets).
