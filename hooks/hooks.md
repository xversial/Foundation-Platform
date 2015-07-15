## Hooks

Platform 4 hooks are events which are fired at various occasions throughout certain Platform 4 actions.

They give you the oportunity to do something when the event is fired. You can find these hooks in the `app/hooks.php` file.

### Operation Hooks

Hook into the installation / upgrading of your Platform installation. Registered with the `Installer::<event>` convention.

Event | Description
----- | ------------
before | Called before Platform is to be installed
after | Called after Platform has been installed

For example:

	Installer::before(function()
	{
		// do something.
	});


### Platform Hooks

Hooks for events of Platform itself. Registered with the `Platform::<event>` convention.

Event | Description
----- | ------------
booting | Before Platform and it's extensions have booted
booted | When everything is setup and ready to roll
ineligible | Whenever Platform cannot run (needs installing etc)

For example:

	Platform::booting(function($platform)
	{
		// do something
	});


### Extension Hooks

Hooks for various stages of an Extension's lifecycle. You can access the individual extension properties through `$extension->getSlug()`. Registered with the `Extension::<event>` convention.

Event | Description
----- | ------------
registering | Before an extension is registered (happens for every extension)
registered | After an extension is registered
booting | Before an installed and enabled extension boots (after all are registered)
booted | After an installed and enabled extension boots
installing | Before an extension is installed
installed | After an extension is installed
uninstalling | Before an extension is uninstalled
uninstalled | After an extension is uninstalled
enabling | Before an extension is enabled
enabled | After an extension is enabled
disabling | Before an extension is disabled
disabled | After an extension is disabled
upgrading | Before an extension is upgraded
upgraded | After an extension is upgraded

For example:

	Extension::registering(function(Extension $extension)
	{
		// do something.
	});
