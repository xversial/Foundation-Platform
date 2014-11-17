## Concepts

The main goal of Platform is flexibility. Platform aims to be as unobtrusive
to your application as possible, while providing all the features to make it
awesome and **save you time**. The `app` folder is almost identical to a
stock-standard Laravel 4 `app` folder, with a few registered service
providers and preset configurations.

The end result? You can continue to make any application you would like without
having to conform to Platform "standards" or "practices".

Want to install Platform for an administration area but build a completely custom
website? Sure, just start working with `app/routes.php` as you normally would.
Utilize our API, data and extensions where you need, they won't get in your way.

### Extensibility


Platform 2 was made to be even more extendable than Platform 1. A number of key files to get you off the ground with extending Platform are:

 - `app/hooks.php`
 - `app/functions.php`
 - `app/overrides.php`

These files provide a number of templates and boilerplate code for you to override extension classes, API routes, hook into system events and add custom logic.
