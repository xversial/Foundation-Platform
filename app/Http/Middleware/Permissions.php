<?php namespace App\Http\Middleware;

use Closure;
use Cartalyst\Alerts\Alerts;
use Cartalyst\Sentinel\Sentinel;

class Permissions {

	/**
	 * The sentinel instance.
	 *
	 * @var \Cartalyst\Sentinel\Sentinel
	 */
	protected $auth;

	/**
	 * The alerts instance.
	 *
	 * @var \Cartalyst\Alerts\Alerts
	 */
	protected $alerts;

	/**
	 * Create a new filter instance.
	 *
	 * @param  \Cartalyst\Sentinel\Sentinel  $auth
	 * @return void
	 */
	public function __construct(Sentinel $auth, Alerts $alerts)
	{
		$this->auth = $auth;
		$this->alerts = $alerts;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Get the prepared permissions
		$permissions = app('Platform\Permissions\Repositories\PermissionsRepositoryInterface')->getPreparedPermissions();

		// Get the permission name based on the current page
		$permission = array_get($permissions, $request->route()->getActionName());

		// Check if the user has access
		if ($this->auth->hasAnyAccess(['superuser', $permission])) return $next($request);

		$message = $permission ? 'no_access_to' : 'no_access';

		app('alerts')->error(trans('platform/access::permissions.'.$message, compact('permission')));

		return redirect('/');
	}

}
