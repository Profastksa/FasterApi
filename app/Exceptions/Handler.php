<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\Response;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Throwable;

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
        $this->reportable(function (Throwable $ex) {
            // info($ex->getMessage());
            // if(config('app.env')== 'production'){
            //     info('the excption was handel');
            //     Mail::to('jksa.work.1@gmail.com')->send(new \App\Mail\ExceptionOccured($ex));
            //  // return abort(403, 'Server Is Down Please Try Again Later');
            // }
        });
    }
}
