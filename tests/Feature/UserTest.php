<?php



// test('user_list_returns_a_successful_response', function () {
//     //Crear 21 usuarios
//     User::factory()->create([
//         'name' => 'Jean Piere'
//     ]);
//     User::factory()->count(21)->create();
//     //Validar que se crearon en la base de datos
//     $this->assertDatabaseCount('users', 22);

//     $response = $this->get('/users');

//     $response->assertStatus(200);

//     $response->assertViewIs('users.index');

//     //Validar que se muestren en la vista
//     $response->assertSee('Jean Piere');

//     $response->assertSee('Listado de usuarios');

//     //Ver que solo se muestren 10 usuarios
//     $response->assertDontSee(User::skip(10)->first()->name);

//     //Ver que se muestre exactamente los 10 usuarios
//     $response->assertSee(User::first()->name); // Esto hace que pruebe que se muestre el primer usuario
//     $response->assertSee(User::skip(1)->first()->name); // Esto hace que pruebe que se muestre el segundo usuario
//     $response->assertSee(User::skip(2)->first()->name); // Esto hace que pruebe que se muestre el tercer usuario
//     $response->assertSee(User::skip(3)->first()->name); // Esto hace que pruebe que se muestre el cuarto usuario
//     $response->assertSee(User::find(10)->name); // Esto hace que pruebe que se muestre el decimo usuario
//     $response->assertDontSee(User::find(11)->name); // Esto hace que pruebe que no se muestre el decimo primer usuario
//     $response->assertDontSee(User::find(21)->name); // Esto hace que pruebe que no se muestre el vigesimo primer usuario

//     //Ver que se muestre la paginación:     /users?page=2 ...
//     $response->assertDontSee('/users?page=1');
//     $response->assertSee('/users?page=2');
//     $response->assertSee('/users?page=3');



// });

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('unauthenticated users cannot access the user list', function () {
    $response = $this->get('/users');
    $response->assertRedirect('/login');
});

test('users are listed with pagination', function () {
    User::factory()->count(15)->create();
    $this->actingAs($this->user);

    $response = $this->get('/users');
    $response->assertStatus(200);

    $users = User::orderBy('id')->take(10)->get();
    foreach ($users as $user) {
        $response->assertSee($user->name);
    }

    $user11 = User::orderBy('id')->skip(10)->first();
    if ($user11) {
        $response->assertDontSee($user11->name);
    }
});

test('a specific user can be viewed', function () {
    $this->actingAs($this->user);
    $response = $this->get("/users/{$this->user->id}");
    $response->assertStatus(200)
        ->assertSee($this->user->name);
});

test('the user creation form can be viewed', function () {
    $this->actingAs($this->user);
    $response = $this->get('/users/create');
    $response->assertStatus(200);
});

// see the validation rules in the store method of the UserController
test('a user cannot be created without a name', function () {
    $this->actingAs($this->user);
    
    $data = [
        'email' => 'ffasd',
        'password' => 'pass'
    ];

    $response = $this->get('/users/create');
    $response = $this->post('/users', $data);
    $response->assertRedirectToRoute('users.create');
    $response->assertSessionHasErrors('name');
});

test('a user cannot be created without an email', function () {
    $this->actingAs($this->user);
    
    $data = [
        'name' => 'Nombre',
        'password' => 'pass'
    ];

    $response = $this->get('/users/create');
    $response = $this->post('/users', $data);
    $response->assertRedirectToRoute('users.create');
    $response->assertSessionHasErrors('email');
});

test('a user cannot be created without a password', function () {
    $this->actingAs($this->user);
    
    $data = [
        'name' => 'Nombre',
        'email' => 'ffasd'
    ];
    $response = $this->get('/users/create');
    $response = $this->post('/users', $data);
    $response->assertRedirectToRoute('users.create');
    $response->assertSessionHasErrors('password');
});

test('a new user can be created', function () {
    $this->actingAs($this->user);
    
    $data = [
        'name' => 'Nuevo Usuario',
        'email' => 'nuevo@example.com',
        'password' => 'password123'
    ];

    $response = $this->post('/users', $data);
    $response->assertRedirectToRoute('users.index');
    $this->assertDatabaseHas('users', ['email' => 'nuevo@example.com']);
});

//email must be unique
test('a new user cannot be created with an existing email', function () {
    User::factory()->create(['email' => 'otroUser@example.com']);

    $this->actingAs($this->user);

    $data = [
        'name' => 'Nuevo Usuario',
        'email' => 'otroUser@example.com',
        'password' => 'password123'
    ];

    $response = $this->get('/users/create');
    $response = $this->post('/users', $data);
    $response->assertRedirectToRoute('users.create');
    $response->assertSessionHasErrors('email');
});

test('the user edit form can be viewed', function () {
    $this->actingAs($this->user);
    $response = $this->get("/users/{$this->user->id}/edit");
    $response->assertStatus(200);
});

test('a user cannot be updated without a name', function () {
    $this->actingAs($this->user);
    
    $data = [
        'email' => $this->user->email
    ];
    $response = $this->get("/users/{$this->user->id}/edit");
    $response = $this->put("/users/{$this->user->id}", $data);
    $response->assertRedirectToRoute('users.edit', $this->user->id);
    $response->assertSessionHasErrors('name');
});

test('a user cannot be updated without an email', function () {
    $this->actingAs($this->user);
    
    $data = [
        'name' => 'Nombre Actualizado'
    ];
    $response = $this->get("/users/{$this->user->id}/edit");
    $response = $this->put("/users/{$this->user->id}", $data);
    $response->assertRedirectToRoute('users.edit', $this->user->id);
    $response->assertSessionHasErrors('email');
});

// user email must be unique
test('a user cannot be updated with an existing email', function () {
    
    User::factory()->create(['email' => 'otroUserœ@example.com']);

    $this->actingAs($this->user);
    
    $data = [
        'name' => 'Nombre Actualizado',
        'email' => 'otroUserœ@example.com'
    ];

    $response = $this->get("/users/{$this->user->id}/edit");
    $response = $this->put("/users/{$this->user->id}", $data);
    $response->assertRedirectToRoute('users.edit', $this->user->id);
    $response->assertSessionHasErrors('email');
});


test('a user can be updated', function () {
    $this->actingAs($this->user);
    
    $data = [
        'name' => 'Nombre Actualizado',
        'email' => $this->user->email
    ];
    $response = $this->put("/users/{$this->user->id}", $data);
    
    $response->assertRedirectToRoute('users.index');
    $this->assertDatabaseHas('users', ['id' => $this->user->id, 'name' => 'Nombre Actualizado']);
});

test('a user can be deleted', function () {
    $this->actingAs($this->user);
    
    $response = $this->delete("/users/{$this->user->id}");
    $response->assertRedirectToRoute('users.index');
    $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
});

// test('non-admin users cannot create users', function () {
//     $this->actingAs($this->user);
    
//     $data = [
//         'name' => 'Usuario Bloqueado',
//         'email' => 'bloqueado@example.com',
//         'password' => 'password123',
//         'is_admin' => false,
//     ];

//     $response = $this->post('/users', $data);
//     $response->assertStatus(403);
// });
