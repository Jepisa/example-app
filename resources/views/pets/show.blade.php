<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold">Informacion de la mascota</h2>
                        <a href="{{ route('pets.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Listado de mascotas</a>
                    </div>
                    <div class="mt-4">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                            <input type="text" name="name" id="name" value="{{ $pet->name }}"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="type_id" class="block text-gray-700 text-sm font-bold mb-2">Tipo de animal:</label>
                            <input type="text" name="type_id" id="type_id" value="{{ $pet->type->name }}"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Numero de telefono:</label>
                            <input type="text" name="phone" id="phone" value="{{ $pet->phone }}"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Dueño:</label>
                            <input type="text" name="user_id" id="user_id" value="{{ $pet->user->name }}"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('pets.edit', ['pet' => $pet->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar pais</a>
                        </div>
                        <div class="mt-4">
                            <form action="{{ route('pets.destroy', ['pet' => $pet->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar pais</button>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
        </div> 
    </div>
</x-app-layout>
