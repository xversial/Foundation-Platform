<?php

return array(

	/*
	|-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
	| Installed Version
	|-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
	|
	| This variable holds the installed version of Platform. You are highly
	| discouraged from touching this, ever.
	|
	| How It Works:
	|     On a blank install, the installed version is FALSE, meaning Platform
	|     isn't installed. We check this version against the PLATFORM_VERSION
	|     constant. If this version is less, meaning you've upgraded the
	|     Platform codebase, we lock out the application and send you to the
	|     installer where you are taken through the upgrade process. This is
	|     why touching this variable is a BAD idea.
	|
	*/

	'installed_version' => false,

);
