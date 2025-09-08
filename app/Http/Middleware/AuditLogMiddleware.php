<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\Response;

class AuditLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch') || $request->isMethod('delete')) {
            activity()
                ->causedBy(Auth::user())
                ->withProperties([
                    'method' => $request->method(),
                    'path'   => $request->path(),
                    'data'   => $request->except(['password', 'password_confirmation']),
                ])
                ->log("{$request->method()} request on {$request->path()}");
        }

        return $response;
    }
}
