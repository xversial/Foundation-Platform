<?php

class Pages_Admin_Content_Controller extends Admin_Controller
{
	public function before()
	{
		parent::before();
		$this->active_menu('admin-pages-content');
	}

	public function get_index()
	{
		$options = Input::get();

		// Grab our datatable
		//
		$datatable = API::get('pages/content/datatable', $options);

		$data = array(
			'columns' => $datatable['columns'],
			'rows'    => $datatable['rows'],
		);

		if (Request::ajax())
		{
			$data = array(
				'content'        => Theme::make('pages::content.partials.table', $data)->render(),
				'count'          => $datatable['count'],
				'count_filtered' => $datatable['count_filtered'],
				'paging'         => $datatable['paging'],
			);

			return json_encode($data);
		}

		return Theme::make('pages::content.index', $data);
	}

	public function get_create()
	{
		return Theme::make('pages::content.create');
	}

	public function post_create()
	{
		// Prepare data
		//
		$data = array(
			'name'    => Input::get('name'),
			'slug'    => Input::get('slug'),
			'value'   => Input::get('value'),
		);

		try
		{
			// Create content
			//
			API::post('pages/content', $data);

			Platform::messages()->success(Lang::line('pages::messages.content.create.success')->get());

			return Redirect::to_admin('pages/content');
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

            return Redirect::to_admin('pages/content/create')->with_input();
		}
	}

	public function get_edit($id)
	{
		return Theme::make('pages::content.edit')->with('id', $id);
	}

	public function post_edit($id)
	{
		// Prepare data
		//
		$data = array(
			'name'    => Input::get('name'),
			'slug'    => Input::get('slug'),
			'value'   => Input::get('value'),
		);

		try
		{
			// Edit content
			//
			API::put('pages/content/'.$id, $data);

			Platform::messages()->success(Lang::line('pages::messages.content.edit.success')->get());

			return Redirect::to_admin('pages/content');
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

            return Redirect::to_admin('pages/content/edit/'.$id)->with_input();
		}


		return Theme::make('pages::content.edit')->with('id', $id);
	}

	public function get_delete($id)
	{
		try
		{
			// Delete content
			//
			API::delete('pages/content/'.$id);
		}
		catch (APIClientException $e)
		{
			Platform::messages()->error($e->getMessage());

			foreach ($e->errors() as $error)
			{
				Platform::messages()->error($error);
			}
		}

		return Redirect::to_admin('pages/content');
	}
}
