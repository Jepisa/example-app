<?php

use App\Models\User;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('unauthenticated countries cannot access the country list', function () {
    $response = $this->get('/countries');
    $response->assertRedirect('/login');
});

test('authenticated countries can access the country list', function () {
    $this->user = User::factory()->create();
    
    $this->actingAs($this->user);
    $response = $this->get('/countries');
    $response->assertStatus(200);
    $response->assertViewIs('countries.index'); 
});

test('countries are listed with pagination', function () {
    $this->user = User::factory()->create(); 

    Country::factory()->count(15)->create();   
    $this->actingAs($this->user); 

    $response = $this->get('/countries');
    $response->assertStatus(200);
    $response->assertViewIs('countries.index'); 

    $countries = Country::orderBy('id')->take(10)->get(); 
    foreach ($countries as $country) {
        $response->assertSee($country->name);
        $response->assertSee(url('/countries/' . $country->id));
        $response->assertSee($country->code);
        $response->assertSee($country->phone_code);
        $response->assertSee($country->currency);
    }

    $country11 = Country::orderBy('id')->skip(10)->first();
    if ($country11) {
        $response->assertDontSee($country11->name); 
    }
    $response->assertSee('Crear pais');
    $response->assertSee(route('countries.create'));
});

test('unauthenticated users cannot access the country creation form', function () {
    $response = $this->get('/countries/create');
    $response->assertRedirect('/login');
});

test('authenticated users can access the country creation form', function () {
    $this->user = User::factory()->create();
    
    $this->actingAs($this->user);
    $response = $this->get('/countries/create');
    $response->assertStatus(200);
    $response->assertViewIs('countries.create');
});

test('a country cannot be created with invalid data', function () {
    $this->user = User::factory()->create();
    
    $this->actingAs($this->user);
    $response = $this->post('/countries', [
        'name' => '',
        'code' => '',
        'phone_code' => '',
        'currency' => '',
    ]);
    $response->assertSessionHasErrors([
        'name',
        'code',
        'phone_code',
        'currency',
    ]);
});

test('a country can be created', function () {
    $this->user = User::factory()->create();
    
    $this->actingAs($this->user);
    $response = $this->post('/countries', [
        'name' => 'Argentina',
        'code' => 'AR',
        'phone_code' => '54',
        'currency' => 'ARS',
    ]);

    $this->assertDatabaseHas('countries', [
        'name' => 'Argentina',
        'code' => 'AR',
        'phone_code' => '54',
        'currency' => 'ARS',
    ]);
    $response->assertRedirect('/countries');
});


//see show country

test('unauthenticated users cannot access the country show', function () {
    $response = $this->get('/countries/1');
    $response->assertRedirect('/login');
});

test('authenticated users can access the country show', function () {
    $this->user = User::factory()->create();
    $country = Country::factory()->create();
    
    $this->actingAs($this->user);
    $response = $this->get('/countries/' . $country->id);
    $response->assertStatus(200);
    $response->assertViewIs('countries.show');
    $response->assertSee($country->name);
    $response->assertSee($country->code);
    $response->assertSee($country->phone_code);
    $response->assertSee($country->currency);

    $response->assertSee('Editar pais');
    $response->assertSee(url('/countries/' . $country->id . '/edit'));
    $response->assertSee('Eliminar pais');
    $response->assertSee(url('/countries/' . $country->id));
});

test('unauthenticated users cannot access the country edit form', function () {
    $response = $this->get('/countries/1/edit');
    $response->assertRedirect('/login');
});

test('authenticated users can access the country edit form', function () {
    $this->user = User::factory()->create();
    $country = Country::factory()->create();
    
    $this->actingAs($this->user);
    $response = $this->get('/countries/' . $country->id . '/edit');
    $response->assertStatus(200);
    $response->assertViewIs('countries.edit');
    $response->assertSee($country->name);
    $response->assertSee($country->code);
    $response->assertSee($country->phone_code);
    $response->assertSee($country->currency);

    $response->assertSee('Actualizar pais');
    $response->assertSee(url('/countries/' . $country->id));
});


test('a country cannot be updated with invalid data', function () {
    $this->user = User::factory()->create();
    $country = Country::factory()->create();
    
    $this->actingAs($this->user);
    $response = $this->put('/countries/' . $country->id, [
        'name' => '',
        'code' => '',
        'phone_code' => '',
        'currency' => '',
    ]);
    $response->assertSessionHasErrors([
        'name',
        'code',
        'phone_code',
        'currency',
    ]);
});

test('a country can be updated', function () {
    $this->user = User::factory()->create();
    $country = Country::factory()->create(
        [
            'name' => 'Brasil',
            'code' => 'BR',
            'phone_code' => '55',
            'currency' => 'REAL',
        ]
    );
    
    $this->actingAs($this->user);
    $response = $this->put('/countries/' . $country->id, [
        'name' => 'Brasil',
        'code' => 'BR',
        'phone_code' => '55',
        'currency' => 'BRL',
    ]);

    $this->assertDatabaseHas('countries', [
        'name' => 'Brasil',
        'code' => 'BR',
        'phone_code' => '55',
        'currency' => 'BRL',
    ]);
    $response->assertRedirect('/countries');
});

