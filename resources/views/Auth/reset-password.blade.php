<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Nueva Contraseña</title>
</head>
<body class="bg-slate-900 h-screen flex items-center justify-center p-4">
    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-emerald-400 to-teal-500"></div>

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Crea tu nueva clave</h1>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" class="w-full border-b-2 border-slate-200 py-2 focus:border-indigo-500 outline-none" required readonly>
                @error('email') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Nueva Contraseña</label>
                <input type="password" name="password" class="w-full border-b-2 border-slate-200 py-2 focus:border-indigo-500 outline-none" required>
                @error('password') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="w-full border-b-2 border-slate-200 py-2 focus:border-indigo-500 outline-none" required>
            </div>

            <button type="submit" class="w-full bg-slate-800 text-white py-3 rounded-xl font-bold hover:bg-slate-900 shadow-lg transition">
                Restablecer Contraseña
            </button>
        </form>
    </div>
</body>
</html>