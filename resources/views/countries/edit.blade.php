<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Countries Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold">Editar pais</h2>
                        <a href="{{ route('countries.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Listado de paises</a>
                    </div>
                    <div class="mt-4">
                        <form action="{{ route('countries.update', ['country' => $country->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                                <input type="text" name="name" id="name" value="{{ $country->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                            </div>
                            <div class="mb-4">
                                <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Codigo:</label>
                                <input type="text" name="code" id="code" value="{{ $country->code }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                            </div>
                            <div class="mb-4">
                                <label for="phone_code" class="block text-gray-700 text-sm font-bold mb-2">Codigo de telefono:</label>
                                <input type="text" name="phone_code" id="phone_code"  value="{{ $country->phone_code }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"> 
                            </div>
                            <div class="mb-4">
                                <label for="currency" class="block text-gray-700 text-sm font-bold mb-2">Moneda:</label>
                                <input type="text" name="currency" id="currency" value="{{ $country->currency }}" class="form-input rounded-md shadow-sm mt-1 block w-full" >
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar pais</button>
                        </form>
                    </div>
                    
                    <div class="mt-4">
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
