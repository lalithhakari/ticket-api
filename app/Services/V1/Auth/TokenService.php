<?php

namespace App\Services\V1\Auth;

use App\Models\User;
use Carbon\Carbon;

class TokenService
{
    public function createToken(User $user, string $tokenName = 'token-name', array $tokenAbilities = ['*'], ?Carbon $tokenExpiry = null): string
    {
        $token = $user->createToken(
            $tokenName,
            $tokenAbilities,
            $tokenExpiry ?? now()->addWeek()
        )->plainTextToken;

        return $token;
    }

    public function deleteToken(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
