<?php

/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Platform
 * @version    7.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Platform\Pages\Models\Page;
use Cartalyst\Extensions\Extension;
use Platform\Installer\Facades\Installer;

/*
|--------------------------------------------------------------------------
| Operation Hooks
|--------------------------------------------------------------------------
|
| Hook into the installation / upgrading of your Platform installation
|
*/

Installer::before(function () {
    // Called before Platform is to be installed
});

Installer::after(function () {
    // Called after Platform has been installed

    // If we have the platform/menus extension installed, we'll
    // set the order of the admin menu according to the
    // specific application requirements.
    if (class_exists('Platform\Menus\Models\Menu')) {
        set_menu_order('admin', config('platform.config.admin.menu'));

        set_menu_order('main', config('platform.config.frontend.menu'));
    }

    // Create the registered role
    $registeredRole = app('sentinel')->getRoleRepository()->createModel();
    $registeredRole->fill([
        'slug' => 'registered',
        'name' => 'Registered',
    ]);
    $registeredRole->save();
});

/*
|--------------------------------------------------------------------------
| Extension Hooks
|--------------------------------------------------------------------------
|
| Hooks for various stages of an Extension's lifecycle. You can access the
| individual extension properties through $extension->getSlug().
|
*/

Extension::booting(function (Extension $extension) {
    // Before an installed and enabled extension boots (after all are registered)
});

Extension::booted(function (Extension $extension) {
    // After an installed and enabled extension boots
});

Extension::installing(function (Extension $extension) {
    // Before an extension is installed
});

Extension::installed(function (Extension $extension) {
    // After an extension is installed
});

Extension::uninstalling(function (Extension $extension) {
    // Before an extension is uninstalled
});

Extension::uninstalled(function (Extension $extension) {
    // After an extension is uninstalled
});

Extension::enabling(function (Extension $extension) {
    // Before an extension is enabled
});

Extension::enabled(function (Extension $extension) {
    // After an extension is enabled
});

Extension::disabling(function (Extension $extension) {
    // Before an extension is disabled
});

Extension::disabled(function (Extension $extension) {
    // After an extension is disabled
});

/*
|--------------------------------------------------------------------------
| Miscellaneous Hooks
|--------------------------------------------------------------------------
|
| Hooks for all other parts of Platform.
|
*/

if (class_exists('Platform\Pages\Models\Page')) {
    Page::rendering(function ($event, $payload) {
        // Page is rendering, return an array of additional data
    });
}
