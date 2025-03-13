<?php
use App\Models\User;
use App\Htpp\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;



uses(RefreshDatabase::class); //Es para que se refresque la base de datos

// beforeEach(function () {
//     $this->user = User::factory()->create(); //factory es para buscar datos en la base de datos
// });

test('unauthenticated users cannot access the user list', function () { //test es para hacer pruebas
    $response = $this->get('/users'); //get es para obtener datos de la base de datos
    $response->assertRedirect('/login'); //assertRedirect es para que redireccione a la pagina de login
});

test('authenticated users can access the user list', function () {
    $this->user = User::factory()->create(); //factory es para buscar datos en la base de datos

    $this->actingAs($this->user); //ActingAs es para que se haga la autenticacion
    $response = $this->get('/users');
    $response->assertStatus(200); //assertStatus es para que muestre el estado de la pagina
});


test('users are listed with pagination', function () {
    $this->user = User::factory()->create(); //factory es para buscar datos en la base de datos

    $users = User::factory()->count(15)->create();   //factoy se usa para buscar datos en la base de datos
    $this->actingAs($this->user); //ActingAs es para que se haga la autenticacion

    $response = $this->get('/users');
    $response->assertStatus(200);
    $response->assertViewIs('users.index'); //assertViewIs es para que muestre la vista de los usuarios

    $users = User::orderBy('id')->take(10)->get(); //orderBy es para ordenar los datos de la base de datos
    foreach ($users as $user) {
        $response->assertSee($user->name);//assertSee es para que se vea el nombre del usuario
        $response->assertSee($user->last_name); //assertSee es para que se vea el apellido del usuario
        $response->assertSee($user->email); //assertSee es para que se vea el email del usuario
    }

    $user11 = User::orderBy('id')->skip(10)->first(); //skip es para saltar los primeros 10 datos
    if ($user11) {
        $response->assertDontSee($user11->name); //assertDontSee es para que no se vea el nombre del usuario11
    }
});


// test ('nombre', function () {

//     $response = $this->get('/users');

//     $response->assertStatus(200);
// });
