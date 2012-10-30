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


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use Platform\Menus\Menu;


/**
 * --------------------------------------------------------------------------
 * Dashboard > Admin Class
 * --------------------------------------------------------------------------
 *
 * The admin main page.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Platform_Dashboard_Admin_Dashboard_Controller extends Admin_Controller
{
    /**
     * --------------------------------------------------------------------------
     * Function: before()
     * --------------------------------------------------------------------------
     *
     * This function is called before the action is executed.
     *
     * @access   public
     * @return   void
     */
    public function before()
    {
        // Call parent.
        //
        parent::before();

        // Set the active menu.
        //
        $this->active_menu('admin-dashboard');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_index()
     * --------------------------------------------------------------------------
     *
     * Shows the admin main page.
     *
     * @access   public
     * @return   View
     */
    public function get_index()
    {
        $testing = false;

        if($testing)
        {
            //
            //
            $manager = Platform::extensions_manager();


            /**
            // Methods test !
            //
            $slug = 'cartalyst.pages';
            if ($manager->is_installed($slug))
            {
                echo 'Uninstalled';
                $manager->uninstall($slug);
            }
            else
            {
                echo 'Installed';
                $manager->install($slug);
            }
            die;
            **/


            ################################################################
            #echo '<pre>'; var_dump( $manager->extensions() ); echo '</pre>'; die;
            ################################################################


            echo '<pre>';

            /*
            echo '<h1>Static Array</h1>';
            $extensions = array(
                'default/test',
                'default.test',
                'cartalyst.pages',
                'platform.localisation',
                'platform.pages',
                'platform.settings'
            );

            foreach ($extensions as $slug)
            {
                echo '<br /><strong><u>' . $slug . '</u></strong><br /><br />';
                if ($manager->exists($slug))
                {
                    echo '   Is core ? ' . ( $manager->is_core($slug) ? 'Yes' : 'No' ) . '<br />';
                    echo '   Is core vendor ? ' . ( $manager->is_core_vendor($slug) ? 'Yes' : 'No' ) . '<br />';
                    echo '   Is enabled ? ' . ( $manager->is_enabled($slug) ? 'Yes' : 'No' ) . '<br />';
                    echo '   Is installed ? ' . ( $manager->is_installed($slug) ? 'Yes' : 'No' ) . '<br />';
                    echo '   Can be installed ? ' . ( $manager->can_install($slug) ? 'Yes' : 'No' ) . '<br />';
                    echo '   Can be uninstalled ? ' . ( $manager->can_uninstall($slug) ? 'Yes' : 'No' ) . '<br />';
                    echo '   Can be enabled ? ' . ( $manager->can_enable($slug) ? 'Yes' : 'No' ) . '<br />';
                    echo '   Can be disabled ? ' . ( $manager->can_disable($slug) ? 'Yes' : 'No' ) . '<br />';
                }
                else
                {
                    echo '   This extension doesn\'t exist !<br />';
                }

                echo '<br />============================<br />';
            }

            die;*/



            echo '<h1>Extensions</h1>';
            $extensions = Platform::extensions_manager()->extensions();
            foreach($extensions as $slug => $vendors)
            {
                echo $slug . '<i>( extension )</i>';

                // Check if we have more than one vendor for this extension.
                //
                if ( $vendors = $manager->vendors($slug) )
                {
                    echo '<br />  How many vendors? ' . count($vendors);
                }
                else
                {
                     echo '<br />  Single vendor !';
                }
                echo '<br />  ======================================================';

                foreach ($vendors as $vendor => $extension)
                {
                    $full_slug = $extension['info']['slug'];


                    echo '<pre>';
                    echo '  ' . $vendor . '<i>( vendor )</i> | Slug: ' . $full_slug;
                        echo '<pre>';
                            /**/

                            echo '    Dependencies: ' . implode(', ', $manager->dependencies($full_slug) );
                            echo '<br />    Dependents: ' . implode(', ', $manager->dependents($full_slug) );

                            echo '<br />    Is Core        ? ' . ( $manager->is_core($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    Is Vendor Core ? ' . ( $manager->is_core_vendor($full_slug) ? 'Yes' : 'No' );

                            // Is the extension installed ?
                            //
                            if ($manager->is_installed($full_slug))
                            {
                                // Can uninstall the extension ?
                                //
                                echo '<br />    Can Uninstall  ? ' . ( $manager->can_uninstall($full_slug) ? 'Yes' : 'No' );

                                // Is the extension enabled ?
                                //
                                if ($manager->is_enabled($full_slug))
                                {
                                    // Can disable the extension ?
                                    //
                                    echo '<br />    Can Disable    ? ' . ( $manager->can_disable($full_slug) ? 'Yes' : 'No' );

                                }

                                // Extension is disabled.
                                //
                                else
                                {
                                    echo '<br />    Can Enable     ? ' . ( $manager->can_enable($full_slug) ? 'Yes' : 'No' );

                                }

                                // Has any update available ?
                                //
                                echo '<br />    Has Update     ? ' . ( $manager->has_update($full_slug) ? 'Yes' : 'No' );
                                if($manager->has_update($full_slug))
                                {
                                    echo '<br />        Current Version : ' . $manager->current_version($full_slug);
                                    echo '<br />        New Version     : ' . $manager->new_version($full_slug);
                                }
                            }

                            // Extension is not installed.
                            //
                            else
                            {
                                // Can install the extension ?
                                //
                                echo '<br />    Can Install    ? ' . ( $manager->can_install($full_slug) ? 'Yes' : 'No' );
                                if( ! $manager->can_install($full_slug))
                                {
                                    echo '<br />        Missing Extensions: ' . implode(', ', $manager->required_extensions($full_slug));
                                }
                            }
                            /**/


                            /*
                            echo '    Dependencies: ' . implode(', ', $manager->dependencies($full_slug) );
                            echo '<br />    Dependents: ' . implode(', ', $manager->dependents($full_slug) );
                            echo '<br />    Is Core ? ' . ( $manager->is_core($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    Is Installed ? ' . ( $manager->is_installed($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    Is Uninstalled ? ' . ( $manager->is_uninstalled($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    Can Install ? ' . ( $manager->can_install($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    Can Uninstall ? ' . ( $manager->can_uninstall($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    ---------------------';
                            echo '<br />    Is Enabled ? ' . ( $manager->is_enabled($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    Is Disabled ? ' . ( $manager->is_disabled($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    Can Enable ? ' . ( $manager->can_enable($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    Can Disable ? ' . ( $manager->can_disable($full_slug) ? 'Yes' : 'No' );
                            echo '<br />    ---------------------';
                            echo '<br />    Has Update ? ' . ( $manager->has_update($full_slug) ? 'Yes' : 'No' );
                            if($manager->has_update($full_slug))
                            {
                                echo '<br />    Version : ' . $manager->new_version($full_slug);
                            }
                            */

                        echo '</pre>';
                    echo '</pre>';
                }
                echo '------------------------------------------------------------';
                echo '<br />';
            }
            echo '</pre>';




            die;
        }
        // Show the page.
        //
        return Theme::make('platform.dashboard::index');
    }
}
