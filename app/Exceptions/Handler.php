<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Psy\Exception\FatalErrorException;

//class Handler extends ExceptionHandler
class Handler extends \GrahamCampbell\Exceptions\NewExceptionHandler
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        }

//        if ($exception instanceof CustomException) {
//            $status = $exception->getCode();
//        }
//        else
//        if ($exception instanceof \Symfony\Component\Debug\Exception\FatalErrorException) {
//            $status = 500;
//        }
//        else {
//            $status = $exception->getStatusCode();
//        }

//        if($this->isHttpException($exception)){
            //return response()->view('errors.error', array('exception' => $exception, 'status' => $status) , $status);
//            return response()->view('errors.error', array('exception' => $exception) , $exception->getStatusCode());
//        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
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
