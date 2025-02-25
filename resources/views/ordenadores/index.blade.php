<x-app-layout>
    <div class="flex-col">

        <div class="mb-2 mx-auto w-3/12 mt-4">
            <form method="GET" action="{{ route('ordenadores.index') }}" class="mb-4">
                <input type="text" name="busqueda" value="{{ request('busqueda') }}" placeholder="Buscar ordenadores..."
                    class="form-input">
                <x-primary-button>Buscar</x-primary-button>
            </form>
        </div>

        <div>
            @if ($ordenadores->count())
                <table class="w-8/12 mx-auto mt-4 text-sm text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3 text-center">Nombre</th>
                            <th class="px-6 py-3 text-center">Modelo</th>
                            <th class="px-6 py-3 text-center">Dispositivos</th>
                            @can('admin')<th class="px-6 py-3">Acciones</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordenadores as $ordenador)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('ordenadores.show', $ordenador) }}">
                                        {{ $ordenador->nombre }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $ordenador->modelo }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $ordenador->dispositivos->count() }}
                                </td>

                                @can('admin')
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        <form class="inline-block mr-2" action="{{ route('ordenadores.edit', $ordenador) }}" method="GET">
                                            @csrf
                                            <x-primary-button>Editar</x-primary-button>
                                        </form>
                                        <form class="inline-block mr-2" action="{{ route('ordenadores.destroy', $ordenador) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <x-primary-button onclick="event.preventDefault(); if (confirm('¿Está seguro?')) this.closest('form').submit();">Borrar</x-primary-button>
                                        </form>
                                    </div>
                                </td>
                                @endcan

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center mt-4">No hay resultados</p>
            @endif
        </div>
    </div>
</x-app-layout>
