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

namespace Platform\Media;

use Crud;
use Config;
use File;
use Filesystem;
use FilesystemIterator as fIterator;
use stdClass;
use URL;

class Media extends Crud
{

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected static $_table = 'media';

    /**
     * Indicates if the model has update and creation timestamps.
     *
     * @var bool
     */
    protected static $_timestamps = true;

    /**
     * Validation rules for model attributes.
     *
     * @access    protected
     * @var       array
     */
    protected static $_rules = array(
        'extension'      => 'required',
        'extension'      => 'required',
        'name'           => 'required',
        'file_path'      => 'required',
        'file_name'      => 'required',
        'file_extension' => 'required',
        'mime'           => 'required',
        'size'           => 'required|numeric',
        'width'          => 'numeric',
        'height'         => 'numeric',
    );

    /**
     * Delete a model from the datatabase
     * and it's associated file in the filesystem
     *
     * @return  int
     */
    public function delete($events = array('before', 'after'))
    {
        $filesystem = Filesystem::make('native');
        $filesystem->file()->delete($this->full_path);

        return parent::delete();
    }

    /**
     * Gets called before insert() is executed to modify the query
     * Must return an array of the query object and columns array($query, $columns)
     *
     * @param   Query  $query
     * @param   array  $columns
     * @return  array
     */
    protected function before_insert($query, $columns)
    {
        // Remove all the properties that we added
        // after initialising the object.
        //
        array_forget($columns, 'full_path');
        array_forget($columns, 'url');
        array_forget($columns, 'thumbnail_url');
        array_forget($columns, 'size_human');
        array_forget($columns, 'relative_url');

        return array($query, $columns);
    }

    /**
     * Gets call after the find() query is exectuted to modify the result
     * Must return a proper result
     *
     * @param   Query  $query
     * @param   array  $columns
     * @return  array
     */
    protected function after_find($result)
    {
        if ($result)
        {
            static::add_to_result($result);
        }

        return $result;
    }

    /**
     * Returns the base media directory.
     *
     * @return  string
     */
    public static function directory()
    {
        return path('public').Config::get('platform/media::media.directory', 'platform'.DS.'media');
    }

    /**
     * Gets called after the all() query is exectuted to modify the result
     * Must return a proper result
     *
     * @param   array  $results
     * @return  array  $results
     */
    protected static function after_all($results)
    {
        // Loop through and add to result
        foreach ($results as $result)
        {
            static::add_to_result($result);
        }

        return $results;
    }

    /**
     * Adds some useful properties after a model
     * is found in the database. These are properties
     * that are dynamically generated.
     *
     * @param   stdClass  $result
     * @return  stdClass  $result
     */
    protected static function add_to_result(stdClass $result)
    {
        $result->full_path = str_finish(static::directory(), DS).$result->file_path.DS.$result->file_name.(($result->file_extension) ? '.'.$result->file_extension : null);

        $url_replacements = array(

            // Dumb windows needs replacements
            '\\' => '/',
        );

        $dir = str_finish(Config::get('platform/media::media.directory', 'platform'.DS.'media'), DS).$result->file_path.DS.$result->file_name.(($result->file_extension) ? '.'.$result->file_extension : null);

        $url = str_replace(array_keys($url_replacements), array_values($url_replacements), $dir);

       	$result->relative_url  = '/'.$url;
        $result->url = URL::to_asset($url);
        $result->thumbnail_url = $result->url;

        unset($url);

        $result->size_human = static::format_bytes($result->size);

        return $result;
    }

    /**
     * Formats single bytes into human readable formats.
     *
     * @param   int    $bytes
     * @param   array  $sizes
     * @param   int    $precision
     * @return  string
     */
    protected static function format_bytes($bytes, $sizes = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'), $precision = 2)
    {
        if ( ! $bytes)
        {
            return false;
        }

        return (round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision) . ' ' . $sizes[$i]);
    }

    /**
     * --------------------------------------------------------------------------
     * Function: find()
     * --------------------------------------------------------------------------
     *
     * A custom method to find media files, we can use the media id or the media
     * file name.
     *
     * @access   public
     * @param    mixed
     * @param    array
     * @param    array
     * @return   object
     */
    public static function find($condition = 'first', $columns = array('*'), $events = array('before', 'after'))
    {
        // Do we have the media id?
        //
        if (is_numeric($condition) and ! in_array($condition, array('first', 'last')))
        {
            // Execute the query.
            //
            return parent::find(function($query) use ($condition)
            {
                return $query->where('id', '=', $condition);
            }, $columns, $events);
        }

        // Do we have the media file name?
        //
        elseif (strpos($condition, '.'))
        {
            // Execute the query.
            //
            return parent::find(function($query) use ($condition)
            {
                return $query->where('name', '=', strtoupper($condition));
            }, $columns, $events);
        }

        // Call parent.
        //
        return parent::find($condition, $columns, $events);
    }
}
