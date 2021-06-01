<?php

namespace App\Interfaces\Http\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\ErrorHandler\Error\FatalError;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return response()->json([
            'status'=> 'error',
            'message' => $e->validator->errors()->getMessages(),
            'data' => null
        ], 422);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \TypeError || $exception instanceof FatalError || $exception instanceof Error) {
            return response()->json([
                'status'=> 'error',
                'message' => $exception->getMessage(),
                'data' => null
            ], 500);
        }
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Not Found',
                'data' => null
            ], 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Not Allowed',
                'data' => null
            ], 405);
        }

        return parent::render($request, $exception);
    }
}
