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
                'token',
                'user',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
});
