<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $ordenador->marca }} - {{ $ordenador->modelo }}</h2>

        <div class="border-t pt-4">
            <p class="text-gray-600"><span class="font-semibold">Marca:</span> {{ $ordenador->marca }}</p>
            <p class="text-gray-600"><span class="font-semibold">Modelo:</span> {{ $ordenador->modelo }}</p>
            <p class="text-gray-600"><span class="font-semibold">Aula:</span> {{ $ordenador->aula->nombre }}</p>
        </div>

        @foreach ($ordenador->dispositivos as $dispositivo)
            <p>{{ $dispositivo->nombre }}</p>
        @endforeach
    </div>

    <div class="w-4/12 mx-auto">
        <form action="{{ route('ordenadores.cambiar', $ordenador) }}" method="post">
            @csrf
            <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-4" for="cambio">Ubicacion actual</x-input-label>
            <x-text-input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="origen_id" type="text" id="origen_id" :value="$ordenador->aula->nombre" disabled />

            <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-4"
                for="cambio">Cambiar a:</x-input-label>
            <select class="form-select mt-1 block w-full mt-4" name="destino_id" id="destino_id">
                <option value="" disabled selected>Selecciona un Aula</option>
                @foreach ($aulas as $aula)
                    <option value="{{ $aula->id }}">{{ $aula->nombre }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('aula_id')" class="mt-2" />
            <x-primary-button>Cambiar</x-primary-button>
        </form>
    </div>

    <!-- Tabla para los cambios -->
    <div class="overflow-x-auto mt-6 w-4/12 mx-auto">
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">Origen</th>
                    <th class="px-4 py-2 text-left border-b">Destino</th>
                    <th class="px-4 py-2 text-left border-b">Fecha de Cambio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cambios as $cambio)
                    <tr>
                        <td class="px-4 py-2 border-b">
                            {{ \App\Models\Aula::find($cambio->origen_id)->nombre }}
                        </td>

                        <td class="px-4 py-2 border-b">
                            {{ \App\Models\Aula::find($cambio->destino_id)->nombre }}
                        </td>
                        <td class="px-4 py-2 border-b">{{ $cambio->created_at }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
            <livewire:borrar-registros :ordenadorId="$ordenador->id" />
    </div>

</x-app-layout>
