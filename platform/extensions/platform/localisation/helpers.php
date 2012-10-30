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
 * @version    1.1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */


/**
 * --------------------------------------------------------------------------
 * Function: general_statuses()
 * --------------------------------------------------------------------------
 *
 * Returns an array of the general statuses.
 *
 * @access   public
 * @return   array
 */
function general_statuses()
{
    return array(
        1 => Lang::line('general.enabled')->get(),
        0 => Lang::line('general.disabled')->get()
    );
}


/**
 * --------------------------------------------------------------------------
 * Function: countries()
 * --------------------------------------------------------------------------
 *
 * Returns an array of countries, that we can use on form select menus.
 *
 * @access   public
 * @return   array
 */
function countries()
{
    // Initiate an empty array.
    //
    $countries = array();

    // Grab the countries from the database.
    //
    foreach (Platform\Localisation\Model\Country::all() as $country)
    {
        $countries[ strtolower($country['iso_code_2']) ] = $country['name'];
    }

    // Return the countries.
    //
    return $countries;
}


/**
 * --------------------------------------------------------------------------
 * Function: languages()
 * --------------------------------------------------------------------------
 *
 * Returns an array of languages, that we can use on form select menus.
 *
 * @access   public
 * @return   array
 */
function languages()
{
    // Initiate an empty array.
    //
    $languages = array();

    // Grab the languages from the database.
    //
    foreach (Platform\Localisation\Model\Language::all() as $language)
    {
        $languages[ $language['abbreviation'] ] = $language['name'];
    }

    // Return the languages.
    //
    return $languages;
}


/**
 * --------------------------------------------------------------------------
 * Function: currencies()
 * --------------------------------------------------------------------------
 *
 * Returns an array of currencies, that we can use on form select menus.
 *
 * @access   public
 * @return   array
 */
function currencies()
{
    // Initiate an empty array.
    //
    $currencies = array();

    // Grab the currencies from the database.
    //
    foreach (Platform\Localisation\Model\Currency::all() as $currency)
    {
        $currencies[ $currency['code'] ] = $currency['name'];
    }

    // Return the currencies.
    //
    return $currencies;
}


/**
 * --------------------------------------------------------------------------
 * Function: timezones()
 * --------------------------------------------------------------------------
 *
 * Returns an array of timezones, that we can use on form select menus.
 *
 * @access   public
 * @return   array
 */
function timezones()
{
    // Initiate an empty array.
    //
    $timezones = array();

    // Grab the timezones.
    //
    foreach (Platform\Localisation\Model\Timezone::all() as $item => $value)
    {
        $timezones[ $item ] = $value;
    }

    // Return the timezones.
    //
    return $timezones;
}


/**
 * --------------------------------------------------------------------------
 * Function: currencies_update_intervals()
 * --------------------------------------------------------------------------
 *
 * Returns an array of currencies update intervals we can choose from.
 *
 * @access   public
 * @return   array
 */
function currencies_update_intervals()
{
    return array(
        0       => Lang::line('general.disabled')->get(),
        86400   => Lang::line('platform/localisation::form.general.everyday')->get(),
        604800  => Lang::line('platform/localisation::form.general.once_week')->get(),
        2592000 => Lang::line('platform/localisation::form.general.once_month')->get()
    );
}


/**
 * --------------------------------------------------------------------------
 * Function: time_formats()
 * --------------------------------------------------------------------------
 *
 * Returns an array of time formats we can choose from.
 *
 * @access   public
 * @return   array
 */
function time_formats()
{
    return array(
        '%H:%M:%S %p' => strftime('%H:%M:%S %p', time()), # 17:16:32 PM
        '%H:%M:%S'    => strftime('%H:%M:%S', time()),    # 17:16:32
        '%H:%M'       => strftime('%H:%M', time())        # 17:16
    );
}


/**
 * --------------------------------------------------------------------------
 * Function: date_formats()
 * --------------------------------------------------------------------------
 *
 * Returns an array of date formats we can choose from.
 *
 * @access   public
 * @return   array
 */
function date_formats()
{
    return array(
        '%d-%m-%Y' => strftime('%d-%m-%Y', time()), # 20-10-2012
        '%d-%b-%Y' => strftime('%d-%b-%Y', time()), # 20-Oct-2012
        '%Y-%m-%d' => strftime('%Y-%m-%d', time()), # 2012-10-20
        '%Y-%b-%d' => strftime('%Y-%b-%d', time()), # 2012-Oct-20

        '%d.%m.%Y' => strftime('%d.%m.%Y', time()), # 20.10.2012
        '%d.%b.%Y' => strftime('%d.%b.%Y', time()), # 20.Oct.2012
        '%Y.%m.%d' => strftime('%Y.%m.%d', time()), # 2012.10.20
        '%Y.%b.%d' => strftime('%Y.%b.%d', time()), # 2012.Oct.20

        '%d/%m/%Y' => strftime('%d/%m/%Y', time()), # 20/10/2012
        '%d/%b/%Y' => strftime('%d/%b/%Y', time()), # 20/Oct/2012
        '%Y/%m/%d' => strftime('%Y/%m/%d', time()), # 2012/10/20
        '%Y/%b/%d' => strftime('%Y/%b/%d', time()), # 2012/Oct/20

        '%A, %d %B %Y' => strftime('%A, %d %B %Y', time()), # Saturday, 20 October 2012
        '%d %B %Y'     => strftime('%d %B %Y', time())      # 20 October 2012
    );
}
