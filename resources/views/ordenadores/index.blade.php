<x-app-layout>
    <div class="flex-col">
        <div>
            @if ($ordenadores->count() > 0)
                <table class="w-8/12 mx-auto mt-4 text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 w-3/4">
                        <tr>
                            <th class="px-6 py-3 text-center">Nombre</th>
                            <th class="px-6 py-3 text-center">Modelo</th>
                            <th class="px-6 py-3 text-center">Dispositivos</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ordenadores as $ordenador)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{ route('ordenadores.show', $ordenador) }}">{{ $ordenador->marca }}</a>
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{ $ordenador->modelo }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $ordenador->dispositivos->count() }}
                                </td>
                                <td>
                                    <div class="flex justify-center">
                                            <form action="{{ route('ordenadores.edit', $ordenador) }}" method="GET" class="inline-block mr-2">
                                                @csrf
                                                <x-primary-button>Editar</x-primary-button>
                                            </form>
                                            <form action="{{ route('ordenadores.destroy', $ordenador) }}" method="POST" class="inline-block mr-2">
                                                @csrf
                                                @method('delete')
                                                <x-primary-button>Borrar</x-primary-button>
                                            </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay resultados</p>
            @endif
        </div>
    </div>

</x-app-layout>
