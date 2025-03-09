<?php

use App\Exceptions\ApiException;
use App\Http\Middleware\TenantMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register the TenantMiddleware
        $middleware->web(TenantMiddleware::class);
        $middleware->api(TenantMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // // Handle 404 Not Found
        // $exceptions->renderable(function (NotFoundHttpException $e) {
        //     if (!request()->expectsJson() && !request()->is('api/*')) {
        //         return redirect()->route('home');
        //     }
        //     return response()->json([
        //         'error' => true,
        //         'message' => trans('errors.404'),
        //     ], Response::HTTP_NOT_FOUND);
        // });

        // // Handle 401 Unauthorized
        // $exceptions->renderable(function (UnauthorizedHttpException $e) {
        //     if (!request()->expectsJson() && !request()->is('api/*')) {
        //         return redirect()->route('login');
        //     }
        //     return response()->json([
        //         'error' => true,
        //         'message' => trans('errors.401'),
        //     ], Response::HTTP_UNAUTHORIZED);
        // });

        // // Handle 403 Forbidden
        // $exceptions->renderable(function (AccessDeniedHttpException $e) {
        //     if (!request()->expectsJson() && !request()->is('api/*')) {
        //         return redirect()->route('home');
        //     }
        //     return response()->json([
        //         'error' => true,
        //         'message' => trans('errors.403'),
        //     ], Response::HTTP_FORBIDDEN);
        // });

        // // Handle generic HTTP exceptions
        // $exceptions->renderable(function (HttpException $e) {
        //     if (!request()->expectsJson() && !request()->is('api/*')) {
        //         return redirect()->route('home');
        //     }
        //     return response()->json([
        //         'error' => true,
        //         'message' => $e->getMessage() ?: trans('errors.500'),
        //     ], $e->getStatusCode());
        // });

        // // Handle 500 Internal Server Error
        // $exceptions->renderable(function (\Exception $e) {
        //     if (!request()->expectsJson() && !request()->is('api/*')) {
        //         return redirect()->route('home');
        //     }
        //     return response()->json([
        //         'error' => true,
        //         'message' => trans('errors.500'),
        //     ], Response::HTTP_INTERNAL_SERVER_ERROR);
        // });
    })
    ->create();
