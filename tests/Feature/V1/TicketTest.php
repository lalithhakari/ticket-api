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

    $response = actingAsApiUser($user)->postJson(route('api.v1.tickets.store'), $payload);

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

test('user can update a ticket', function () {
    $user = User::factory()->create();
    $ticket = $user->tickets()->create([
        'title' => fake()->sentence(),
        'description' => fake()->paragraph(),
        'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
    ]);

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

    $response = actingAsApiUser($user)->patchJson(route('api.v1.tickets.update', $ticket), $payload);

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

test('user can replace a ticket', function () {
    $user = User::factory()->create();
    $ticket = $user->tickets()->create([
        'title' => fake()->sentence(),
        'description' => fake()->paragraph(),
        'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
    ]);

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

    $response = actingAsApiUser($user)->putJson(route('api.v1.tickets.replace', $ticket), $payload);

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

test('user can delete a ticket', function () {
    $user = User::factory()->create();
    $ticket = $user->tickets()->create([
        'title' => fake()->sentence(),
        'description' => fake()->paragraph(),
        'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
    ]);

    $response = actingAsApiUser($user)->deleteJson(route('api.v1.tickets.destroy', $ticket));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message'
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Ticket deleted successfully',
        ]);
});

test('user can view a ticket', function () {
    $user = User::factory()->create();
    $ticket = $user->tickets()->create([
        'title' => fake()->sentence(),
        'description' => fake()->paragraph(),
        'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
    ]);

    $response = actingAsApiUser($user)->getJson(route('api.v1.tickets.show', $ticket));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'ticket',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'title' => $ticket->title,
            'description' => $ticket->description,
            'status' => $ticket->status,
        ]);
});

test('user can view all tickets', function () {
    $user = User::factory()->create();
    $tickets = $user->tickets()->createMany([
        [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
        ],
        [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
        ],
    ]);

    $response = actingAsApiUser($user)->getJson(route('api.v1.tickets.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'tickets'
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
        ]);
});

test('user can view tickets with status filters', function () {
    $user = User::factory()->create();
    $tickets = $user->tickets()->createMany([
        [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
        ],
        [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
        ],
    ]);

    $response = actingAsApiUser($user)->getJson(route('api.v1.tickets.index'), [
        'filter[status]' => $tickets[0]->status,
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'tickets'
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'title' => $tickets[0]->title,
        ]);
});

test('user can view tickets with include filters', function () {
    $user = User::factory()->create();
    $tickets = $user->tickets()->createMany([
        [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
        ],
        [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['A', 'H', 'C', 'X']),
        ],
    ]);

    $response = actingAsApiUser($user)->getJson(route('api.v1.tickets.index'), [
        'include' => 'author',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'tickets' => [
                    '*' => [
                        'includes' => [
                            '*' => [
                                'type' => 'user',
                                'id' => $user->id,
                            ]
                        ]
                    ]
                ],
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
            'title' => $tickets[0]->title,
            'title' => $tickets[1]->title,
        ]);
});
