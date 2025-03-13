<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pet;
use App\Models\Type;

uses(RefreshDatabase::class);

test('unauthenticated users cannot access the animal list', function () {
    $response = $this->get('/pets');
    $response->assertRedirect('/login');
});

test('authenticated users can access the animal list', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    $response = $this->get('/pets');
    $response->assertStatus(200);
    $response->assertViewIs('pets.index'); 
});

test('pets are listed with pagination', function () {
    $user = User::factory()->create();

    Pet::factory()->count(15)->create(['user_id' => $user->id]);   
    $this->actingAs($user);

    $response = $this->get('/pets');
    $response->assertStatus(200);
    $response->assertViewIs('pets.index'); 


    $pets = Pet::orderBy('id')->take(10)->get(); 
    foreach ($pets as $pet) {
        $response->assertSee($pet->name);
        $response->assertSee(url('/pets/' . $pet->id));
        $response->assertSee($pet->type_id);
        $response->assertSee($pet->user_id);
        $response->assertSee($pet->phone);
    }


    $pet11 = Pet::orderBy('id')->skip(10)->first();
    if ($pet11) {
        $response->assertDontSee($pet11->name); 
    }
    $response->assertSee('Crear mascota');
    $response->assertSee(route('pets.create'));
});



test('unauthenticated users cannot access the pet creation form', function () {
    $response = $this->get('/pets/create');
    $response->assertRedirect('/login');
});

test('authenticated users can access the pet creation form', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    $response = $this->get('/pets/create');
    $response->assertStatus(200);
    $response->assertViewIs('pets.create'); 
});

test('a pet cannot be created with invalid data', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    $response = $this->post('/pets', [
        'name' => '',
        'type_id' => '',
        'user_id' => '',
        'phone' => '',
    ]);
    $response->assertSessionHasErrors([
        'name',
        'type_id',
        'user_id',
        'phone',
    ]);
    
});

test('pets can be created', function () {
    $user = User::factory()->create();
    $pet = Pet::factory()->make(['user_id' => $user->id]);

    $this->actingAs($user);
    $response = $this->from('/pets/create')->post('/pets', [
        'name' => 'Firulais',
        'type_id' => $pet->type_id,
        'user_id' => $pet->user_id,
        'phone' => '1234567890',
    ]);

    $response->assertRedirect('/pets');
    $this->assertDatabaseHas('pets', [
        'name' => 'Firulais',
        'type_id' => $pet->type_id,
        'user_id' => $pet->user_id,
        'phone' => '1234567890',
    ]);
});

//see show pet
test('unauthenticated users cannot access the pet show', function () {
    $response = $this->get("/pets/1");
    $response->assertRedirect('/login');
});

test('authenticated users can access the pet show', function () {
    $user = User::factory()->create();
    $pet = Pet::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);
    $response = $this->get('/pets/' . $pet->id);
    $response->assertStatus(200);
    $response->assertViewIs('pets.show');
    $response->assertSee($pet->name);
    $response->assertSee($pet->type_id);
    $response->assertSee($pet->user_id);
    $response->assertSee($pet->phone);

    $response->assertSee('Editar');
    $response->assertSee(url('/pets/' . $pet->id . '/edit'));
    $response->assertSee('Eliminar');
    $response->assertSee(url('/pets/' . $pet->id));
});

test('unauthenticated users cannot access the pet edit form', function () {
    $response = $this->get('/pets/1/edit');
    $response->assertRedirect('/login');
});

test('authenticated users can access the pet edit form', function () {
    $user = User::factory()->create();
    $pet = Pet::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);
    $response = $this->get('/pets/' . $pet->id . '/edit');
    $response->assertStatus(200);
    $response->assertViewIs('pets.edit');
    $response->assertSee($pet->name);
    $response->assertSee($pet->type_id);
    $response->assertSee($pet->user_id);
    $response->assertSee($pet->phone);

    $response->assertSee('Actualizar mascota');
    $response->assertSee(url('/pets/' . $pet->id));
});

test('a pet cannot be updated with invalid data', function () {
    $user = User::factory()->create();
    $pet = Pet::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);
    $response = $this->from('/pets/' . $pet->id . '/edit')->put('/pets/' . $pet->id, [
        'name' => '',
        'type_id' => '',
        'user_id' => '',
        'phone' => '',
    ]);
    $response->assertSessionHasErrors([
        'name',
        'type_id',
        'user_id',
        'phone',
    ]);
});

test('a pet can be updated', function () {
    $user = User::factory()->create();
    $pet = Pet::factory()->create([
        'user_id' => $user->id,   
        'name' => 'Firulais',      
    ]);

    
    $type = Type::first();  
    $pet->update([
        'type_id' => $type->id,  
        'user_id' => $user->id,  
        'phone' => '1234567890',
    ]);

    
    $this->actingAs($user); 
    $response = $this->from('/pets/' . $pet->id)->put('/pets/' . $pet->id, [
        'name' => 'Firulais',
        'type_id' => $type->id,    
        'user_id' => $user->id,    
        'phone' => '1234567890',
    ]);

    
    $this->assertDatabaseHas('pets', [
        'name' => 'Firulais',
        'type_id' => $type->id,    
        'user_id' => $user->id,    
        'phone' => '1234567890',
    ]);

    $response->assertRedirect('/pets');
});

