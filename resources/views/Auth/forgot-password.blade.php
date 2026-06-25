<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Recuperar Contraseña</title>
</head>
<body class="bg-slate-900 h-screen flex items-center justify-center p-4">
    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Recuperar Acceso</h1>
            <p class="text-slate-500 mt-2 text-sm">Ingresa tu correo y te enviaremos un enlace seguro para crear una nueva contraseña.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-emerald-600 bg-emerald-50 p-3 rounded-lg border border-emerald-200 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Tu Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="far fa-envelope text-slate-400"></i>
                    </div>
                    <input type="email" name="email" class="w-full pl-10 border-b-2 border-slate-200 py-2 focus:border-indigo-500 outline-none transition" required autofocus>
                </div>
                @error('email') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition">
                Enviar enlace de recuperación
            </button>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-500 hover:text-indigo-600">Volver al login</a>
            </div>
        </form>
    </div>
</body>
</html>