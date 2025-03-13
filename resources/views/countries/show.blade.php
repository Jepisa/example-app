<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Country') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="p-6 text-gray-900">
                        //Mostrar los datos de $country
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-semibold">Información del país</h2>
                            <a href="{{ route('countries.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Listado de paises</a>
                        </div>
                        <div class="mt-4">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                                <input type="text" name="name" id="name" value="{{ $country->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Codigo:</label>
                                <input type="text" name="code" id="code" value="{{ $country->code }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>  
                            </div>
                            <div class="mb-4">
                                <label for="phone_code" class="block text-gray-700 text-sm font-bold mb-2">Codigo de telefono:</label>
                                <input type="text" name="phone_code" id="phone_code" value="{{ $country->phone_code }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="currency" class="block text-gray-700 text-sm font-bold mb-2">Moneda:</label>
                                <input type="text" name="currency" id="currency" value="{{ $country->currency }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('countries.edit', ['country' => $country->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar pais</a>
                        </div>
                        <div class="mt-4">
                            <form action="{{ route('countries.destroy', ['country' => $country->id]) }}" method="POST">
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