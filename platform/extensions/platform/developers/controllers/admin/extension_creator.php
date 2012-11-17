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


/**
 * --------------------------------------------------------------------------
 * Developers > Admin > Extension Creator Class
 * --------------------------------------------------------------------------
 *
 * Extension creator.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Platform_Developers_Admin_Extension_Creator_Controller extends Admin_Controller
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
        $this->active_menu('admin-developers-creator');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_index()
     * --------------------------------------------------------------------------
     *
     * Show the extension creator main page.
     *
     * @access   public
     * @return   View
     */
    public function get_index()
    {
        // Initiate an array with data to send to the page.
        //
        $data = array(
            // Reserved vendors.
            //
            'reserved_vendors' => array(ExtensionsManager::CORE_VENDOR),

            // Default vendor.
            //
            'default_vendor' => ExtensionsManager::DEFAULT_VENDOR,

            // Installed extensions.
            //
            'extensions' => API::get('extensions')
        );

        // Show the page.
        //
        return Theme::make('platform/developers::creator', $data);
    }


    /**
     * --------------------------------------------------------------------------
     * Function:  post_index()
     * --------------------------------------------------------------------------
     *
     * Form processing method.
     *
     * @access   public
     * @return   View
     */
    public function post_index()
    {
        // Make the API request.
        //
        $request = API::post('developers/extension_creator', array(
            // Send properties of the extension.
            //
            'name'         => Input::get('name'),
            'author'       => Input::get('author'),
            'description'  => Input::get('description'),
            'version'      => Input::get('version'),
            'vendor'       => Input::get('vendor'),
            'extension'    => Input::get('extension'),
            'dependencies' => Input::get('dependencies', array()),
            'overrides'    => Input::get('overrides', array()),

            // Tell the API how we want our extension
            // returned to us. We can either base64 encode
            // or utf-8 encode the ZIP contents.
            'encoding'  => 'base64',
        ));

        // Check if we have valid contents.
        //
        if (($contents = base64_decode($request)) === false)
        {
            Platform::message()->error(Lang::line('platform/developers::messages.creator.decode_fail'));

            return Redirect::to_admin('developers/create');
        }

/*
        // The name the ZIP should get
        $name = sprintf('%s-%s.zip', Input::get('vendor', 'vendor'), Input::get('extension', 'extension'));

        // Let's build some headers up to allow us to stream the file
        $headers = array(
            'Content-Description'       => 'File Transfer',
            'Content-Type'              => File::mime('zip'),
            'Content-Transfer-Encoding' => 'binary',
            'Expires'                   => 0,
            'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma'                    => 'public',
            'Content-Length'            => Str::length($contents),
        );

        // Once we create the response, we need to set the content disposition
        // header on the response based on the file's name. We'll pass this
        // off to the HttpFoundation and let it create the header text.
        $response = new Response($contents, 200, $headers);

        $d = $response->disposition($name);

        return $response->header('Content-Disposition', $d);
*/
    }
}
