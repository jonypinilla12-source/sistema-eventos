<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema Eventos - Distribuidora Máxima</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar-transition { transition: width 0.3s ease, transform 0.3s ease; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-gray-100 font-sans overflow-x-hidden">

    <div class="flex min-h-screen relative">
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

        <aside id="sidebar" class="sidebar-transition fixed inset-y-0 left-0 z-50 w-64 bg-slate-800 text-white flex flex-col shadow-xl transform -translate-x-full md:translate-x-0 md:relative">
            
            <div class="p-6 flex-grow overflow-y-auto no-scrollbar">
                <div class="flex items-center justify-between mb-10">
                    <div class="flex items-center space-x-3">
                        <div class="bg-indigo-500 p-2 rounded-lg flex-shrink-0 shadow-lg shadow-indigo-500/30">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <span id="logo-text" class="sidebar-text text-xl font-bold tracking-wider whitespace-nowrap">EVENTIFY</span>
                    </div>
                    <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <nav class="space-y-2">
                    <p class="sidebar-text text-xs uppercase text-slate-400 font-semibold mb-4 tracking-widest whitespace-nowrap">Menú Principal</p>

                    <a href="{{ route('home') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700 transition group" title="Inicio">
                        <i class="fas fa-home w-5 text-center text-slate-400 group-hover:text-white"></i>
                        <span class="sidebar-text whitespace-nowrap">Inicio</span>
                    </a>

                    <a href="{{ route('eventos.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700 transition group" title="Eventos">
                        <i class="fas fa-calendar-alt w-5 text-center text-slate-400 group-hover:text-white"></i>
                        <span class="sidebar-text whitespace-nowrap">Mis Eventos</span>
                    </a>

                    @if(auth()->user()->rol_id == 1)
                        <div class="pt-4 pb-2">
                            <p class="sidebar-text text-[10px] uppercase text-slate-500 font-bold tracking-widest whitespace-nowrap">Administración</p>
                        </div>
                        <a href="{{ route('roles.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700 transition group" title="Roles">
                            <i class="fas fa-user-shield w-5 text-center text-slate-400 group-hover:text-white"></i>
                            <span class="sidebar-text whitespace-nowrap">Roles</span>
                        </a>

                        <a href="{{ route('usuarios.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700 transition group" title="Usuarios">
                            <i class="fas fa-users w-5 text-center text-slate-400 group-hover:text-white"></i>
                            <span class="sidebar-text whitespace-nowrap">Usuarios</span>
                        </a>

                        <a href="{{ route('tipos.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700 transition group" title="Tipos de Eventos">
                            <i class="fas fa-tags w-5 text-center text-slate-400 group-hover:text-white"></i>
                            <span class="sidebar-text whitespace-nowrap">Tipos</span>
                        </a>
                    @endif
                </nav>
            </div>

            {{-- 🔥 NUEVO: SECCIÓN DE SOPORTE DIRECTO EN EL MENÚ --}}
            <div class="px-6 pb-6">
                <a href="https://wa.me/56999347335?text=Hola%20equipo%20Eventify,%20necesito%20ayuda%20con%20el%20panel%20de%20anfitrión." target="_blank" 
                   class="flex items-center space-x-3 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all group" title="Soporte Técnico">
                    <i class="fab fa-whatsapp text-xl group-hover:scale-110 transition-transform"></i>
                    <span class="sidebar-text whitespace-nowrap text-sm font-semibold tracking-wide">Soporte Técnico</span>
                </a>
            </div>

            <div class="p-4 border-t border-slate-700 bg-slate-900/50">
                <div class="flex items-center justify-between group-collapsed-hidden">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex-shrink-0 flex items-center justify-center font-bold text-xs uppercase shadow-md shadow-indigo-500/30">
                            {{ substr(auth()->user()->nombre, 0, 2) }}
                        </div>
                        <div class="flex flex-col sidebar-text overflow-hidden">
                            <span class="text-sm font-medium truncate">{{ auth()->user()->nombre }}</span>
                            <span class="text-[10px] text-slate-400 truncate">{{ auth()->user()->rol->nombre_rol ?? 'Usuario' }}</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center sidebar-text">
                        <a href="{{ route('perfil.edit') }}" class="text-slate-400 hover:text-indigo-400 transition p-2" title="Mi Perfil">
                            <i class="fas fa-user-cog"></i>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-red-400 transition p-2" title="Cerrar Sesión">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white shadow-sm h-16 flex items-center px-8 border-b border-gray-200 z-30">
                <div class="flex-1">
                    <button onclick="toggleSidebar()" class="text-gray-500 hover:text-indigo-600 transition-colors p-2 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="far fa-bell text-gray-400 hover:text-indigo-500 cursor-pointer"></i>
                    <div class="h-8 w-px bg-gray-200 mx-2"></div>
                    
                    <a href="{{ route('perfil.edit') }}" class="flex items-center space-x-2 text-gray-600 hover:text-indigo-600 transition group">
                        <i class="fas fa-user-circle text-xl text-gray-400 group-hover:text-indigo-500 transition"></i>
                        <span class="text-sm font-medium hidden sm:inline-block">Mi Perfil</span>
                    </a>
                </div>
            </header>

            <main class="p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const texts = document.querySelectorAll('.sidebar-text');
            
            if (window.innerWidth >= 768) {
                if (sidebar.classList.contains('w-64')) {
                    sidebar.classList.replace('w-64', 'w-20');
                    texts.forEach(t => t.classList.add('hidden'));
                } else {
                    sidebar.classList.replace('w-20', 'w-64');
                    setTimeout(() => {
                        texts.forEach(t => t.classList.remove('hidden'));
                    }, 150); 
                }
            } else {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        window.addEventListener('resize', () => {
            const sidebar = document.getElementById('sidebar');
            const texts = document.querySelectorAll('.sidebar-text');
            const overlay = document.getElementById('sidebar-overlay');

            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.replace('w-20', 'w-64');
                texts.forEach(t => t.classList.remove('hidden'));
            }
        });
    </script>
</body>
</html>