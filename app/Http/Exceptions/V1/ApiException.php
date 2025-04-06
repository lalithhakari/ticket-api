<?php

namespace App\Http\Exceptions\V1;

use App\Http\Traits\Responses\V1\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiException
{
    use ApiResponse;

    public static function handle(Exceptions $exceptions)
    {
        ApiException::handleAuthException($exceptions);
        ApiException::handleModelNotFoundException($exceptions);
        ApiException::handleNotFoundHttpException($exceptions);
        ApiException::handleMethodNotAllowedException($exceptions);
    }

    public static function handleAuthException(Exceptions $exceptions)
    {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/v1/*')) {
                return ApiResponse::httpUnauthenticated();
            }
        });
    }

    public static function handleModelNotFoundException(Exceptions $exceptions)
    {
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/v1/*')) {
                return ApiResponse::resourceNotFoundResponse();
            }
        });
    }

    public static function handleNotFoundHttpException(Exceptions $exceptions)
    {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/v1/*')) {
                return ApiResponse::resourceNotFoundResponse();
            }
        });
    }

    public static function handleMethodNotAllowedException(Exceptions $exceptions)
    {
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/v1/*')) {
                return ApiResponse::httpMethodNotAllowedResponse();
            }
        });
    }
}
