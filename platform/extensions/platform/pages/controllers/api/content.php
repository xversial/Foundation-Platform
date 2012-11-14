<?php

use Platform\Pages\Model\Content;

class Platform_Pages_Api_Content_Controller extends API_Controller
{
	public function get_index($id = false)
	{
		$config = Input::get() + array(
			'where' => array(),
		);

		try
		{
			if ($id == false)
			{
				$content = Content::all(function($query) use ($config) {

					if ( ! empty($config['where']))
					{
						if (is_array($config['where'][0]))
						{
							foreach ($config['where'] as $where)
							{
								$query = $query->where($where[0], $where[1], $where[2]);
							}
						}
						else
						{
							$where = $config['where'];
							$query = $query->where($where[0], $where[1], $where[2]);
						}
					}

					return $query;

				});
			}
			else
			{
				$content = Content::find(function($query) use ($id, $config) {

					if ( ! empty($config['where']))
					{
						if (is_array($config['where'][0]))
						{
							foreach ($config['where'] as $where)
							{
								$query = $query->where($where[0], $where[1], $where[2]);
							}
						}
						else
						{
							$where = $config['where'];
							$query = $query->where($where[0], $where[1], $where[2]);
						}
					}

					$field = ( is_numeric($id)) ? 'id' : 'slug';

					return $query->where($field, '=', $id);
				});
			}

			if ($content)
			{
				return new Response($content);
			}

			return new Response(Lang::line('platform/pages::messages.content.not_found')->get(), API::STATUS_NOT_FOUND);
		}
		catch (Exception $e)
		{
			return new Response(Lang::line('platform/pages::messages.content.not_found')->get(), API::STATUS_NOT_FOUND);
		}
	}

	public function post_index()
	{
		// Get the Post Data
		//
		$content = new Content(Input::get());

		try
		{
			if ($content->save())
			{
				return new Response($content, API::STATUS_CREATED);
			}

			return new Response(array(
				'message' => Lang::line('platform/pages::messages.content.create.error')->get(),
				'errors'  => ($content->validation()->errors->has()) ? $content->validation()->errors->all() : array(),
				), ($content->validation()->errors->has()) ? API::STATUS_BAD_REQUEST : API::STATUS_UNPROCESSABLE_ENTITY);
		}
		catch (Exception $e)
		{
			return new Response(array(
				'message' => $e->getMessage(),
			), API::STATUS_BAD_REQUEST);
		}
	}

	public function put_index($id)
	{
		$content = new Content(array_merge(
			array('id' => $id), Input::get()
		));

		try
		{
			if ($content->save())
			{
				return new Response($content);
			}

			return new Response(array(
					'message' => Lang::line('platform/pages::messages.content.edit.error')->get(),
					'errors'  => ($content->validation()->errors->has()) ? $content->validation()->errors->all() : array(),
				), ($content->validation()->errors->has()) ? API::STATUS_BAD_REQUEST : API::STATUS_UNPROCESSABLE_ENTITY);
		}
		catch (Exception $e)
		{
			return new Response(array(
				'message' => $e->getMessage(),
			), API::STATUS_BAD_REQUEST);
		}
	}

	public function delete_index($id)
	{
		try
		{
			$content = Content::find($id);

			if ($content === null)
			{
				return new Response(array(
					'message' => Lang::line('platform/pages::messages.content.delete.error')->get()
				), API::STATUS_NOT_FOUND);
			}

			if ($content->delete())
			{
				return new Response(null, API::STATUS_NO_CONTENT);
			}

			return new Response(array(
				'message' => Lang::line('platform/pages::messages.content.delete.error')->get(),
				'errors'  => ($content->validation()->errors->has()) ? $content->validation()->errors->all() : array(),
			), ($content->validation()->errors->has()) ? API::STATUS_BAD_REQUEST : API::STATUS_UNPROCESSABLE_ENTITY);
		}
		catch (Exception $e)
		{
			return new Response(array(
				'message' => $e->getMessage(),
			), API::STATUS_BAD_REQUEST);
		}
	}

	public function get_datatable()
	{
		$defaults = array(
			'select'    => array(
				'content.id'    => Lang::line('platform/pages::table.content.id')->get(),
				'content.name'  => Lang::line('platform/pages::table.content.name')->get(),
				'slug'          => Lang::line('platform/pages::table.content.slug')->get(),
				'settings.name' => Lang::line('platform/pages::table.content.status')->get(),
			),
			'alias'     => array(
				'content.id'    => 'id',
				'content.name'  => 'name',
				'settings.name' => 'status',
			),
			'where'     => array(),
			'order_by'  => array('content.id' => 'desc'),
		);

		// lets get to total user count
		$count_total = Content::count();

		// get the filtered count
		$count_filtered = Content::count('content.id', function($query) use ($defaults)
		{
			// sets the where clause from passed settings
			$query = Table::count($query, $defaults);

			return $query
				->join('settings', 'settings.value', '=', 'content.status')
				->where('settings.vendor', '=', 'platform')
				->where('settings.extension', '=', 'pages')
				->where('settings.type', '=', 'status');
		});

		// set paging
		$paging = Table::prep_paging($count_filtered, 20);

		$items = Content::all(function($query) use ($defaults, $paging)
		{
			list($query, $columns) = Table::query($query, $defaults, $paging);

			return $query
				->select($columns)
				->join('settings', 'settings.value', '=', 'content.status')
				->where('settings.vendor', '=', 'platform')
				->where('settings.extension', '=', 'pages')
				->where('settings.type', '=', 'status');

		});

		$items = ($items) ?: array();

		return new Response(array(
			'columns'        => $defaults['select'],
			'rows'           => $items,
			'count'          => $count_total,
			'count_filtered' => $count_filtered,
			'paging'         => $paging,
		));
	}
}