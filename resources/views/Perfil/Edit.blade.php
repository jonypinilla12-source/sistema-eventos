@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Mi Perfil</h1>
        <p class="text-slate-500 text-sm">Administra tu información y seguridad de la cuenta.</p>
    </div>

    @if(session('exito'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm">
            <i class="fas fa-check-circle mr-3 text-emerald-500"></i>
            {{ session('exito') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        {{-- Encabezado del usuario --}}
        <div class="bg-slate-50 border-b border-slate-100 px-8 py-6 flex items-center gap-4">
            <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-2xl font-bold shadow-inner">
                {{ substr($usuario->nombre, 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $usuario->nombre }}</h2>
                <p class="text-slate-500 text-sm">{{ $usuario->email }}</p>
                <span class="inline-block mt-1 bg-indigo-100 text-indigo-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">
                    {{ $usuario->rol_id == 1 ? 'Administrador' : 'Anfitrión' }}
                </span>
            </div>
        </div>

        {{-- Formulario de Cambio de Contraseña --}}
        <div class="p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <i class="fas fa-lock text-indigo-500 mr-2"></i> Cambiar Contraseña
            </h3>

            <form action="{{ route('perfil.password.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Contraseña Actual</label>
                    <input type="password" name="current_password" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition @error('current_password') border-rose-300 bg-rose-50 @enderror" required placeholder="••••••••">
                    @error('current_password')
                        <p class="text-rose-500 text-xs mt-1 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nueva Contraseña</label>
                        <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition @error('password') border-rose-300 bg-rose-50 @enderror" required placeholder="Mínimo 8 caracteres">
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition" required placeholder="Repite la nueva contraseña">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center">
                        <i class="fas fa-save mr-2"></i> Actualizar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection