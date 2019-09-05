<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    const DEFAULT_ERROR_CODE= 1000;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        BaseException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if (config('app.debug', false)) {
            return parent::render($request, $exception);
        }
        $fe = FlattenException::create($exception);
        if ($exception instanceof HttpException) {
            $content = Response::$statusTexts[$fe->getStatusCode()];
        } elseif ($exception instanceof BaseException) {
            $fe->setStatusCode(200);
            $content = $this->error($exception->getMessage(), $exception->getCode());
        } else {

            $content = $this->error('Server Error.', self::DEFAULT_ERROR_CODE);
        }
        $response = new Response($content, $fe->getStatusCode(), $fe->getHeaders());
        return $response;
    }
}
