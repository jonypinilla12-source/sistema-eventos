@extends('layouts.app')

@section('content')

{{-- ========================================================= --}}
{{-- PANEL DEL ADMINISTRADOR (rol_id == 1)                     --}}
{{-- ========================================================= --}}
@if(auth()->user()->rol_id == 1)
    <div class="space-y-8 animate-fade-in">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">¡Bienvenido, {{ auth()->user()->nombre }}!</h2>
                <p class="text-slate-500 mt-2">Gestiona tus eventos, invitados y tipos de celebraciones desde aquí.</p>
            </div>
            <div class="hidden md:block">
                <img src="https://illustrations.popsy.co/slate/calendar.svg" class="h-32" alt="Ilustración">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('tipos.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="flex items-center space-x-4">
                    <div class="bg-indigo-100 text-indigo-600 p-4 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i class="fas fa-tags text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-700">Tipos de Eventos</h3>
                        <p class="text-sm text-slate-400">Configura las categorías</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('roles.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="flex items-center space-x-4">
                    <div class="bg-purple-100 text-purple-600 p-4 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <i class="fas fa-user-shield text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-700">Roles del Sistema</h3>
                        <p class="text-slate-400 text-sm">Permisos y niveles</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('eventos.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="flex items-center space-x-4">
                    <div class="bg-emerald-100 text-emerald-600 p-4 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-700">Eventos Activos</h3>
                        <p class="text-sm text-slate-400">Administra las celebraciones</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

{{-- ========================================================= --}}
{{-- PANEL DEL ANFITRIÓN (Cualquier otro rol)                  --}}
{{-- ========================================================= --}}
@else
    <div class="space-y-10 animate-fade-in">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">¡Hola, {{ auth()->user()->nombre }}!</h2>
                <p class="text-slate-500 mt-2">Aquí puedes gestionar tus celebraciones actuales o adquirir un nuevo plan.</p>
                <a href="{{ route('eventos.index') }}" class="inline-block mt-4 bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition shadow-md">
                    Ir a Mis Eventos <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-glass-cheers text-6xl text-indigo-200"></i>
            </div>
        </div>

        <div>
            <h3 class="text-xl font-bold text-slate-800 mb-6"><i class="fas fa-plus-circle text-indigo-500 mr-2"></i> Contratar un Nuevo Evento</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:border-indigo-300 transition-all flex flex-col group">
                    <h4 class="text-lg font-bold text-slate-800">Memorial</h4>
                    <p class="text-slate-500 text-sm mb-4">Honra memorias con respeto.</p>
                    <p class="text-2xl font-black text-slate-800 mb-6">$10.000 <span class="text-sm font-normal text-slate-400">CLP</span></p>
                    <button onclick="abrirModalNuevoPlan('Memorial')" class="mt-auto w-full py-3 bg-slate-100 text-slate-700 font-bold rounded-xl group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">Adquirir Memorial</button>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:border-indigo-300 transition-all flex flex-col group">
                    <h4 class="text-lg font-bold text-slate-800">Corporativo</h4>
                    <p class="text-slate-500 text-sm mb-4">Eventos de empresa y networking.</p>
                    <p class="text-2xl font-black text-slate-800 mb-6">$20.000 <span class="text-sm font-normal text-slate-400">CLP</span></p>
                    <button onclick="abrirModalNuevoPlan('Corporativo')" class="mt-auto w-full py-3 bg-slate-100 text-slate-700 font-bold rounded-xl group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">Adquirir Corporativo</button>
                </div>
                
                <div class="bg-slate-900 p-6 rounded-2xl shadow-md border border-slate-800 transform hover:-translate-y-1 transition-all flex flex-col relative">
                    <span class="absolute top-0 right-0 bg-pink-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg rounded-tr-xl uppercase tracking-wider">Popular</span>
                    <h4 class="text-lg font-bold text-white">Matrimonio</h4>
                    <p class="text-indigo-200 text-sm mb-4">La experiencia interactiva total.</p>
                    <p class="text-2xl font-black text-white mb-6">$30.000 <span class="text-sm font-normal text-indigo-300">CLP</span></p>
                    <button onclick="abrirModalNuevoPlan('Matrimonio')" class="mt-auto w-full py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition shadow-lg">Adquirir Matrimonio</button>
                </div>
            </div>
        </div>

        {{-- 🔥 NUEVO: SECCIÓN DE CENTRO DE AYUDA Y SOPORTE --}}
        <div class="mt-12 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col md:flex-row">
            <div class="bg-indigo-50 p-8 md:w-1/3 flex flex-col justify-center items-center text-center border-b md:border-b-0 md:border-r border-indigo-100">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4 text-indigo-500">
                    <i class="fas fa-headset text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Centro de Soporte</h3>
                <p class="text-slate-500 text-sm mb-6">¿Tienes problemas configurando tu evento o conectando OneDrive? Estamos aquí para ayudarte.</p>
                
                <a href="https://wa.me/56999347335?text=Hola%20equipo%20Eventify,%20necesito%20ayuda%20con%20el%20panel%20de%20anfitrión." target="_blank" 
                   class="w-full bg-[#25D366] text-white py-3 rounded-xl font-bold hover:bg-green-600 transition shadow-md flex items-center justify-center gap-2">
                    <i class="fab fa-whatsapp text-xl"></i> Chat por WhatsApp
                </a>
            </div>
            
            <div class="p-8 md:w-2/3">
                <h4 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2"><i class="fas fa-lightbulb text-amber-400 mr-2"></i> Consejos Rápidos</h4>
                <ul class="space-y-4 text-sm text-slate-600">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-emerald-500 mt-1"></i>
                        <span><strong>Integración OneDrive:</strong> Las fotos que tus invitados suban al Muro y Galería no gastan almacenamiento de nuestro servidor, viajan encriptadas directo a tu cuenta de Microsoft OneDrive ligada al evento.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-emerald-500 mt-1"></i>
                        <span><strong>Muro Seguro:</strong> Si ves un mensaje inapropiado en el Muro de Deseos, puedes ir a <em>"Mis Eventos" > "Moderar"</em> y ocultarlo al instante con un solo clic.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-emerald-500 mt-1"></i>
                        <span><strong>Control de Asistencia:</strong> Envía el Enlace Principal de tu evento por WhatsApp. Cuando un invitado se registre, el sistema le entregará su <em>Código de Pase Personal</em> para interactuar durante la fiesta.</span>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    {{-- MODAL NUEVO PLAN --}}
    <div id="modalNuevoPlan" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div class="bg-white p-8 rounded-[2rem] w-full max-w-md shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="modalNuevoPlanContent">
            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                <div>
                    <span class="text-indigo-500 font-bold text-[10px] uppercase tracking-widest block mb-1">Añadir a mi cuenta</span>
                    <h3 id="tituloNuevoPlan" class="text-2xl font-extrabold text-slate-800">Solicitar</h3>
                </div>
                <button onclick="cerrarModalNuevoPlan()" class="text-slate-400 hover:text-rose-500 transition-colors bg-slate-50 hover:bg-rose-50 w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('solicitar.plan') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="plan" id="inputNuevoPlan">
                
                <input type="hidden" name="nombre" value="{{ auth()->user()->nombre }}">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Fecha de tu nuevo evento</label>
                    <input type="date" name="fecha_evento" class="w-full border border-slate-200 bg-slate-50 p-3.5 rounded-xl outline-none focus:border-indigo-500 focus:bg-white transition-colors text-sm text-slate-600" required>
                </div>
                
                <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-indigo-600 transition-colors shadow-lg mt-6 flex items-center justify-center gap-2">
                    Pagar en MercadoPago <i class="fas fa-credit-card"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        function abrirModalNuevoPlan(planName) {
            document.getElementById('inputNuevoPlan').value = planName;
            document.getElementById('tituloNuevoPlan').innerText = "Plan: " + planName;
            
            const modal = document.getElementById('modalNuevoPlan');
            const content = document.getElementById('modalNuevoPlanContent');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function cerrarModalNuevoPlan() {
            const modal = document.getElementById('modalNuevoPlan');
            const content = document.getElementById('modalNuevoPlanContent');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
    <style>
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endif

@endsection