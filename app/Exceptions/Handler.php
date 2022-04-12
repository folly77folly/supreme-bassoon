<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'status' => 'failed',
                'status_code' => '401',
                'message' => "You are not authorized"
            ], 401);
        }elseif($exception instanceof ModelNotFoundException)
        {
            return response()->json([
                'status' => 'failed',
                'status_code' => '404',
                'message' => "Resource not found"
            ], 404);
        }
        elseif($exception instanceof QueryException)
        {
            return response()->json([
                'status' => 'failed',
                'status_code' => '500',
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ], 500);
        }
        elseif($exception instanceof InvalidSignatureException)
        {
            return response()->json([
                'status' => 'failed',
                'status_code' => '500',
                'message' => 'the verification link is invalid',
            ], 404);
        }
        // return response()->json([
        //     'status' => 'failed',
        //     'status_code' => 404,
        //     'message' => $exception->getMessage(),
        //     'error' => $exception->errors()
        // ], 404);QueryException
            return parent::render($request, $exception);
    }
}
