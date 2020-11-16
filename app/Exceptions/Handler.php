<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'  
    ];

    public function report(Exception $e)
    {
        return parent::report($e);
    }
public function render($request, Exception $exception)
{
    if ($exception instanceof TestingHttpException) {
        return response()->view('errors.404');
    }
    return parent::render($request, $exception);
}

}