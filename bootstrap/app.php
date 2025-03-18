<?php

use App\Http\Middleware\TenantMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register TenantMiddleware as a global middleware to ensure it runs first
        $middleware->append(TenantMiddleware::class);

        // Configure auth middleware with 'api' guard for staff
        // $middleware->api('auth:staff');

        // Also apply tenant middleware to specific routes if needed
        $middleware->web(TenantMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Handle other API requests with JSON responses
        $exceptions->renderable(function (Throwable $e, Request $request) {

            // Check if request is an API request
            if ($request->expectsJson() || $request->is('api/*')) {

                // AuthenticationException
                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'message' => 'Unauthenticated.',
                    ], Response::HTTP_UNAUTHORIZED);
                }

                // Validation exceptions
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => $e->errors(),
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                // Authorization exceptions
                if ($e instanceof AuthorizationException) {
                    return response()->json([
                        'message' => 'This action is unauthorized.',
                    ], Response::HTTP_FORBIDDEN);
                }

                // Model not found exceptions
                if ($e instanceof ModelNotFoundException) {
                    $modelName = strtolower(class_basename($e->getModel()));
                    return response()->json([
                        'message' => "Unable to find the requested {$modelName}.",
                    ], Response::HTTP_NOT_FOUND);
                }

                // Route not found exceptions
                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'message' => 'The requested resource was not found.',
                    ], Response::HTTP_NOT_FOUND);
                }

                // Method not allowed exceptions
                if ($e instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        'message' => 'The requested method is not allowed for this endpoint.',
                    ], Response::HTTP_METHOD_NOT_ALLOWED);
                }

                // Database query exceptions
                if ($e instanceof QueryException) {
                    // Check for foreign key constraint failures
                    if (str_contains($e->getMessage(), 'Foreign key constraint')) {
                        return response()->json([
                            'message' => 'Data integrity constraint violation.',
                        ], Response::HTTP_CONFLICT);
                    }

                    // Check for unique constraint violations
                    if (str_contains($e->getMessage(), 'Duplicate entry') || $e->getCode() === '23000') {
                        return response()->json([
                            'message' => 'The record already exists.',
                        ], Response::HTTP_CONFLICT);
                    }

                    // Generic database error (don't expose details in production)
                    return response()->json([
                        'message' => 'Database error occurred.',
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                // HTTP exceptions
                if ($e instanceof HttpException) {
                    return response()->json([
                        'message' => $e->getMessage() ?: 'HTTP error occurred.',
                    ], $e->getStatusCode());
                }

                return response()->json([
                    'message' => $e->getMessage() ?: 'An unexpected error occurred.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return null;
        });

        // Don't report certain exceptions to avoid log spam
        $exceptions->dontReport([
            // \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Auth\Access\AuthorizationException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
            \Illuminate\Database\Eloquent\ModelNotFoundException::class,
            \Illuminate\Validation\ValidationException::class,
        ]);
    })
    ->create();
