<?php

use App\Models\User;

test('user can create a ticket', function () {
    $user = User::factory()->create();
    $payload = [
        'data' => [
            'attributes' => [
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
            ],
            'relationships' => [
                'data' => [
                    'author' => [
                        'id' => $user->id,
                    ],
                ],
            ],
        ],
    ];

    $response = actingAsUser($user)->postJson(route('api.v1.tickets.store'), $payload);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'ticket',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'title' => $payload['data']['attributes']['title'],
            'description' => $payload['data']['attributes']['description'],
            'status' => $payload['data']['attributes']['status'],
        ]);
});
