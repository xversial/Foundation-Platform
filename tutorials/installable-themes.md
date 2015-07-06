### Installable Themes

Platform themes can be installed from their own repositories. This allows you to reuse your own themes from project to project. Heres how you do it.

#### 1. Create or duplicate a theme

Choose which theme area to duplicate. Platform ships with two theme areas. frontend & admin. You can name the repository whatever you like. We follow the convention `theme-name-area`

    https://github.com/cartalyst/theme-default-admin
    https://github.com/cartalyst/theme-default-frontend

#### 2. Update your new themes `theme.json` file

    {
        "name":        "Default Admin Theme",
        "slug":        "admin::default",
        "description": "The default admin theme.",
        "author":      "Cartalyst LLC",
        "version":     "2.0"
    }

#### 3. Update your themes composer.json

Platform will automatically install themes using our handy [composer-installers](https://cartalyst.com/manual/composer-installers) package.

Open your themes `composer.json` and update the following values.

    "name": "vendor/area-name",
    "type": "platform-theme",

Setting the type to `platform-theme` tells platform that the repository is a theme to be installed to specific location.

The part after your vendor name is the directory structure for where the theme will be installed.

`"name": "foo/bar-bat",` would install your theme to `public/themes/bar/bat`. If your simply creating a new platform admin theme you'd name it something like `"name": "acme/admin-custom"` and would be installed in `public/themes/admin/custom`

> Note: Installing repositories to any location is a breeze with our composer-installer package. Check out where the magic happens for themes. [ThemeInstaller.php](https://github.com/cartalyst/composer-installers/blob/1.2/src/ThemeInstaller.php)

#### 4. Hosting your theme

You'll need to host your extension as a `VCS` repository (https://getcomposer.org/doc/05-repositories.md#vcs) or using Satis (https://getcomposer.org/doc/05-repositories.md#satis)

###### VCS

You can add a vcs repository to your `composer.json` file as follows

    "repositories": [
        {
            "type": "vcs",
            "url": ":repository_url"
        }
    ]

##### Satis

Adding a satis repository works similar to the cartalyst repository located on our theme's `composer.json` files.

    "repositories": [
        {
            "type": "composer",
            "url": "satis_url"
        }
    ]

#### 5. Update your platform `composer.json` file

Require your newly created theme just below our default themes in your Cartalyst Platform `composer.json` file.

    "require": {
        ...
        ...
        "acme/admin-custom": "dev-master"
    }

Voila! Run `composer install` and your new theme should appear in the themes directory as described in step 3.

Code well, rock on!
