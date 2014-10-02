<?php namespace Platform\Bootstrap\Requirements;
/**
 * Part of the Platform Installer extension.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Platform Installer extension
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

/*
|--------------------------------------------------------------------------
| Platform requirement rules
|--------------------------------------------------------------------------
|
| TBD
|
| Note: laravel hasn't been booted, you can't use composer or even a
|       even a helper.
|
*/

interface RequirementInterface {

	/**
	 * Performs the requirement check.
	 *
	 * @return bool
	 */
	public function check();

	/**
	 * Returns the title translation key.
	 *
	 * @return string
	 */
	public function title();

	/**
	 * Returns the message translation key.
	 *
	 * @return string
	 */
	public function message();

}

class DependenciesRequirement implements RequirementInterface {

	/**
	 * {@inheritDoc}
	 */
	public function check()
	{
		return file_exists(realpath('../vendor'));
	}

	/**
	 * {@inheritDoc}
	 */
	public function title()
	{
		return 'Composer Dependencies';
	}

	/**
	 * {@inheritDoc}
	 */
	public function message()
	{
		return 'Composer dependencies missing';
	}

}

class StoragePermissionsRequirement implements RequirementInterface {

	/**
	 * {@inheritDoc}
	 */
	public function check()
	{
		return     is_writable(realpath('../app/storage'));
	}

	/**
	 * {@inheritDoc}
	 */
	public function title()
	{
		return 'Storage Write Permissions';
	}

	/**
	 * {@inheritDoc}
	 */
	public function message()
	{
		return 'app/storage must be writable.';
	}

}

class ConfigPermissionsRequirement implements RequirementInterface {

	/**
	 * {@inheritDoc}
	 */
	public function check()
	{
		return is_writable(realpath('../app/config'));
	}

	/**
	 * {@inheritDoc}
	 */
	public function title()
	{
		return 'Public Write Permissions';
	}

	/**
	 * {@inheritDoc}
	 */
	public function message()
	{
		return 'app/config must be writable.';
	}

}

class PublicPermissionsRequirement implements RequirementInterface {

	/**
	 * {@inheritDoc}
	 */
	public function check()
	{
		return is_writable(realpath('../public/cache'));
	}

	/**
	 * {@inheritDoc}
	 */
	public function title()
	{
		return 'Public Write Permissions';
	}

	/**
	 * {@inheritDoc}
	 */
	public function message()
	{
		return 'public/cache must be writable.';
	}

}

class PHPExtensionsRequirement implements RequirementInterface {

	/**
	 * {@inheritDoc}
	 */
	public function check()
	{
		return extension_loaded('mcrypt') && extension_loaded('gd');
	}

	/**
	 * {@inheritDoc}
	 */
	public function title()
	{
		return 'PHP Extensions';
	}

	/**
	 * {@inheritDoc}
	 */
	public function message()
	{
		return 'Mcrypt and GD extensions are required.';
	}

}

class PHPVersionRequirement implements RequirementInterface {

	/**
	 * {@inheritDoc}
	 */
	public function check()
	{
		return version_compare(PHP_VERSION, '5.4', '>=');
	}

	/**
	 * {@inheritDoc}
	 */
	public function title()
	{
		return 'PHP Version';
	}

	/**
	 * {@inheritDoc}
	 */
	public function message()
	{
		return 'PHP version 5.4 or greater required.';
	}

}

class DummyRequirement implements RequirementInterface {

	/**
	 * {@inheritDoc}
	 */
	public function check()
	{
		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function title()
	{
		return 'Dummy';
	}

	/**
	 * {@inheritDoc}
	 */
	public function message()
	{
		return 'I alaways fail :D';
	}

}

/*
|--------------------------------------------------------------------------
| Register the desired requirements
|--------------------------------------------------------------------------
|
| Once we have all our rules created, let's define which ones should be
| run in other to boot our app.
|
*/

$requirements = [
	new DependenciesRequirement,
	new StoragePermissionsRequirement,
	new ConfigPermissionsRequirement,
	new PublicPermissionsRequirement,
	new PHPExtensionsRequirement,
	new PHPVersionRequirement,
	new DummyRequirement,
];

/*
|--------------------------------------------------------------------------
| BOOM! Check the requirements
|--------------------------------------------------------------------------
|
| Finally, let's run over all our requirement classes. If any of the them
| fails, we will stop the execution and return some raw HTML.
|
*/

$pass = true;

foreach ($requirements as $requirement)
{
	if ( ! $requirement->check())
	{
		$pass = false;
		break;
	}
}

?>

<?php if ( ! $pass): ?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Installation Checks</title>
		<style>

			article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block;}
			audio,canvas,progress,video{display:inline-block;}
			html{font-size:100%;}
			body{font-family: ‘Lucida Console’, Monaco, monospace;line-height:1.5;margin:0; overflow-x:hidden;}
			address,blockquote,dd,dl,fieldset,form,hr,menu,ol,p,pre,q,table,ul{margin:0 0 1.25em;}
			h1,h2,h3,h4,h5,h6{line-height:1.25;}

			* { margin: 0; padding: 0; }

			hr {
				border:1px solid #eee;
				margin:32px 0;
			}

			h1, h2 {
				margin-top: 21px;
				margin-bottom: 10.5px;
				font-weight: 400;
				line-height: 1.1;
				color: inherit;
			}

			h1 {
				font-size: 2em;
				margin: 0.67em 0;
			}

			.install {
				text-align: center;
			}

			.install > header {
				position: absolute;
				top:40px;
				width:100%;
				z-index: 2;
			}

			.install > section {
				background:#fff;
				width: 100%;
				position:absolute;
				z-index: 3;
				top:200px;
				bottom:0;
			}

			.brand {
				position:relative;
				bottom: 0px;

				-webkit-animation: bot_float ease 3s 4;
				-moz-animation: bot_float ease 3s 4;
				-ms-animation: bot_float ease 3s 4;
				animation: bot_float ease 3s 4;
			}

			.brand__image img {
				max-width: 280px;
			}

			@-webkit-keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }
			@-moz-keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }
			@-ms-keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }
			@keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }

			.page {
				padding:0 16px;
			}

			.page__wrapper {
				background: white;
				border-radius: 10px;
				padding: 2em;
				border:1px solid #ddd;
				max-width:800px;
				margin:0 auto 32px auto;
			}

			.errors {
				max-width:640px;
				margin:0 auto;
			}

			.alert {
				padding: 15px;
				margin-bottom: 21px;
				border: 1px solid transparent;
				border-radius: 4px;
			}

			.alert-danger {
				background-color: #e74c3c;
				border-color: #e74c3c;
				color: #ffffff;
			}

			.alert-success {
				background-color: #18bc9c;
				border-color: #18bc9c;
				color: #ffffff;
			}

			.btn {
				display: inline-block;
				margin-bottom: 0;
				font-weight: normal;
				text-align: center;
				vertical-align: middle;
				cursor: pointer;
				background-image: none;
				border: 1px solid transparent;
				white-space: nowrap;
				padding: 10px 15px;
				font-size: 15px;
				line-height: 1.42857143;
				border-radius: 4px;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
				text-decoration: none;
			}

			.btn-lg {
				padding: 18px 27px;
				font-size: 19px;
				line-height: 1.33;
				border-radius: 6px;
			}

			.btn-primary {
				color: #ffffff;
				background-color: #2c3e50;
				border-color: #2c3e50;
			}

			.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active {
				color: #ffffff;
				background-color: #1a242f;
				border-color: #161f29;
			}

		</style>

	</head>
	<body>

		<section class="install">

			<header>
				<div class="brand">
					<div class="brand__image">
						<img src="brand.svg" alt="Ornery Octopus">
					</div>
				</div>
			</header>

			<section class="page">

				<div class="page__wrapper">

					<header>
						<h1>Installing Platform</h1>
						<h3 class="text-danger">Woah there high speed. We found a few issues.</h3>
						<hr>
					</header>

					<section class="errors">

						<?php foreach ($requirements as $requirement): ?>

							<?php if ( ! $requirement->check()): ?>
								<div class="alert alert-danger" role="alert"><?php echo $requirement->message(); ?></div>
							<?php else: ?>
								<div class="alert alert-success" role="alert"><?php echo $requirement->message(); ?></div>
							<?php endif; ?>

						<?php endforeach; ?>

						<a href="" class="btn btn-primary btn-lg">Refresh</a>

					</section>
				</div>
			</section>
		</section>

	</body>
	</html>

	<?php exit(1); ?>
<?php endif; ?>
