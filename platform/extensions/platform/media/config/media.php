<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst Software Licence.
 *
 * @package    Cartalyst Media
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst Software Licence - http://www.getplatform.com/licence
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return array(

	// The base media directory in the file system,
	// relative to path('public')
	'directory' => 'platform'.DS.'media',

	// The directory for temporary items to be moved
	// into. By default, uploaded items are placed here. This
	// means we can easily empty this directory for files
	// uploadedand abandoned. This is relative to the media
	// directory, defined above.
	'temporary_directory' => 'tmp',


	// File default placement configuration
	'placement' => array(

		// Default dispersion - relative
		// to the media directory PLUS
		// an extension. Format matches
		// PHP date() formats. See
		// http://php.net/manual/en/function.date.php
		// for more. Default is :year/:month/:file
		'dispersion' => 'Y'.DS.'m',

		// Should we randomize the filename
		// When it's saved to the file system
		// for added security?
		'randomize_filename' => false,

		// Override existent files?
		'override_existing' => false,

		// If we set the above option to
		// false, what should we use to
		// separate the filename and it's unique
		// identifier.
		'override_separator' => '_',
	),

	// Default validation config, for when
	// no other validation is passed. This associative
	// array is condensed into a string for validation,
	// so you can put any allowed validation rules in.
	'validation' => array(

		// Maximum file size
		'max' => 10240, // 10 MB

		// Allowed mimetypes for files. These
		// can be found in config/mimes.php
		// of your Platform application.
		'mimes' => array(

			// Images
			'jpg', 'png', 'gif', 'bmp',

			// Files
			'pdf', 'zip',
		),
	),
);
