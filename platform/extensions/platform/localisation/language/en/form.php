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
     * Settings form.
     * -----------------------------------------
     */
    'settings' => array(
        'legend' => 'Localisation',

        'fields' => array(
            'country'          => 'Default Country',
            'currency'         => 'Default Currency',
            'currency_auto'    => 'Auto Update Currency',
            'currency_api_key' => 'Open Exchange Rates API Key',
            'language'         => 'Default Language',
            'timezone'         => 'Default Timezone',
            'date_format'      => 'Date Format',
            'time_format'      => 'Time Format'
        )
    ),

    'general' => array(
        'everyday'   => 'Everyday',
        'once_week'  => 'Once a Week',
        'once_month' => 'Once a Month'
    )
);
