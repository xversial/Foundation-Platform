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

class Platform_Media_Admin_Media_Controller extends Admin_Controller
{

    public function before()
    {
        parent::before();
        $this->active_menu('admin-media');
    }

    public function get_index()
    {
        try
        {
            $datatable = API::get('media/datatable', Input::get());
        }
        catch (APIClientException $e)
        {
            // Set the error message.
            //
            Platform::messages()->error($e->getMessage());

            // Set all the other error messages.
            //
            foreach ($e->errors() as $error)
            {
                Platform::messages()->error($error);
            }

            // Redirect to the admin dashboard.
            //
            return Redirect::to_admin();
        }

        // Determine choose type
        if (($choose = Input::get('choose', false)) !== false)
        {
            // Not equal to one, use a checkbox. Otherwise, 1 option
            // gives a radio
            $choose = ((int) $choose !== 1) ? 'checkbox' : 'radio';
        }

        $data = array_merge($this->upload_config(), array(
            'columns'    => $datatable['columns'],
            'rows'       => $datatable['rows'],
            'choose'     => $choose,

            // The upload form is shared with the media chooser
            // widget. This means each widget has a unique identifier.
            // We will just give a dummy identifier.
            'identifier' => 'static',
        ));

        // If this was an ajax request, only return the body of the datatable
        if (Request::ajax())
        {
            return json_encode(array(
                'content'        => Theme::make('platform/media::partials.table_media', $data)->render(),
                'count'          => $datatable['count'],
                'count_filtered' => $datatable['count_filtered'],
                'paging'         => $datatable['paging'],
            ));
        }

        return Theme::make('platform/media::index', $data);
    }

    public function get_view($id)
    {
        $media = API::get('media/'.$id)[0];

        return Theme::make('platform/media::view')
                    ->with('media', $media);
    }

    public function get_upload()
    {
        $data = array_merge($this->upload_config(), array(

        ));

        return Theme::make('platform/media::upload', $data);
    }

    /**
     * Handles the actual AJAX upload process
     * for a file.
     *
     * @return  string
     */
    public function post_upload()
    {
        $files   = (array) Input::file('files');
        $content = array_get($files, 'tmp_name.0');

        if ( ! File::exists($content))
        {
            // This should never occur, being a PHP
            // upload dir. Something is seriously
            // wrong with the server in this case.
        }

        try
        {
            // Post to the API
            $media = API::post('media', array(
                'vendor'    => Input::get('vendor'),
                'extension' => Input::get('extension'),
                'content'   => base64_encode(File::get($content)),
                'encoding'  => 'base64',
                'name'      => array_get($files, 'name.0', null),
            ));
        }
        catch ( APIClientException $e )
        {
            if (Request::ajax())
            {
                Log::error(print_r($e,1));
                return new Response(json_encode(array(
                    'message' => $e->getMessage(),
                )), $e->getCode());
            }

            // Set the error message.
            //
            Platform::messages()->error( $e->getMessage() );

            // Set the other error messages.
            //
            foreach ( $e->errors() as $error )
            {
                Platform::messages()->error( $error );
            }

            return Redirect::to_admin('media');
        }

        if (Request::ajax())
        {
            // If we're doing an AJAX upload, we need to
            // attach the URL to quickly delete a media item
            // (using the AJAX uploader rather than visiting
            // the library). To do this, we need to give a
            // little more information to the uploader.
            $media['delete_type'] = 'GET';
            $media['delete_url']  = URL::to_admin('media/delete/'.$media['id']);

            return new Response(json_encode(array($media)));
        }

        return Redirect::to_admin('media');
    }

    public function get_chooser()
    {
        return Theme::make('platform/media::chooser');
    }

    public function get_delete($id)
    {
        try
        {
            // Delete the media.
            //
            API::delete('media/' . $id);

            if (Request::ajax())
            {
                // No content, but successful
                return new Response(null, API::STATUS_NO_CONTENT);
            }

            // Set the success message.
            //
            Platform::messages()->success( Lang::line('platform/media::media.delete.success')->get() );
        }
        catch ( APIClientException $e )
        {
            if (Request::ajax())
            {
                return new Response(json_encode(array(
                    'message' => $e->getMessage(),
                )), $e->getCode());
            }

            // Set the error message.
            //
            Platform::messages()->error( $e->getMessage() );

            // Set the other error messages.
            //
            foreach ( $e->errors() as $error )
            {
                Platform::messages()->error( $error );
            }
        }

        return Redirect::to_admin('media');
    }


    protected function upload_config()
    {
        $allowed_extensions = Config::get('platform/media::media.validation.mimes');
        $allowed_mimes      = array();

        foreach ($allowed_extensions as $allowed_extension)
        {
            if ($mimes = Config::get('mimes.'.$allowed_extension))
            {
                if (is_array($mimes))
                {
                    foreach ($mimes as $mime)
                    {
                        $allowed_mimes[] = $mime;
                    }
                }
                else
                {
                    $allowed_mimes[] = $mimes;
                }
            }
        }

        return array(
            'max_file_size' => Config::get('platform/media::media.validation.max'),
            'mimes'         => $allowed_mimes,
            'vendor'        => 'platform',
            'extension'     => 'media',
        );
    }

}
