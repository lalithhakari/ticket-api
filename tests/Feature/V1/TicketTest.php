<?php

test('user can create a ticket', function () {
    $payload = [
        'title' => fake()->sentence(),
        'description' => fake()->paragraph(),
        'status' => 'A',
    ];

    $response = $this->actingAsUser()->postJson(route('api.v1.tickets.store'), $payload);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data'
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'title' => $payload['title'],
            'description' => $payload['description'],
            'status' => $payload['status'],
        ]);
});
