<x-app-layout>

    <div class="flex justify-center items-center">
        <form method="POST" action="{{ route('ordenadores.update', $ordenador) }}" class="max-w-sm mx-auto">
            @method('PUT')
            @csrf

            <!-- Campo Marca -->
            <div class="mb-5">
                <x-input-label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Marca
                </x-input-label>
                <x-text-input
                    name="nombre"
                    type="text"
                    id="nombre"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('nombre', $ordenador->nombre) }}" />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <!-- Campo Modelo -->
            <div class="mb-5">
                <x-input-label for="modelo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Modelo
                </x-input-label>
                <x-text-input
                    name="modelo"
                    type="text"
                    id="modelo"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('modelo', $ordenador->modelo) }}" />
                <x-input-error :messages="$errors->get('modelo')" class="mt-2" />
            </div>

            <!-- Campo Aula -->
            <div class="mb-5">
                <x-input-label for="aula_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Aula
                </x-input-label>
                <select class="form-select mt-1 block w-full" name="aula_id" id="aula_id">
                    <option value="">Seleccione un aula</option>
                    @foreach ($aulas as $aula)
                        <option value="{{ $aula->id }}" {{ old('aula_id', $ordenador->aula_id) == $aula->id ? 'selected' : '' }}>
                            {{ $aula->nombre }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('aula_id')" class="mt-2" />
            </div>

            <!-- Botón de envío -->
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Editar
            </button>

        </form>
    </div>

</x-app-layout>
