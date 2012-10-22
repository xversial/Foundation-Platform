<?php

use Platform\Pages\Helper;

class Pages_Admin_Pages_Controller extends Admin_Controller
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
				'content'        => Theme::make('pages::pages.partials.table', $data)->render(),
				'count'          => $datatable['count'],
				'count_filtered' => $datatable['count_filtered'],
				'paging'         => $datatable['paging'],
			);

			return json_encode($data);
		}

		return Theme::make('pages::pages.index', $data);
	}

	public function get_create()
	{
		return Theme::make('pages::pages.create');
	}

	public function post_create()
	{
		// Prepare the data
		//
		$data = array(
			'name'     => Input::get('name'),
			'slug'     => Input::get('slug'),
			'content'  => Input::get('content'),
			'template' => Input::get('template', 'default'),
			'status'   => Input::get('status', 1),
		);

		try
		{
			// Create the pages
			API::post('pages', $data);

			// Set success message
			//
			Platform::messages()->success('Page Created Successfully');

			return Redirect::to_admin('pages');
		}
		catch (APIClientException $e)
		{
			// Set the error message.
            //
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

	public function get_edit($id)
	{
		return Theme::make('pages::pages.edit')->with('id', $id);
	}

	public function post_edit($id)
	{
		$data = array(
			'name'     => Input::get('name'),
			'slug'     => Input::get('slug'),
			'content'  => Input::get('content'),
			'template' => Input::get('template', 'default'),
			'status'   => Input::get('status', 1),
		);

		try
		{
			API::put('pages/pages/'.$id, $data);

			Platform::messages()->success('pages Updated Successfully.');

			return Redirect::to_admin('pages');
		}
		catch (APIClientException $e)
		{
			// Set the error message.
            //
            Platform::messages()->error($e->getMessage());

            // Set the other error messages.
            //
            foreach ($e->errors() as $error)
            {
                Platform::messages()->error($error);
            }

            return Redirect::to_admin('pages/edit/'.$id)->with_input();
		}


		return Theme::make('pages::pages.edit')->with('id', $id);
	}

	public function get_delete($id)
	{
		try
		{
			API::delete('pages/'.$id);
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
}