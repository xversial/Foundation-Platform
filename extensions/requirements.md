### Requirements

**composer.json**

One requirement for Platform 4 to detect composer packages as extensions is to
place the following in your package's `composer.json` file:

    "type": "platform-extension",
    "require": {
        "cartalyst/composer-installers": "1.0.*"
    }

The `"type": "platform-extension"` will identify your package as a Platform 4 extension. When extensions are published, Platform 4 will look for composer packages with this rule in their `composer.json` file and publish the extension to the extensions folder.

> **Note:** Remember that you don't have to format your extensions to follow PSR-0 rules. Extensions extend the Laravel application directly and should be structured in the same way as your `app` directory.

**extension.php**

This file, which resides in the root of your extension folder is the configuration file for your extension. It defines info like the extension name, uri, version, etc. as well as the extension routes, menus, permissions, widgets, etc.

For a detailed anatomy of the `extension.php` file, have a look at [configuring extensions](#configuring-extensions).
