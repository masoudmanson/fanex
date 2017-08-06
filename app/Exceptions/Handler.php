<?php

namespace App\Exceptions;

use Exception;
use HttpResponseException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Psy\Exception\FatalErrorException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        }
        if ($exception instanceof CustomException) {
            $status = $exception->getCode();
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $status = $exception->getStatusCode();
        } elseif ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $status = 404;
        } elseif ($exception instanceof \Symfony\Component\Debug\Exception\FatalErrorException) {
            $status = 500;
        } elseif ($exception instanceof HttpResponseException) {
            $status = $exception->getCode();
        }  elseif ($exception instanceof AuthenticationException) {
            $status = $exception->getCode();
        } elseif ($exception instanceof \Illuminate\Database\QueryException) {
            $status = 2000;
        } elseif ($exception instanceof \RuntimeException) {
            $status = $exception->getCode();
        }

//        if(isset($status))
//            return response()->view('errors.error', array('exception' => $exception, 'status' => $status), 200);
//
//        return response()->view('errors.error', array('exception' => $exception, 'status' => 1000), 200);
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
