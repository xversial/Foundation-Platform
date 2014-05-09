## Themes

Platform 2 uses [Cartalyst's Themes 2 package](http://cartalyst.com/manual/themes) for managing themes. Because of re-using it, Platform 2 comes with all of the goodness of Themes 2 like asset queuing and compiling. In the documentation below you can find out how to create your own custom themes.

### Creating Themes

You can add different themes to Platform 2 to adjust the look and feel of your application. Themes are located in the `public/themes` directory. Platform 2 ships with 2 default themes: `frontend/default` and `admin/default`. These themes are namespaced in the same order as composer packages in order to prevent naming collisions.

You can add your own theme as long as it's namespaced in the following order: `area/my-own-theme`. The `area` being an area for your locations (for example: back-end, front-end, help center, etc...) and your theme name. Add a `theme.json` file with all the info for your theme. A basic theme.json file should look like this:

	{
		"name": "Default Frontend Theme",
		"slug": "frontend::default",
		"description": "The default theme.",
		"author": "Cartalyst LLC",
		"version": "2.0"
	}

After creating your theme, you can simply go into the Platform 2 settings and select it as the default theme. You can now also create extension assets specifically for your theme.

> Please note that the slug you're adding in the `theme.json` file needs to be exactly the same as the theme's namespaced folder names.


### Theme Assets

Because Platform 2 uses Cartalyst's Themes 2 package it comes with all of the goodness for asset queuing and compiling. More info about using theme assets can be found in [the Themes 2 documentation](http://cartalyst.com/manual/themes).

**Asset Queuing**

Add assets for your views by queuing them to be compiled later.

	Asset::queue($alias, $path, $dependencies);

Param | Description
----- | ------------
$alias | The file alias. This can be used later to indicate asset dependencies.
$path | The path where to locate the alias. You can include a file in the theme's assets folder or use the `vendor/packages::path` convention to load an external theme's asset file.
$dependencies | Add asset aliases in an array to indicate asset dependencies. These will be loaded then be compiled in a specific sequence so your asset dependencies are loaded before your asset file.

You can also queue `.less` files and they'll be compiled automatically.

	Asset::queue('style', 'css/style.less');

**Asset Compiling**

When you've queued your assets you can later compile them, for example, in your theme's header. You can use the `getCompiledStyles()` function to compile style sheets and the `getCompiledScripts()` function to compile Javascript files.

	@foreach (Asset::getCompiledStyles() as $url)
		{{ HTML::style($url) . PHP_EOL }}
	@endforeach
