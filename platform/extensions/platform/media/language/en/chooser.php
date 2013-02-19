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

	'title' => 'Choose Media',

	/* Linkn */
	'link' => array(
		'title' => 'Choose Media',
	),

	/* Tabs */
	'tabs' => array(
		'upload'   => 'Upload New',
		'library'  => 'From Library',
		'external' => 'From the Internet',
	),

	/* Buttons */
	'button' => array(
		'choose' => 'Choose',
	),

	/* Upload */
	'upload' => array(
		'errors' => array(
			'max_file_size'       => 'File size is too big',
			'min_file_size'       => 'File size is too small',
			'accepted_file_types' => 'Filetype not allowed',
			'max_number_of_files' => 'Max number of files exceeded',
			'uploaded_bytes'      => 'Uploaded bytes exceed file size',
			'empty_result'        => 'Empty file upload result',
		),

		// Actions
		'error'   => 'Error',
		'add'     => 'Add',
		'start'   => 'Start',
		'cancel'  => 'Cancel',
		'destroy' => 'Delete',
	),

	/**
	 * Errors
	 */
	'errors' => array(

		// Errors for when there are no files chosen.
		// Single / multiple limits
		'no_files' => array(
			'single'   => 'Please choose :limit file',
			'limit'    => 'Please choose up to :limit files',
			'no_limit' => 'Please choose files',
		),

		'max_number_of_files' => 'You have chosen too many files',
	),
);
