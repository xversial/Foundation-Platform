# What is Platform 2

> **Note:** Platform 2 is in Early Beta, Documentation is incomplete and in active development. Please see our quick start guide here. https://gist.github.com/driesvints/b0730aeeccd55fbb2549

> **Note:** To use Cartalyst's Platform 2 application you need to have a valid Cartalyst.com subscription.
Click [here](https://www.cartalyst.com/pricing) to obtain your subscription.

Cartalyst's Platform 2 application provides a very flexible and extensible way of building your custom application. It gives you a basic installation to get you quick-started with content management, themeable views, application extensions and much more. Pretty much everything on Platform 2 can be extended and overwritten so you can add your own functionality. Platform 2 is not just another CMS, it's a starting point for you to build your application providing the tools you need to get the job done as easy as possible.

----------

<a name="features"></a>
### Features

#### Flexibility

The main goal of Platform 2 was flexibility. Platform 2 aims to be as unobtrusive
to your application as possible, while providing all the features to make it
awesome and **save you time**. The `app` folder is almost identical to a
stock-standard Laravel 4 `app` folder, with a few registered service
providers and preset configurations.

The end result? You can continue to make any application you would like without
having to conform to Platform "standards" or "practices".

Want to install Platform 2 for an administration area but build a completely custom
website? Sure, just start working with `app/routes.php` as you normally would.
Utilize our API, data and extensions where you need, they won't get in your way.

#### Extensibility

Platform 2 was made to be even more extendible than Platform 1. A number of key files to get you off the ground with extending Platform is:

 - `app/routes.php`
 - `app/hooks.php`
 - `app/functions.php`
 - `app/overrides.php`

These files provide a number of templates and boilerplate code for you to override extension classes, API routes, hook into system events and add custom logic.

#### Themeable

You can add different themes to Platform 2 to adjust the look and feel of your application. Themes are located in the `public/themes` directory. Platform 2 ships with 2 default themes: `frontend/default` and `admin/default`. Again, these themes are namespaced in the same order as composer packages in order to prevent naming collisions.

You can add your own theme as long as it's namespaced in the following order: `area/my-own-themes`. The `area` being an area for your locations (for example: back-end, front-end, help center, etc...) and your theme name. Add a `theme.json` file with all the info for your theme. A basic theme.json file could look like this:

	{
		"name":        "Default Frontend Theme",
		"slug":        "frontend::default",
		"description": "The default theme.",
		"author":      "Cartalyst LLC",
		"version":     "2.0"
	}

After creating your theme, you can simply go into the Platform 2 settings and select it as the default theme. You can now also create extension assets specifically for your theme.

> **Note:** please note that the slug you're adding in the `theme.json` file needs to be exactly the same as the theme's namespaced folder names.







### Publishing Assets

You can publish extension assets by running the built-in `theme:publish` command with the `--extensions` flag.

	php artisan theme:publish --extensions

Optionally you can specify to just publish the assets of a specific extension by providing its vendor/name on the `--extension` flag.

	php artisan theme:publish --extension=platform/menus

### Watching Assets

Should you want to publish assets automatically to themes when you're editing them inside your extensions you can do so by adding an extra `--watch` flag to your `theme:publish --extensions` command.

	php artisan theme:publish --extensions --watch

This will make sure that your assets get published to the corresponding theme whenever you save them.

Of course you can just watch assets for a specific extension as well.

	php artisan theme:publish --extension=platform/menus --watch

### Theme Assets

Because Platform 2 uses Cartalyst's Themes 2 package it comes with all of the goodness for asset queuing and compiling. More info about using theme assets can be found in [the Themes 2 documentation](http://docs.cartalyst.com/themes-2).

**Asset Queuing**

Add assets for your views by queuing them to be compiled later.

	Asset::queue($alias, $path, $dependencies);

- **Alias:** The file alias. This can be used later to indicate asset dependencies.
- **Path:** The path where to locate the alias. You can include a file in the theme's assets folder or use the `vendor/packages::path` convention to load an external theme's asset file.
- **Dependencies:** Add asset aliases in an array to indicate asset dependencies. These will be loaded then be compiled in a specific sequence so your asset dependencies are loaded before your asset file.

You can also queue `.less` files and they'll be compiled automatically.

	Asset::queue('style', 'css/style.less');

**Asset Compiling**

When you've queued your assets you can later compile them, for example, in your theme's header. You can use the `getCompileStyles` function to compile style sheets and the `getCompileScripts` function to compile Javascript files.

	@foreach (Asset::getCompiledStyles() as $url)
		{{ HTML::style($url) . PHP_EOL }}
	@endforeach

<a name="content"></a>
## Pages

Just like in a normal CMS you can add pages to your application. Platform 2 provides support to store the content for these pages in the database or make use of the filesystem to use static view files which are part of your theme. These static view files can include various content sections and prove to be very dynamic. You can later re-use these view files in other parts of your application.

<a name="pages"></a>
## Content

Most of the content you create in Platform 2 can be either content stored in the database or in static content files. Content files are saved in the `public/content` folder. After creating a content file you can create a content entry for it in the Platform 2 back-end.

Content entries, either static or database driven can be used in views directly by including them with their slug throught the `@content('content-entry-slug')` method. This method is an extension to the blade templating language specially made to work with Platform 2.
