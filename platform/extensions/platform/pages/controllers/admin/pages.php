<?php

use Platform\Pages\Helper;

class Platform_Pages_Admin_Pages_Controller extends Admin_Controller
{
	public function before()
	{
		parent::before();
		$this->active_menu('admin-pages-pages');
	}

	public function get_index()
	{
		$options = Input::get();

		// Grab our datatable
		$datatable = API::get('pages/datatable', $options);

		$data = array(
			'columns' => $datatable['columns'],
			'rows'    => $datatable['rows'],
		);

		if (Request::ajax())
		{
			$data = array(
				'content'        => Theme::make('platform/pages::pages.partials.table', $data)->render(),
				'count'          => $datatable['count'],
				'count_filtered' => $datatable['count_filtered'],
				'paging'         => $datatable['paging'],
			);

			return json_encode($data);
		}

		return Theme::make('platform/pages::pages.index', $data);
	}

	public function get_create()
	{
		return Theme::make('platform/pages::pages.create');
	}

	public function post_create()
	{
		// Prepare data
		//
		$data = array(
			'name'       => Input::get('name'),
			'slug'       => Input::get('slug'),
			'type'       => Input::get('type'),
			'template'   => (Input::get('type') == 'db') ? Input::get('template') : Input::get('file'),
			'value'      => (Input::get('type') == 'db') ? Input::get('value') : '',
			'status'     => Input::get('status', 1),
			'visibility' => Input::get('visibility', 0),
			'groups'     => json_encode(Input::get('groups', array())),
		);

		try
		{
			// Create page
			//
			API::post('pages', $data);

			Platform::messages()->success(Lang::line('platform/pages::messages.pages.create.success')->get());

			return Redirect::to_admin('pages');
		}
		catch (APIClientException $e)
		{
            Platform::messages()->error($e->getMessage());

            // Set the other error messages.
            //
            foreach ($e->errors() as $error)
            {
                Platform::messages()->error($error);
            }

            return Redirect::to_admin('pages/create')->with_input();
		}
	}

	public function get_copy($id)
	{
		return Theme::make('platform/pages::pages.copy')->with('id', $id);
	}

	public function get_edit($id)
	{
		return Theme::make('platform/pages::pages.edit')->with('id', $id);
	}

	public function post_edit($id)
	{
		// Prepare data
		//
		$data = array(
			'name'       => Input::get('name'),
			'slug'       => Input::get('slug'),
			'value'      => Input::get('value'),
			'template'   => Input::get('file', Input::get('template')),
			'status'     => Input::get('status', 1),
			'visibility' => Input::get('visibility', 0),
			'groups'     => json_encode(Input::get('groups', array())),
		);

		try
		{
			// Edit page
			//
			API::put('pages/pages/'.$id, $data);

			Platform::messages()->success(Lang::line('platform/pages::messages.pages.edit.success')->get());

			return Redirect::to_admin('pages');
		}
		catch (APIClientException $e)
		{
            Platform::messages()->error($e->getMessage());

            // Set the other error messages.
            //
            foreach ($e->errors() as $error)
            {
                Platform::messages()->error($error);
            }

            return Redirect::to_admin('pages/edit/'.$id)->with_input();
		}


		return Theme::make('platform/pages::pages.edit')->with('id', $id);
	}

	public function get_delete($id)
	{
		try
		{
			API::delete('pages/'.$id);

			Platform::messages()->success(Lang::line('platform/pages::messages.pages.delete.success')->get());
		}
		catch (APIClientException $e)
		{
			Platform::messages()->error($e->getMessage());

			foreach ($e->errors() as $error)
			{
				Platform::messages()->error($error);
			}
		}

		return Redirect::to_admin('pages');
	}

	public function get_preview()
	{
		// change theme back to frontend
		Theme::active('frontend' . DS . Platform::get('platform/themes::theme.frontend'));

        // change fallback theme back to frontend.
        Theme::fallback('frontend' . DS . 'default');

		// render the page using the correct type

		// page is of file type
        if (Input::get('type') == 'file')
        {
        	return Theme::make('pages.'.Input::get('file'))
        		->with('name', Input::get('name'))
        		->with('slug', Input::get('slug'));
        }

		$content = Helper::renderContent(Input::get('value'));

		return Theme::make('templates.layouts.'.Input::get('template', 'default'))
			->with('name', Input::get('name'))
			->with('slug', Input::get('slug'))
			->with('content', $content);
	}
}
