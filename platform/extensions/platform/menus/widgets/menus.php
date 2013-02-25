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

namespace Platform\Menus\Widgets;


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use API;
use APIClientException;
use Laravel\Input;
use Laravel\URI;
use Laravel\URL;
use Platform;
use Platform\Menus\Menu;
use Sentry;
use Theme;


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
     * @param    mixed
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
                $flat_array = API::get('menus/flat', array('enabled' => true));

                $items = API::get('menus/' . $start . '/children', array(
                    'enabled'           => true,
                    'limit'             => $children_depth ?: false,
                    'filter_visibility' => 'automatic'
                ));
            }
            catch (APIClientException $e)
            {
                return '';
            }
        }

        // Get the default page id.
        //
        $default_page_id = Platform::get('platform/pages::default.page');

        // Loop trough the pages.
        //
        foreach ($this->pages() as $page)
        {
            // Is this a page ?
            //
            if (URI::segment(1) == $page['slug'])
            {
                foreach ($flat_array as $item)
                {
                    if ($item['page_id'] == $page['id'])
                    {
                        API::post('menus/active', array('slug' => $item['slug']));
                    }
                }
            }

            //
            //
            elseif (URI::segment(1) == '')
            {
                foreach ($flat_array as $item)
                {
                    if ($item['page_id'] == $default_page_id)
                    {
                        API::post('menus/active', array('slug' => $item['slug']));
                    }
                }
            }
        }

        try
        {
            $active_path = API::get('menus/active_path');
        }
        catch (APIClientException $e)
        {
            $active_path = array();
        }

        // Let's get menus according to the start depth and what is the active menu.
        //
        if (is_numeric($start))
        {
            // Check the start depth exists.
            //
            if ( ! isset($active_path[(int) $start]))
            {
                return '';
            }

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

        // Now loop through items and take actions based on the item type.
        //
        foreach ($items as &$item)
        {
            // Switch through the item types.
            //
            switch ($item['type'])
            {
                // Static entry.
                //
                case Menu::TYPE_STATIC:
                    if ( ! URL::valid($item['uri']))
                    {
                       $item['uri'] = URL::to(($before_uri ? $before_uri . '/' : null) . $item['uri'], $item['secure']);
                    }
                break;

                // Page entry.
                //
                case Menu::TYPE_PAGE:
                    // Get the Page ID.
                    //
                    $page_id = $item['page_id'];

                    // Grab pages.
                    //
                    $pages = array_filter($this->pages(), function($page) use ($page_id)
                    {
                        return $page['id'] == $page_id;
                    });

                    // Grab the first match for the page.
                    //
                    if (is_array($page = reset($pages)) and array_key_exists('id', $page))
                    {
                        $item['uri'] = URL::to(($page['id'] != $default_page_id ? $page['slug'] : ''));
                    }

                    $this->fix_children_uri($item);
                break;
            }

            // The menu link target.
            //
            $item['target'] = ($item['target'] == 0 ? '_self' : '_blank');
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


    protected function fix_children_uri(&$item)
    {
        if ($item['children'])
        {
            foreach ($item['children'] as &$child)
            {
                foreach ($this->pages as $page)
                {
                    if ($page['id'] == $child['page_id'])
                    {
                        $child['uri'] = $page['slug'];
                    }
                }

                if ($child['children'])
                {
                    return $this->fix_children_uri($child);
                }
            }
        }
    }

    /**
     * --------------------------------------------------------------------------
     * Function: pages()
     * --------------------------------------------------------------------------
     *
     * Returns all the pages.
     *
     * @access   protected
     * @return   array
     */
    protected function pages()
    {
        // Do we have the pages loaded?
        //
        if (is_null($this->pages))
        {
            try
            {
                // Get the pages and store them.
                //
                $this->pages = API::get('pages');
            }
            catch (APIClientException $e)
            {
                // Fallback pages array.
                //
                $this->pages = array();
            }
        }

        // Return the pages.
        //
        return $this->pages;
    }
}
