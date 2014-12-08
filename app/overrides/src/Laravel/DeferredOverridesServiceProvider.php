<?php namespace Cartalyst\Platform\Laravel;
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

use Cartalyst\Platform\Translator;
use Illuminate\Support\ServiceProvider;

class DeferredOverridesServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	protected $defer = true;

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		$this->registerTranslator();
	}

	/**
	 * Registers the Translator.
	 *
	 * @return void
	 */
	protected function registerTranslator()
	{
		$this->app->bindShared('translator', function($app)
		{
			$locales = array_get($app['config']->get('cartalyst/localization::config'), 'locales', []);

			$translator = new Translator($app['translation.loader'], $app['config']['app.locale']);

			$translator->setContainer($app);
			$translator->setLocales($locales);
			$translator->setFallback($app['config']['app.fallback_locale']);

			return $translator;
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function provides()
	{
		return [
			'translator',
		];
	}

}
