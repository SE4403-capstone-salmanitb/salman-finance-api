<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful as MiddlewareEnsureFrontendRequestsAreStateful;
use Symfony\Component\HttpFoundation\Response;

class EnsureFrontendRequestsAreStateful extends MiddlewareEnsureFrontendRequestsAreStateful
{
    protected function configureSecureCookieSessions(): void
    {
        config([
            'session.http_only' => true,
            'session.secure' => true,
            'session.partitioned' => true,
            'session.same_site' => 'none',
        ]);
    }
}
