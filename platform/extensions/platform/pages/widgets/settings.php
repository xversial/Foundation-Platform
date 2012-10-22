<?php

namespace Platform\Pages\Widgets;

use API;
use Platform;
use Platform\Pages\Helper;
use Theme\Theme;

class Settings
{
	/**
     * The validation rules.
     *
     * @access   public
     * @var      array
     */
    public static $validation = array(
        'page'     => 'required',
        'template' => 'required',
    );

    public function index()
    {
    	// default page & template
    	//
    	$page = Platform::get('pages.default.page');
    	$template = Platform::get('pages.default.template');

    	// page list
    	//
    	try
    	{
    		$pages_response = API::get('pages');

    		$pages = array();
    		foreach ($pages_response as $_page)
    		{
    			$pages[$_page['id']] = $_page['name'] . ' ( ' . $_page['slug'] . ' ) ';
    		}

    		$templates = Helper::findTemplates();
    	}
    	catch (\ClientAPIException $e)
    	{
    		$pages = array();
    	}

    	return Theme::make('pages::widgets.settings.form.settings')
    		->with('page', $page)
    		->with('pages', $pages)
    		->with('template', $template)
    		->with('templates', $templates);
    }
}