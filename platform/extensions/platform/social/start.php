<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst Software Licence.
 *
 * @package    Cartalyst Social
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst Software Licence - http://cartalyst.com/licence
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

// make sure sentrysocial is loaded.. we have to do the dependency here
// because extension.php only handles "extension" dependencies and not
// bundle dependencies

Bundle::register('sentrysocial', array(
		'handles' => 'sentrysocial',
		'auto' => true,
	)
);

Autoloader::namespaces(array(
	'Platform\\Social\\Widgets' => __DIR__.DS.'widgets',
));
