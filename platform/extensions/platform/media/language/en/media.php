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

	'title'   => 'Media Management',
	'tagline' => 'Manage files and images that are used throughout your application.',

	/* General */
	'general' => array(
		'created_at'     => 'Created At',
		'description'    => 'Description',
		'file_path'      => 'File Path',
		'file_name'      => 'File Name',
		'file_extension' => 'File Extension',
		'extension'      => 'Extension',
		'height'         => 'Height',
		'id'             => 'Id',
		'mime'           => 'MIME Type',
		'name'           => 'Name',
		'new_item'       => 'New Item',
		'no'             => 'No',
		'secure'         => 'Secure (HTTPS)',
		'size'           => 'Size',
		'slug'           => 'Slug',
		'status'         => 'Enabled',
		'thumbnail'      => 'Thumbnail',
		'uri'            => 'Uri',
		'updated_at'     => 'Created On',
		'width'          => 'Width',
		'yes'            => 'Yes',
	),

	/* General */
	'view' => array(
		'title' => 'Viewing Media',
	),

	/* Buttons */
	'button' => array(
		'upload' => 'Upload',
	),

	/* Choose Media */
	'choose' => array(
		'link_title' => 'Choose Media',
	),

	/* Upload Media */
	'upload' => array(
		'title'       => 'Upload Media',
		'description' => 'Upload media files.',
		'label'       => 'Choose Media',
		'done'        => 'Done',
		'native_link' => 'Having issues? Try the native uploader instead',
	),

	/* Persist Media */
	'persist' => array(
		'no_id'            => 'There was no media item Id provided to persisted.',
		'no_extension'     => 'An extension must own a media item to persist it. Please provide one.',
		'invalid_media_id' => 'Media Id :id doesn\'t exist and therefore can\'t be persisted.',
		'no_file'          => 'File does not exist and therefore cannot be persisted',
		'error'            => 'There was an issue persisted the media item. Please try again.',
		'success'          => 'The media item was persisted successfully.',
	),

	/* Delete User */
	'delete' => array(
		'confirm'          => 'Are you sure you want to delete this? This cannot be undone.',
		'no_id'            => 'There was no media item Id provided to delete.',
		'invalid_media_id' => 'Media Id :id doesn\'t exist and therefore can\'t be deleted.',
		'error'            => 'There was an issue deleting the media item. Please try again.',
		'success'          => 'The media item was deleted successfully.',
	),

	/* General Errors */
	'errors' => array(
		'count_error' => 'There was an issue retrieving the count, please try again.',
		'invalid_request' => 'Not a valid request.',
	)

);
