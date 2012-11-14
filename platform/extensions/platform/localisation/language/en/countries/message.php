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
 * @package    Platform
 * @version    1.1.1
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
        'success' => 'Country <strong>:country</strong> successfully created.',
        'fail'    => 'An error occurred while creating the country!'
    ),

    'update' => array(
        'success'         => 'Country <strong>:country</strong> successfully updated.',
        'fail'            => 'An error occurred while updating the country :country!',
        'disable_error'   => 'You cannot disable a default country!',
        'primary'         => 'Country <strong>:country</strong> is now the primary country.',
        'already_primary' => 'Country <strong>:country</strong> is already the primary country.'
    ),

    'delete' => array(
        'confirm'    => 'Are you sure you want to delete the country :country?',
        'success'    => 'Country <strong>:country</strong> successfully deleted.',
        'fail'       => 'An error occurred while deleting the country :country.',
        'being_used' => 'You cannot remove a primary country!'
    ),


    /*
     * -----------------------------------------
     * Other messages.
     * -----------------------------------------
     */
     'not_found' => 'The country <strong>#:country</strong> not found!'
);
