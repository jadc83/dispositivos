<x-app-layout>

    <div class="flex justify-center items-center">
        <form method="POST" action="{{ route('productos.store') }}" class="max-w-sm mx-auto">
            @csrf
            <div class="mb-5">

                <x-input-label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Denominacion
                </x-input-label>
                <x-text-input name="nombre" type="text" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :value="old('nombre')" />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />

            </div>

            <div class="mb-5">

                <x-input-label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Precio
                </x-input-label>
                <x-text-input name="precio" type="text" id="precio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :value="old('precio')" />
                <x-input-error :messages="$errors->get('precio')" class="mt-2" />

            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Crear
            </button>

        </form>
    </div>

</x-app-layout>
