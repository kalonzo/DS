<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    * Install Sentry client
    * 1. run: $ composer require "sentry/sentry"
    * 2. run: $ composer require sentry/sentry-laravel
    * 
    * uncomment in providers and alias:
    * Sentry\SentryLaravel\SentryLaravelServiceProvider::class
    * 'Sentry' => Sentry\SentryLaravel\SentryFacade::class
    * 
    * uncomment handlers sentry snippets in report and render
    * 
    * create with artisan: php artisan vendor:publish --provider="Sentry\SentryLaravel\SentryLaravelServiceProvider"
    * 
    * add to .env in main folder: SENTRY_DSN=[https API key from Sentry account]
    */
    
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
        if(env('SENTRY_DSN')){
            //Sentry exception handler start
            if (app()->bound('sentry') && $this->shouldReport($exception)) {
                app('sentry')->captureException($exception);
            }
        }
        
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
        if($exception instanceof \Illuminate\Session\TokenMismatchException){
            if($request->ajax()){
                return response()->json(['success' => 0, 'error' => "La durée maximale d'inactivité de cette page a éré dépassée. "
                    . "Merci d'actualiser la page pour poursuivre votre navigation."], 500);
            } else {
                return redirect();
            }
        }
        
        // Convert all non-http exceptions to a proper 500 http exception
        // if we don't do this exceptions are shown as a default template
        // instead of our own view in resources/views/errors/500.blade.php
        if(!envDev()){
            if ($this->shouldReport($exception) && !$this->isHttpException($exception) && !config('app.debug')){
                $exception = new HttpException(500, 'Whoops!');
            }
        }
        //if 404 error
//        if($exception instanceof HttpException){
//            return response()->view('/errors/404custom', [], 404);
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
