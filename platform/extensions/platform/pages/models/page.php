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

namespace Platform\Pages\Model;


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use Crud;


/**
 * --------------------------------------------------------------------------
 * Pages > Content Model
 * --------------------------------------------------------------------------
 *
 * The Content model class.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Page extends Crud
{
	/**
	 * @var  array  $rules  Validation rules for model attributes
	 */
	protected static $_rules = array(
		'name'    => 'required',
		'slug'    => 'required|unique:pages',
		'value' => 'required',
	);

	/**
	 * Gets called before the validation is ran.
	 *
	 * @param   array  $data  The validation data
	 * @return  array
	 */
	protected function before_validation($data, $rules)
	{
		// if not new, adjust rules
		if ( ! $this->is_new())
		{
			// add id to the unique clause to prevent errors if same slug
			$rules['slug'] .= ',slug,'.$data['id'];
		}

		return array($data, $rules);
	}
}
