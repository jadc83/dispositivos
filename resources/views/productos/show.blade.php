<x-app-layout>
    {{$producto->nombre}}
    {{$producto->precio}}
    <form action="{{ route('productos.edit', $producto) }}" method="GET" class="inline-block">
        <button type="submit"
            class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md">
            Editar
        </button>
    </form>

    <form method="POST" action="{{ route('productos.destroy', $producto) }}" class="inline-block">
        @method('DELETE')
        @csrf
        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md"
            onclick="return confirm('¿Está seguro?')">
            Eliminar
        </button>
    </form>
</x-app-layout>
