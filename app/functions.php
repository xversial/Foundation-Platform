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
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Platform\Ui\Models\Menu;

if ( ! function_exists('set_admin_menu_order'))
{
	/**
	 * Set the order of the the given menu's
	 * children according to array of slugs
	 * given. This will not remove any menu
	 * items and it will skip non-existent
	 * items (they'll be shoved at the end
	 * of the menu).
	 *
	 * @param  string  $menuSlug
	 * @param  array   $slugs
	 * @return void
	 */
	function set_menu_order($menuSlug, arary $slugs)
	{
		$previous = null;

		foreach ($slugs as $slug)
		{
			if ( ! $current = Menu::find($slug)) continue;

			// If we have a previous menu child, we're assigning
			// this child as it's next sibling
			if ($previous)
			{
				$previous->refresh();
				$current->makeNextSiblingOf($previous);
			}

			// Otherwise, we're on the first child in the
			// loop, at which point we want our child to
			// be the first child
			else
			{
				$admin = Menu::find($menuSlug);
				$current->makeFirstChildOf($admin);
			}

			$previous = $current;
		}
	}
}
