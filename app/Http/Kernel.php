<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * Temporary store for disabled middleware.
     *
     * @var array
     */
    protected $disabledMiddleware = [];

    /**
     * Temporary store for disabled route middleware.
     *
     * @var array
     */
    protected $disabledRouteMiddleware = [];

    /**
     * Disable middleware.
     *
     * @return void
     */
    public function disableMiddleware()
    {
        $this->disabledMiddleware = $this->middleware;

        $this->middleware = [];
    }

    /**
     * Enable middleware.
     *
     * @return void
     */
    public function enableMiddleware()
    {
        $this->middleware = $this->disableMiddleware;

        $this->disabledMiddleware = [];
    }

    /**
     * Disable route middleware.
     *
     * @return void
     */
    public function disableRouteMiddleware()
    {
        $this->disabledRouteMiddleware = $this->routeMiddleware;

        $this->routeMiddleware = [];
    }

    /**
     * Enable route middleware.
     *
     * @return void
     */
    public function enableRouteMiddleware()
    {
        $this->routeMiddleware = $this->disableRouteMiddleware;

        $this->disabledRouteMiddleware = [];
    }

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
