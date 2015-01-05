<?php namespace Cartalyst\Platform;
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Platform
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Platform\Access\Traits\UrlGeneratorTrait as AccessUrlGeneratorTrait;
use Cartalyst\Localization\Traits\UrlGeneratorTrait as LocalizationUrlGeneratorTrait;

class UrlGenerator extends \Illuminate\Routing\UrlGenerator {

	use AccessUrlGeneratorTrait, LocalizationUrlGeneratorTrait;

	/**
	 * Get the URL for the previous request.
	 *
	 * @param  string  $fallback
	 * @return string
	 */
	public function previous($fallback = null)
	{
		$referer = $this->request->headers->get('referer', $fallback);

		return $this->to(
			app('request')->input('previous_url', $referer)
		);
	}

}
