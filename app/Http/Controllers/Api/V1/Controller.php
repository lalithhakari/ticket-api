<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    public function loginResponse(string $message = '', array $data = [], string $token = ''): JsonResponse
    {
        $cookie = cookie(
            name: config('session.cookie'),
            value: $token,
            minutes: config('system.auth_cookie_expiry'),
            httpOnly: false,
            secure: false,
            domain: config('session.domain'),
        );

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'errors' => (object) [],
            'data' => (object) $data,
        ], Response::HTTP_OK)->withCookie($cookie);
    }

    public function logoutResponse(string $message = ''): JsonResponse
    {
        $cookie = cookie(
            name: config('session.cookie'),
            value: null,
            minutes: 0,
            httpOnly: false,
            secure: false,
            domain: config('session.domain'),
        );

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'errors' => (object) [],
            'data' => (object) [],
        ], Response::HTTP_OK)->withCookie($cookie);
    }

    public function successResponse(string $message = '', array $data = []): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'errors' => (object) [],
            'data' => (object) $data,
        ], Response::HTTP_OK);
    }

    public function validationErrorResponse(string $message = '', array $errors = []): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => (object) $errors,
            'data' => (object) [],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function invalidRequestResponse(): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid request',
            'errors' => (object) [],
            'data' => (object) [],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function httpUnauthenticated(): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthenticated',
            'errors' => (object) [],
            'data' => (object) [],
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function splashResponse(): JsonResponse
    {
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function forbiddenResponse(): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'FORBIDDEN',
            'errors' => (object) [],
            'data' => (object) [],
        ], Response::HTTP_FORBIDDEN);
    }
}
