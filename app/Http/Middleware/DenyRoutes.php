<?php

namespace App\Http\Middleware;

use Encore\Admin\Auth\Permission;
use Symfony\Component\HttpFoundation\Request;

class DenyRoutes
{
    protected $disabledMethods = ['DELETE', 'PUT'];

    protected $routes = [
        'post' => [
            'media/upload',
            'helpers/terminal/database',
            'helpers/terminal/artisan',
            'helpers/scaffold',
        ],
    ];

    public function handle(Request $request, \Closure $next)
    {
        if (in_array($request->getMethod(), $this->disabledMethods)) {
            Permission::error();
        }

        foreach ($this->routes as $method => $route) {
            if ($request->isMethod($method) && $request->is(...$route)) {
                Permission::error();
            }
        }

        return $next($request);
    }
}