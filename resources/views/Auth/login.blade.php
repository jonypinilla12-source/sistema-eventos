<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Login - Sistema Eventos</title>
</head>
<body class="bg-slate-900 h-screen flex items-center justify-center p-4">
    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md relative overflow-hidden">
        
        {{-- Decoración sutil de fondo --}}
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

        <div class="text-center mb-8">
            <div class="bg-indigo-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-lock text-2xl text-indigo-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-slate-800">Bienvenido</h1>
            <p class="text-slate-500 mt-1">Ingresa tus credenciales para continuar</p>
        </div>
        
        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="far fa-envelope text-slate-400"></i>
                    </div>
                    <input type="email" name="email" class="w-full pl-10 border-b-2 border-slate-200 py-2 focus:border-indigo-500 outline-none transition text-slate-700 bg-transparent" placeholder="tu@correo.com" required>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-sm font-bold text-slate-700">Contraseña</label>
                    {{-- ENLACE DE RECUPERACIÓN DE CONTRASEÑA --}}
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-key text-slate-400"></i>
                    </div>
                    <input type="password" name="password" class="w-full pl-10 border-b-2 border-slate-200 py-2 focus:border-indigo-500 outline-none transition text-slate-700 bg-transparent" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition transform hover:-translate-y-0.5 mt-4">
                Entrar al Panel
            </button>
        </form>
    </div>
</body>
</html>