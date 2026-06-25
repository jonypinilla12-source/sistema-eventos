<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Nuevo Tipo de Evento</h2>
    <form action="{{ route('tipos.store') }}" method="POST">
        @csrf
        <label class="block mb-2">Nombre del Tipo:</label>
        <input type="text" name="nombre" class="w-full border p-2 rounded mb-4" placeholder="Ej: Bautizo" required>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('tipos.index') }}" class="text-gray-500 ml-2">Cancelar</a>
    </form>
</div>