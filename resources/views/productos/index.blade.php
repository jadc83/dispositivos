<x-app-layout>
    <div class="flex-col">
        <!-- Filtros y búsqueda -->
        <div class="mb-2 mx-auto w-8/12 mt-4">
            <form method="GET" action="{{ route('productos.index') }}" class="mb-4 flex items-center gap-4">
                <!-- Buscar -->
                <div class="flex flex-col">
                    <label for="busqueda" class="text-sm">Buscar</label>
                    <input type="text" name="busqueda" id="busqueda" value="{{ request('busqueda') }}"
                        placeholder="Buscar..." class="form-input w-32">
                </div>

                <!-- Ordenar -->
                <div class="flex flex-col">
                    <label for="orden" class="text-sm">Ordenar</label>
                    <select name="orden" id="orden" class="form-input w-52" onchange="this.form.submit()">
                        <option value="">Ordenar</option>
                        <option value="nombre_asc" {{ request('orden') == 'nombre_asc' ? 'selected' : '' }}>Nombre (A-Z)
                        </option>
                        <option value="nombre_desc" {{ request('orden') == 'nombre_desc' ? 'selected' : '' }}>Nombre
                            (Z-A)</option>
                        <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio
                            (Ascendente)</option>
                        <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio
                            (Descendente)</option>
                    </select>
                </div>

                <!-- Filtrar por precio -->
                <div class="flex flex-col">
                    <label for="precio" class="text-sm">Precio</label>
                    <div class="flex gap-2">
                        <input type="number" name="precio_min" value="{{ request('precio_min') }}" placeholder="Min"
                            class="form-input w-24" min="0" onchange="this.form.submit()">
                        <input type="number" name="precio_max" value="{{ request('precio_max') }}" placeholder="Max"
                            class="form-input w-24" min="0" onchange="this.form.submit()">
                    </div>
                </div>

                <!-- Botón de búsqueda -->
                <div class="flex items-end justify-end w-full">
                    <x-primary-button>Buscar</x-primary-button>
                </div>
            </form>
        </div>

        <!-- Carrito -->
        <div class="flex">
            <div class="bg-black text-white w-1/12 text-center ml-auto mr-4 mt-4 p-2 rounded">
                @php
                    $total = collect(session('carrito', []))->sum('cantidad');
                @endphp
                <p>Tu carrito: {{ $total }}</p>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div>
            @if ($productos->count() > 0)
                <table class="w-8/12 mx-auto mt-4 text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3 text-center">Foto</th>
                            <th class="px-6 py-3 text-center">Nombre</th>
                            <th class="px-6 py-3 text-center">Precio</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($productos as $producto)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <!-- Imagen del producto -->
                                <td class="px-6 py-4 text-center">
                                    @if ($producto->imagen)
                                    <img class="mx-auto" src="{{ asset($producto->imagen) }}" alt="Foto de producto" style="max-width: 200px; height: auto;">

                                    @else
                                        <p class="text-gray-500">Sin imagen</p>
                                    @endif
                                </td>

                                <!-- Nombre del producto -->
                                <td class="px-6 py-4 text-center font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('productos.show', $producto) }}">{{ $producto->nombre }}</a>
                                </td>

                                <!-- Precio -->
                                <td class="px-6 py-4 text-center">
                                    {{ number_format($producto->precio, 2) }}€
                                </td>

                                <!-- Botón comprar -->
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('productos.add', $producto) }}" method="POST">
                                        @csrf
                                        <x-primary-button>Comprar</x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-gray-500 mt-4">No hay productos disponibles.</p>
            @endif
        </div>

        <!-- Paginación -->
        <div class="flex justify-center w-full mt-2 mb-2">
            {{ $productos->links() }}
        </div>

        <!-- Botón nuevo producto -->
        <div class="flex justify-center w-full mt-4">
            <form action="{{ route('productos.create') }}" method="GET">
                <x-primary-button>Nuevo producto</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
