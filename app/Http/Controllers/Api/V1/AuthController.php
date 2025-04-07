<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\Auth\UserLoginRequest;
use App\Http\Requests\Api\V1\Auth\UserRegisterRequest;
use App\Services\V1\Auth\AuthService;
use App\Services\V1\Auth\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Throwable;

class AuthController extends ApiController
{
    public function register(UserRegisterRequest $request, AuthService $authService): JsonResponse
    {
        try {
            [$user, $token] = $authService->registerUser(
                name: $request->get('name'),
                email: $request->get('email'),
                password: $request->get('password'),
            );

            return $this->loginResponse(
                message: 'Registered successfully',
                data: [
                    'user' => $user,
                    'token' => $token,
                ],
                token: $token
            );
        } catch (Throwable $th) {
            return $this->internalServerErrorResponse();
        }
    }

    public function login(
        UserLoginRequest $request,
        AuthService $authService
    ): JsonResponse {
        try {
            [$user, $token] = $authService->loginUser(
                email: $request->get('email'),
                password: $request->get('password'),
            );

            return $this->loginResponse(
                message: 'Logged in successfully',
                data: [
                    'user' => $user,
                    'token' => $token,
                ],
                token: $token
            );
        } catch (InvalidArgumentException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (Throwable $th) {
            return $this->internalServerErrorResponse();
        }
    }

    public function logout(Request $request, TokenService $tokenService): JsonResponse
    {
        try {
            $tokenService->deleteToken($request->user());

            return $this->logoutResponse('Logged out successfully');
        } catch (Throwable $th) {
            return $this->internalServerErrorResponse();
        }
    }
}
