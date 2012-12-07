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
        'success' => 'Currency <strong>:currency</strong> successfully created.',
        'fail'    => 'An error occurred while creating the currency!'
    ),

    'update' => array(
        'success'         => 'Currency <strong>:currency</strong> successfully updated.',
        'fail'            => 'An error occurred while updating the currency :currency!',
        'disable_error'   => 'You cannot disable a primary currency!',
        'primary'         => 'Currency <strong>:currency</strong> is now the primary currency.',
        'already_primary' => 'Currency <strong>:currency</strong> is already the primary currency.'
    ),

    'delete' => array(
        'confirm'    => 'Are you sure you want to delete the currency :currency?',
        'success'    => 'Currency <strong>:currency</strong> successfully deleted.',
        'fail'       => 'An error occurred while deleting the currency :currency.',
        'being_used' => 'You cannot remove a primary currency!'
    ),


    /*
     * -----------------------------------------
     * Other messages.
     * -----------------------------------------
     */
    'not_found' => 'The currency <strong>#:currency</strong> not found!'
);
