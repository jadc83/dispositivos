<x-app-layout>
    <div class="flex-col">


        <div class="flex">
            <div class="bg-black text-white w-1/12 text-center ml-auto mr-4 mt-4">
                @php
                    $total = 0;
                    foreach (session('carrito', []) as $item) {
                        $total += $item['cantidad'];
                    }
                @endphp
                <p>Tu carrito: {{ $total }}</p>
            </div>
        </div>

        <div>
            @if ($productos->count() > 0)
                <table class="w-8/12 mx-auto mt-4 text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 w-3/4">
                        <tr>
                            <th class="px-6 py-3 text-center">
                                <a href="{{ route('productos.index', [
                                                    'busqueda' => session('busqueda'),
                                                    'ordenar' => 'nombre',
                                                    'sentido' => session('ordenar') == 'nombre' && session('sentido') == 'asc' ? 'desc' : 'asc',]) }}">
                                    Nombre
                                    @if (session('ordenar') == 'nombre')
                                        {{ session('sentido') == 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>

                            <th class="px-6 py-3 text-center">
                                <a
                                    href="{{ route('productos.index', [
                                        'busqueda' => session('busqueda'),
                                        'ordenar' => 'precio',
                                        'sentido' => session('ordenar') == 'precio' && session('sentido') == 'asc' ? 'desc' : 'asc',
                                    ]) }}">
                                    Precio
                                    @if (session('ordenar') == 'precio')
                                        {{ session('sentido') == 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($productos as $producto)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{ route('productos.show', $producto) }}">{{ $producto->nombre }}</a>
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{ $producto->precio }}€
                                </td>
                                <td>
                                    <div class="flex justify-center">
                                        <form class="inline-block mr-2" action="{{ route('productos.add', $producto) }}" method="POST">
                                            @csrf
                                            <x-primary-button>Comprar</x-primary-button>
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
        <div class="flex justify-center w-full mt-4">
            <form action="{{ route('productos.create') }}" method="GET">
                <x-primary-button>Nuevo producto</x-primary-button>
            </form>
        </div>
</x-app-layout>
