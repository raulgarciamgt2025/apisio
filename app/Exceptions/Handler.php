<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Handle unauthenticated API requests properly (no redirect).
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // For API routes, always return JSON response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'error' => 'Token not provided or invalid'
            ], 401);
        }

        // For web routes, you would need to define a login route
        // Since this is an API-only app, we'll return JSON
        return response()->json([
            'message' => 'Unauthenticated.',
            'error' => 'Token not provided or invalid'
        ], 401);
    }
}
