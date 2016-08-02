### Theme Assets

Because Platform 5 uses Cartalyst's Themes package it comes with all of the goodness for asset queuing and compiling. More info about using theme assets can be found in [the Themes documentation](http://cartalyst.com/manual/themes).

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
