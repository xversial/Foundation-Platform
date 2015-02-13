<?php namespace App\Exceptions;

use Closure;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Registered handlers.
	 *
	 * @var array
	 */
	protected $handlers = [];

	/**
	 * Registers a new exception handler.
	 *
	 * @param  string  $handle
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function handle($handle, Closure $callback)
	{
		$this->handlers[$handle] = $callback;
	}

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		$errorClass = get_class($e);

		if (array_key_exists($errorClass, $this->handlers))
		{
			return call_user_func_array($this->handlers[$errorClass], [$e]);
		}

		if ($this->isHttpException($e))
		{
			return $this->renderHttpException($e);
		}
		else
		{
			return parent::render($request, $e);
		}
	}

}
