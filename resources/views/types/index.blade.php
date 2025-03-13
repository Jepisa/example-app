<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Types') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                                <th class="py-2 px-4 text-left">ID</th>
                                <th class="py-2 px-4 text-left">Nombre</th>
                                <th class="py-2 px-4 text-left">Descripcion</th>
                                <th class="py-2 px-4 text-left">Creado el</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @foreach ($types as $type)  
                                <tr class="border-b border-gray-300 hover:bg-gray-100">
                                    <td class="py-2 px-4">
                                        <a href="#">{{ $type->id }}</a>
                                    </td>
                                    <td class="py-2 px-4">{{ $type->name }}</td>
                                    <td class="py-2 px-4">{{ $type->description }}</td>
                                    <td class="py-2 px-4">{{ $type->created_at->format('d/m/Y') }}</td>
                                </tr>
                                    
                            @endforeach 
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div class="mt-4">
                        {{ $types->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
