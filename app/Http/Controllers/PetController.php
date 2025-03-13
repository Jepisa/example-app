<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Requests\PetStoreRequest;
use App\Http\Requests\PetUpdateRequest;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with('user', 'type')->paginate(10);

        return view('pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $types = Type::all();
        return view('pets.create', compact('users', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PetStoreRequest $request)
    {
        Pet::create($request->validated());

        return redirect()->route('pets.index')->with('success', 'Mascota creada.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        $pet = Pet::findOrfail($pet->id);

        return view('pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        $users = User::all();
        $types = Type::all();
        return view('pets.edit', compact('pet', 'users', 'types'));
     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PetUpdateRequest $request, Pet $pet)
    {
        $pet = Pet::findOrFail($pet->id);
        $pet->update($request->all());

        return redirect()->route('pets.index')->with('success', 'Datos de la mascota actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $pet = Pet::findOrFail($pet->id);
        $pet->delete();

        return redirect()->route('pets.index');
    }
}
