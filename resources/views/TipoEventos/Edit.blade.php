<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Editar Tipo</h2>
    <form action="{{ route('tipos.update', $tipo->tipo_evento_id) }}" method="POST">
        @csrf
        @method('PUT')
        <label class="block mb-2">Nombre del Tipo:</label>
        <input type="text" name="nombre" value="{{ $tipo->nombre }}" class="w-full border p-2 rounded mb-4" required>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('tipos.index') }}" class="text-gray-500 ml-2">Cancelar</a>
    </form>
</div>