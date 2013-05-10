<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Platform
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

/*
|--------------------------------------------------------------------------
| After Installation
|--------------------------------------------------------------------------
|
| Configuration the administration of your Platform application.
|
*/

Installer::after(function()
{

	// If our admin class exists, we'll go ahead and set
	// the order of the admin menu now according to the
	// specific applictaion's requirements.
	if (class_exists('Platform\Ui\Models\Menu'))
	{
		set_menu_order('admin', Config::get('platform.admin.menu'));
	}

});

/*
|--------------------------------------------------------------------------
| Platform hooks
|--------------------------------------------------------------------------
|
| Hooks for Platform events themselves
|
*/

Platform::booting(function($platform)
{
	// Before Platform and it's extensions have booted
});

Platform::booted(function($platform)
{
	// When everything is setup and ready to roll
});


Platform::ineligible(function($platform)
{
	// Whenever Platform cannot run (needs installing etc)
});

/*
|--------------------------------------------------------------------------
| Extension hooks
|--------------------------------------------------------------------------
|
| Hooks for various stages of an Extension's lifecycle. You can access the
| individual extension properties through $extension->getSlug().
|
*/

Extension::registering(function(Extension $extension)
{
	// Before an extenesion is registered (happens for every extension)
});

Extension::registered(function(Extension $extension)
{
	// After an extension is registered
});

Extension::booting(function(Extension $extension)
{
	// Before an installed, enabled extension boots (after all are registered)
});

Extension::booted(function(Extension $extension)
{
	// After an installed, enable extension boots
});

Extension::installing(function(Extension $extension)
{
	// Before an extension is installed
});

Extension::installed(function(Extension $extension)
{
	// After an extension is installed
});

Extension::enabling(function(Extension $extension)
{
	// Before an extension is enabled
});

Extension::enabled(function(Extension $extension)
{
	// After an extension is enabled
});

Extension::disabling(function(Extension $extension)
{
	// Before an extension is disabled
});

Extension::disabled(function(Extension $extension)
{
	// After an extension is disabled
});

Extension::upgrading(function(Extension $extension)
{
	//
});

Extension::upgraded(function(Extension $extension)
{
	//
});

