<?php

namespace App\Exceptions;

use App\Traits\ApiTrait;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use ApiTrait;
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
//        if (\App::environment() == 'testing') {
//            throw $exception;
//        }
        if ($this->isApiCall($request)) {
            $response = [
                'error' => 'Sorry, something went wrong.'
            ];
            // If the app is in debug mode
            if (config('app.debug')) {
                $response['exception'] = get_class($exception); // Reflection might be better here
                $response['message'] = $exception->getMessage();
            }
            $status = 400;
            if ($exception instanceof \HttpException) {
                // Grab the HTTP status code from the Exception
                $status = $exception->getCode();
            }
            if ($exception instanceof ValidationException) {
                //add validation exception
                $status = 422;
                $response['errors'] = $exception->errors();
//                var_dump($exception->errors()   );
            }
//            var_dump($exception->getMessage());
//            var_dump($exception->getLine());
//            var_dump($exception->getFile());
            return response()->json($response, $status);
        }
        return parent::render($request, $exception);
    }
}
