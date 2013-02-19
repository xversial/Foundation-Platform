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
 * @version    1.1.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */


/*
 * --------------------------------------------------------------------------
 * Return the language lines.
 * --------------------------------------------------------------------------
 */
return array(
    /*
     * -----------------------------------------
     * Per action messages.
     * -----------------------------------------
     */
    'create' => array(
        'success' => 'Language <strong>:language</strong> successfully created.',
        'fail'    => 'An error occurred while creating the language!'
    ),

    'update' => array(
        'success'         => 'Language <strong>:language</strong> successfully updated.',
        'fail'            => 'An error occurred while updating the language :language!',
        'disable_error'   => 'You cannot disable a primary language!',
        'primary'         => 'Language <strong>:language</strong> is now the primary language.',
        'already_primary' => 'Language <strong>:language</strong> is already the primary language.'
    ),

    'delete' => array(
        'confirm'    => 'Are you sure you want to delete the language :language?',
        'success'    => 'Language <strong>:language</strong> successfully deleted.',
        'fail'       => 'An error occurred while deleting the language :language.',
        'being_used' => 'You cannot remove a primary language!'
    ),


    /*
     * -----------------------------------------
     * Error messages.
     * -----------------------------------------
     */
    'not_found' => 'The language <strong>#:language</strong> not found!'
);
