<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold">Listado de mascotas</h2>
                        <a href="{{ route('pets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear mascota</a>
                    </div>
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                                <th class="py-2 px-4 text-left">ID</th>
                                <th class="py-2 px-4 text-left">Nombre</th>
                                <th class="py-2 px-4 text-left">Tipo de animal</th>
                                <th class="py-2 px-4 text-left">Dueño</th>
                                <th class="py-2 px-4 text-left">Numero de telefono</th>
                                <th class="py-2 px-4 text-left">Creado el</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @foreach ($pets as $pet)
                                <tr class="border-b border-gray-300 hover:bg-gray-100">
                                    <td class="py-2 px-4">{{ $pet->id }} </td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('pets.show', ['pet' => $pet->id]) }}">{{ $pet->name }}</a>
                                    </td>
                                    <td class="py-2 px-4">{{ $pet->type->name }}</td>
                                    <td class="py-2 px-4">{{ $pet->user->name }}</td>
                                    <td class="py-2 px-4">{{ $pet->phone}}</td>
                                    <td class="py-2 px-4">{{ $pet->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div class="mt-4">
                        {{ $pets->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
