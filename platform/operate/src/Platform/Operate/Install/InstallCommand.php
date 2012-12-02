<?php namespace Platform\Operate\Install;
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
 * @version    2.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'platform:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Installs Platform';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// Build up a nice welcome message
		$this->info(<<<WELCOME

*-----------------------------------*
|                                   |
| Welcome to the Platform Installer |
|     Copyright (c) 2011 - 2013     |
|           Cartalyst LLC.          |
|                                   |
|   Platform is release under the   |
|       BSD License (3-clause)      |
|                                   |
|    For Platform news, help and    |
|       updates, please visit       |
|   getplatform.com or find us on   |
| Twitter through @cartalyst. We're |
|  also on irc.freenode.net in the  |
|        #cartalyst channel.        |
|                                   |
|    Thanks for using Platform!     |
|                                   |
*-----------------------------------*


WELCOME
		);

		// Setup counte
		$stepCounter = 1;
	}
}