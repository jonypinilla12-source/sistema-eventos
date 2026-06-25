@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('eventos.index') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Volver a Eventos
        </a>
        <h1 class="text-3xl font-bold text-slate-800 mt-3">Galería de Fotos</h1>
        <p class="text-slate-500 italic">{{ $evento->nombre_evento }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <form action="{{ route('eventos.galeria.store', $evento->evento_id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border shadow-sm sticky top-6">
                @csrf
                <h2 class="text-lg font-bold text-slate-800 mb-4">Nueva Imagen</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Título</label>
                        <input type="text" name="titulo" class="w-full border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-indigo-500 outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Descripción</label>
                        <textarea name="descripcion" rows="2" class="w-full border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-indigo-500 outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Archivo de Imagen</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors cursor-pointer relative">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-slate-400 text-2xl"></i>
                                <div class="flex text-sm text-slate-600">
                                    <span class="text-indigo-600 font-medium">Sube un archivo</span>
                                </div>
                                <p class="text-xs text-slate-400">PNG, JPG hasta 10MB</p>
                            </div>
                            <input type="file" name="foto" class="absolute inset-0 opacity-0 cursor-pointer" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                        Subir a la Galería
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($evento->fotosGaleria as $foto)
                <div class="bg-white rounded-2xl overflow-hidden border shadow-sm group relative">
                    <img src="{{ asset('storage/' . $foto->url_recurso) }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="font-bold text-slate-800 text-sm truncate">{{ $foto->titulo ?? 'Sin título' }}</h4>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $foto->descripcion }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                    <i class="fas fa-images text-slate-300 text-4xl mb-4"></i>
                    <p class="text-slate-500">No hay fotos en esta galería aún.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection