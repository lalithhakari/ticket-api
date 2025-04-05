<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Api\V1\Auth\UserLoginRequest;
use App\Http\Requests\Api\V1\Auth\UserRegisterRequest;
use App\Services\V1\Auth\AuthService;
use App\Services\V1\Auth\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Throwable;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request, AuthService $authService): JsonResponse
    {
        try {
            [$user, $token] = $authService->registerUser(
                name: $request->get('name'),
                email: $request->get('email'),
                password: $request->get('password'),
            );

            return $this->loginResponse('Registration successful', [
                'user' => $user,
                'token' => $token,
            ], $token);
        } catch (Throwable $th) {
            return $this->invalidRequestResponse();
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

            return $this->loginResponse('Login successful', [
                'user' => $user,
                'token' => $token,
            ], $token);
        } catch (InvalidArgumentException $e) {
            return $this->validationErrorResponse($e->getMessage());
        } catch (Throwable $th) {
            return $this->invalidRequestResponse();
        }
    }

    public function logout(Request $request, TokenService $tokenService): JsonResponse
    {
        try {
            $tokenService->deleteToken($request->user());

            return $this->logoutResponse('Logout successful');
        } catch (Throwable $th) {
            return $this->invalidRequestResponse();
        }
    }
}
