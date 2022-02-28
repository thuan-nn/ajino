<?php

namespace App\Exceptions;

use App\Supports\Traits\HandleErrorException;
use Flugg\Responder\Exceptions\ConvertsExceptions;
use Flugg\Responder\Exceptions\Http\HttpException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ConvertsExceptions;
    use HandleErrorException;

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
        //
    }

    /**
     * @param Throwable $exception
     *
     * @throws Throwable
     */
    public function report(Throwable $exception)
    {
        return parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            if ($exception instanceof HttpException) {
                return $this->renderResponse($exception);
            } elseif ($exception instanceof ValidationException) {
                return $this->renderApiResponse($exception);
            } elseif ($exception instanceof NotFoundHttpException) {
                return $this->renderApiNotFoundResponse($exception);
            } elseif ($exception instanceof BadRequestHttpException) {
                return $this->renderApiBadRequestResponse($exception);
            } elseif ($exception instanceof GuzzleException) {
                return $this->renderOracleException($exception);
            } elseif ($exception instanceof \ErrorException) {
                return $this->renderServerErrorException($exception);
            }
        }

        return parent::render($request, $exception);
    }
}
