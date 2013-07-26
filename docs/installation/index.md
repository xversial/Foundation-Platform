### Install & Configure Platform 2

> **Note:** To use Cartalyst's Platform 2 application you need to have a valid Cartalyst.com subscription.
Click [here](https://www.cartalyst.com/pricing) to obtain your subscription.

1. [Get Platform 2](#get-platform-2)
2. [Composer](#composer)
3. [Configure Laravel](#configure-laravel)
4. [Permissions](#permissions)
5. [Trusted IPs](#trusted-ips)
6. [The CLI Installer](#the-cli-installer)
7. [The Browser Installer](#the-browser-installer)
8. [Custom Installer](#custom-installer)

<a name="get-platform-2"></a>
#### 1. Get Platform 2

You can get Platform 2 by cloning the repository from Github.

	git clone https://github.com/cartalyst/platform2.git my-platform2-project

Platform 2 can also be installed by simply [downloading a copy from Github](https://github.com/cartalyst/platform2/archive/master.zip). After downloading, unzip the `.zip` folder in a location that suits you.

> **Note:** Installing by cloning from the Github repository is the preferred method as this gives you an easy way to update Platform 2 by merging changes from the original Github repository.

<a name="composer"></a>
#### 2. Composer

After getting Platform 2, you can install all of Platform 2's dependencies by running a composer install command in your CLI. Navigate to your Platform 2 folder and run the following command.

	composer install

<a name="configure-laravel"></a>
#### 3. Configure Laravel

Before you can get started with Platform 2, you'll still have to configure the Laravel 4 framework. Platform 2 is built with Laravel 4 so some configuration is necessary. Please follow all steps detailed in [the Laravel 4 configuration documentation](http://laravel.com/docs/installation#configuration).

<a name="permissions"></a>
#### 4. Permissions

Platform 2 requires the following folders to have write access by the web server:

- The `app/config` folder (necessary for writing the Platform 2 config files)
- The `public/assets` folder and its contents
- The `app/storage` folder and its contents

<a name="trusted-ips"></a>
#### 5. Trusted IPs

If you aren't installing on your localhost you can add trusted IP's to the installer's config file in `app\config\packages\platform\installer\config.php`.

<a name="the-cli-installer"></a>
#### 6. The CLI Installer

The easiest way to install Platform 2 is to run the CLI installer. Just run the following command and follow all of the steps.

	php artisan platform:install

<a name="the-browser-installer"></a>
#### 7. The Browser Installer

You should see the Platform 2 installer when you navigate to the project in your browser. Follow its instructions.

<a name="custom-installer"></a>
#### 8. Custom Installer

You may also choose to use your own installer by extending ours or completely replacing it. Platform 2 is an application-base, and thus it is flexible. If you're distributing an app, you probably don't want a Platform installer for it, you probably want your own installer with your own custom logic. Just change the requirements in `composer.json` and register your own installer's service provider.