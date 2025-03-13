<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'last_name' => 'Test Last Name',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    // seed last_name in database
    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'last_name' => 'Test Last Name',
        'email' => 'test@example.com',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
