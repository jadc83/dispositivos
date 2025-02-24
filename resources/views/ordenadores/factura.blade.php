<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-center mb-4">Factura</h2>

        <div class="mb-4 border-b pb-2">
            <p class="text-gray-700"><strong>Número de Tarjeta:</strong> {{ $ticket->tarjeta }}</p>
            <p class="text-gray-700"><strong>Fecha:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-2 text-left">Cantidad</th>
                    <th class="p-2 text-left">Producto</th>
                    <th class="p-2 text-left">Precio Unitario</th>
                    <th class="p-2 text-left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($ticket->productos as $producto)
                    @php
                        $subtotal = $producto->pivot->cantidad * $producto->precio;
                        $total += $subtotal;
                    @endphp
                    <tr class="border-b">
                        <td class="p-2">{{ $producto->pivot->cantidad }}</td>
                        <td class="p-2">{{ $producto->nombre }}</td>
                        <td class="p-2">€{{ number_format($producto->precio, 2) }}</td>
                        <td class="p-2">€{{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-right">
            <p class="text-xl font-semibold">Total: €{{ number_format($total, 2) }}</p>
        </div>
    </div>
</x-app-layout>
