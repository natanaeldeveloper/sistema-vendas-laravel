<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {

            if (env('APP_DEBUG') !== true) {
                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'status'  => 404,
                        'message' => 'Recurso não encontrado.',
                    ], 404);
                }

                if ($e instanceof QueryException) {
                    return response()->json([
                        'status'  => 500,
                        'message' => 'Erro de comunicação com o banco de dados.',
                    ], 500);
                }
            }
        });
    }
}
