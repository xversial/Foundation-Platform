<a name="requirements"></a>
### Requirements

Follow the Laravel documentation instructions for [configurating Laravel](http://laravel.com/docs/installation#configuration).

Please make sure that your server has write permissions to the following files and directories:

- The `app/config` folder (necessary for writing the Platform 2 config files)
- The `app/storage` folder and its contents
- The `public/assets` folder and its contents

----------

<a name="install"></a>
### Installation

Start out by [downloading a copy of Platform 2](https://github.com/cartalyst/platform2/archive/master.zip) from Github. Unzip the `.zip` file and place the Platform 2 folder in a location that suits you. You can also clone Platform 2 through Git:

	git clone git@github.com:cartalyst/platform2 my-project

Navigate to the Platform 2 folder in your CLI and run the following command.

	composer install

This will install all of Platform 2 dependencies and publish its assets into the `public` folder.

From here on out you have two options to proceed: either use the CLI installer which comes with Platform 2 (recommended) or use the browser installer.

#### The CLI Installer

Using the CLI installer is easy. Just run the following command in your CLI and follow the installation steps.

	php artisan platform:install

#### The Browser Installer

You should now see the Platform 2 installer when you navigate to the project in your browser. Follow its instructions.

Agree to the Platform 2 License in order to proceed.

> **Note:** If you aren't installing on your localhost you can add trusted IP's to the installer's config file in `app\config\packages\platform\installer\config.php`.

You've now successfully installed Platform 2 and should see the default page.

----------

#### Custom Installer

You may also choose to use your own installer by extending ours or completely replacing it. Platform 2 is an application-base, and thus it is flexible. If you're distributing an app, you probably don't want a Platform installer for it, you probably want your own installer with your own custom logic. Just change the requirements in `composer.json` and register your own installer's service provider.
