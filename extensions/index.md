## Extensions

Extensions allow you to extend Platform 3 beyond its basic functionality. The
default extensions for Platform 3 are actually composer packages. If you want,
for example, to add a media library, you could add it as a composer package
and after running a composer install, it would get published to the
extensions folder on your Platform 3 application.

Extensions may also be part of your application's repo and not separate composer
packages. They may sit under the extensions or the workbench folder. Be sure to
adjust `extensions/.gitignore` file for your own needs.

An extension can hold views, controllers, migrations, models, languages files,
anything you'd normally create in the Laravel 5 `app` directory. This gives
you a nice and convenient way of separating your functionality which you
can later re-use in other applications. Most extensions can be managed
under the operations tab in the Platform 3 admin panel.

Cartalyst's Platform 3 heavily relies on extensions as most of its core functionality
are based on extensions.

> **Note:** All extensions present at the installation time will be installed.
There is no need to modify the installer for any custom extensions you may have.
This makes distributing your own apps or sites that run on Platform 3 a breeze.
