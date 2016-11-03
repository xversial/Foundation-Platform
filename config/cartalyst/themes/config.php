<?php

/**
 * Part of the Themes package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Themes
 * @version    4.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Active Theme
    |--------------------------------------------------------------------------
    |
    | Here you will define the default active theme your application
    | will be using. Set the value to null if no theme is defined.
    |
    */

    'active' => null,

    /*
    |--------------------------------------------------------------------------
    | Fallback Theme
    |--------------------------------------------------------------------------
    |
    | Here you'll define the default fallback theme your application
    | will be using. Set the value to null if no theme is defined.
    |
    */

    'fallback' => null,

    /*
    |--------------------------------------------------------------------------
    | Theme Paths
    |--------------------------------------------------------------------------
    |
    | Here you'll define the default theme paths for your application.
    |
    */

    'paths' => [

        resource_path('themes'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Packages Path
    |--------------------------------------------------------------------------
    |
    | Here, you set the path (relative to your theme's root folder) for all
    | packages to reside.
    |
    */

    'packages_path' => 'extensions',

    /*
    |--------------------------------------------------------------------------
    | Namespaces Path
    |--------------------------------------------------------------------------
    |
    | We even let you theme up Laravel 5 view namespaces. You can register a
    | namespace for a view, for example:
    |
    |	View::addNamespace('foo/bar', '/var/www/some/namespace');
    |
    | This means that, when you call:
    |
    |	View::make('foo/bar::test');
    |
    | It will look in the namespace you specified. However, you can also call
    | Theme::namespace('foo/bar'); which means that all calls to the 'foo/bar'
    | namespace will first check for that namespace within your theme first,
    | before falling back to the hard-coded namespace. Yes, you can theme any
    | view in Laravel now!
    |
    */

    'namespaces_path' => 'namespaces',

    /*
    |--------------------------------------------------------------------------
    | Views Path
    |--------------------------------------------------------------------------
    |
    | List the path (within each theme and it's packages) where views are
    | located.
    |
    */

    'views_path' => 'views',

];
