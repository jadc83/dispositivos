<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Carrito de Compras</h1>

        @if (session('success'))
            <p class="text-green-600">{{ session('success') }}</p>
        @endif

        @if (!empty($carrito) && count($carrito) > 0)
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Producto</th>
                        <th class="border p-2">Precio</th>
                        <th class="border p-2">Cantidad</th>
                        <th class="border p-2">Total</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carrito as $item)
                        <tr class="border">
                            <td class="border p-2">{{ $item['nombre'] }}</td>
                            <td class="border p-2">${{ number_format($item['precio'], 2) }}</td>
                            <td class="border p-2">{{ $item['cantidad'] }}</td>
                            <td class="border p-2">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                            <td class="border p-2">
                                <form action="{{ route('productos.add', $item['id']) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-2 py-1">➕</button>
                                </form>
                                <form action="{{ route('productos.resta', $item['id']) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1">➖</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="m-4 h-6 w-28 bg-red-600 text-white text-center rounded-lg">
                <form action="{{ route('productos.pagar') }}" method="POST">
                    @csrf
                    <button type="submit">
                        Pagar
                    </button>
                </form>
            </div>

            <div class="m-4 h-6 w-28 bg-red-600 text-white text-center rounded-lg">
                <form action="{{ route('productos.vaciar') }}" method="POST">
                    @csrf
                    <button type="submit">
                        Vaciar carrito
                    </button>
                </form>
            </div>
        @else
            <p class="text-gray-500">El carrito está vacío.</p>
        @endif
    </div>
</x-app-layout>
