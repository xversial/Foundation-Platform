## Setup

### Requirements

Platform is essentially just a series of components that work with Laravel 5.1. So the requirements are virtually the same. However some components may require dependencies with their own set of minimum requirements.

- PHP >= 5.5.9
- MCrypt PHP Extension

### Download Platform

You can get Platform by cloning the repository from GitHub.

	git clone -b 5.0 git@github.com:cartalyst/platform.git My_Project

Platform can also be installed by simply [downloading a copy from GitHub](https://github.com/cartalyst/platform/archive/5.0.zip). After downloading, unzip the `.zip` file into a location that suits you.

> Installing by cloning from the GitHub repository is the preferred method as this gives you an easy way to update Platform by merging changes from the original GitHub repository.

### Install Dependencies

After downloading Platform 5, you can install all of Platform's dependencies by running a composer install command in your CLI. Navigate to your Platform folder and run the following command:

	composer install

### Configure Laravel

Before you can get started with Platform, you'll still have to configure the Laravel 5 framework. Platform is built with Laravel 5 so some configuration is necessary. Please follow all steps detailed in [the Laravel 5 configuration documentation](http://laravel.com/docs/installation#configuration).

### Permissions

Platform requires the following folders to have write access by the web server:

- The `config` folder (necessary for writing the Platform config files).
- The `public/cache` folder and its sub-folders.
- The `public/media` folder and its sub-folders.
- The `storage` folder required by Laravel and its sub-folders.
- The `vendor` folder required by Laravel.

### Install

Platform 5 ships with 2 ways of installation and if required you add your own custom installer.

#### The CLI Installer

The easiest way to install Platform is to run the CLI installer. Just run the following command and follow all of the steps.

	php artisan platform:install

#### The Browser Installer

You should see the Platform installer when you navigate to the project in your browser. Follow the on screen instructions.

> You will need to update the Application URL in `config/app.php` for theme compiling to resolve the font icon dependencies.

#### Custom Installer

You may also choose to use your own installer by extending ours or completely replacing it.

Platform is an application-base, and thus it is flexible.

If you're distributing an app, you probably don't want a Platform installer for it, you probably want your own installer with your own custom logic.

Just change the requirements in `composer.json` and register your own installer's service provider.
