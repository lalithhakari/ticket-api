<?php

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
