<?php

use App\Models\User;

test('user can register', function () {
    $payload = [
        'name' => fake()->name(),
        'email' => fake()->safeEmail(),
        'password' => 'password',
    ];
    $response = $this->postJson(route('api.v1.register'), $payload);

    $response->assertStatus(200)
        ->assertCookie(config('session.cookie'))
        ->assertJsonStructure([
            'data' => [
                'user',
                'token',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
});

test('user cannot register again with same email', function () {
    $payload = [
        'name' => fake()->name(),
        'email' => fake()->safeEmail(),
        'password' => 'password',
    ];
    $this->postJson(route('api.v1.register'), $payload);

    $response = $this->postJson(route('api.v1.register'), $payload);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'email',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'error',
            'message' => 'The email has already been taken.',
            'email' => ['The email has already been taken.'],
        ]);
});

test('user can login', function () {
    $user = User::factory()->create();
    $payload = [
        'email' => $user->email,
        'password' => 'password',
    ];
    $response = $this->postJson(route('api.v1.login'), $payload);

    $response->assertStatus(200)
        ->assertCookie(config('session.cookie'))
        ->assertJsonStructure([
            'data' => [
                'user',
                'token',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'name' => $user->name,
            'email' => $user->email,
        ]);
});

test('user cannot login with wrong password', function () {
    $user = User::factory()->create();
    $payload = [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ];
    $response = $this->postJson(route('api.v1.login'), $payload);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
        ])
        ->assertJsonFragment([
            'status' => 'error',
            'message' => 'Invalid credentials',
        ]);
});

test('user can logout', function () {
    $response = actingAsApiUser()->getJson(route('api.v1.logout'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
});

test('user cannot logout without authentication', function () {
    $response = $this->getJson(route('api.v1.logout'));

    $response->assertStatus(401)
        ->assertJsonStructure([
            'message',
        ])
        ->assertJsonFragment([
            'status' => 'error',
            'message' => 'Unauthenticated',
        ]);
});

test('user cannot access protected route without authentication', function () {
    $response = $this->getJson(route('api.v1.tickets.index'));

    $response->assertStatus(401)
        ->assertJsonStructure([
            'message',
        ])
        ->assertJsonFragment([
            'status' => 'error',
            'message' => 'Unauthenticated',
        ]);
});

test('user can access protected route with authentication', function () {
    $response = actingAsApiUser()->getJson(route('api.v1.tickets.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'tickets',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
        ]);
});
