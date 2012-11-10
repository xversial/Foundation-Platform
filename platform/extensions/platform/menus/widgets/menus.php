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
 * @version    1.0.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Platform\Menus\Widgets;


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use API,
    APIClientException,
    Input,
    Platform,
    Platform\Menus\Menu,
    Sentry,
    Theme;


/**
 * --------------------------------------------------------------------------
 * Menus widget
 * --------------------------------------------------------------------------
 *
 * This widget purpose is to show navigation menus on the UI.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.0
 */
class Menus
{
    /**
     * Cached pages array used on menu item output.
     *
     * @var array
     */
    public $pages = null;

    /**
     * --------------------------------------------------------------------------
     * Function: nav()
     * --------------------------------------------------------------------------
     *
     * Returns a navigation menu, based off the active menu.
     *
     * If the start is an integer, it's the depth from the top level item based
     * on the current active item.
     *
     * If it's a string, it's the slug of the item to start rendering from,
     * irrespective of active item.
     *
     * @access   public
     * @param    integer
     * @param    integer
     * @param    string
     * @param    string
     * @return   object
     */
    public function nav($start = 0, $children_depth = 0, $class = null, $before_uri = null)
    {
        // Do we have a menu slug ?
        //
        if ( ! is_numeric($start))
        {
            // Make sure we have a slug
            //
            if ( ! strlen($start))
            {
                return '';
            }

            try
            {
                $items = API::get('menus/' . $start . '/children', array(

                    // Only enabled
                    'enabled' => true,

                    // Pass through the children depth
                    'limit' => $children_depth ?: false,

                    // We want to automatically filter
                    // what items show (according to Session)
                    // data
                    'filter_visibility' => 'automatic'
                ));
            }
            catch (APIClientException $e)
            {
                return '';
            }
        }

        try
        {
            $active_path = API::get('menus/active_path');
        }
        catch (APIClientException $e)
        {
            // Empty active path
            $active_path = array();
        }

        // Le'ts get menus according to the
        // start depth and what is the active menu.
        if (is_numeric($start))
        {
            // Check the start depth exists
            if ( ! isset($active_path[(int) $start]))
            {
                return '';
            }

            // Items
            try
            {
                $items = API::get('menus/' . $active_path[(int) $start] . '/children', array(
                    'enabled' => true,
                    'limit'   => $children_depth ?: false
                ));
            }
            catch (APIClientException $e)
            {
                return '';
            }
        }

        // Grab the pages.
        //
        $pages = $this->pages();

        // Now loop through items and take actions based
        // on the item type.
        foreach ($items as &$item)
        {
            switch ($item['type'])
            {
                case Menu::TYPE_PAGE:

                    // Fallback page URI
                    $item['page_uri'] = '';
                    
                    // Grab the first match for the page
                    if (is_array($page = reset($pages)) and array_key_exists('id', $page))
                    {
                        $item['page_uri'] = ($page['id'] != Platform::get('platform/pages::default.page')) ? $page['slug'] : '';
                    }

                    break;
            }
        }

        // Return the widget view.
        //
        return Theme::make('platform/menus::widgets.nav')
                    ->with('items', $items)
                    ->with('active_path', $active_path)
                    ->with('class', $class)
                    ->with('before_uri', $before_uri)
                    ->with('start', $start)
                    ->with('child_depth', $children_depth);
    }

    public function pages()
    {
        if ($this->pages === null)
        {
            try
            {
                $this->pages = API::get('pages');
            }
            catch (APIClientException $e)
            {
                $this->pages = array();
            }
        }

        return $this->pages;
    }
}
