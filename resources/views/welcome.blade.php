<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify | Tu Evento al Siguiente Nivel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .gradient-text {
            background: linear-gradient(to right, #4f46e5, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 20px 20px;
        }
        /* Efecto de pulso para WhatsApp */
        @keyframes pulse-ring {
            0% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
            100% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
        }
        .wa-pulse { animation: pulse-ring 2s infinite; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 font-extrabold text-2xl tracking-tighter text-indigo-600 flex items-center">
                    <i class="fas fa-glass-cheers mr-3 text-3xl"></i>Eventify
                </div>
                <div class="hidden md:flex space-x-8 font-semibold text-sm text-slate-600 uppercase tracking-wide">
                    <a href="#caracteristicas" class="hover:text-indigo-600 transition">Características</a>
                    <a href="#demos" class="hover:text-indigo-600 transition">Demos en Vivo</a>
                    <a href="#precios" class="hover:text-indigo-600 transition">Valores</a>
                    <a href="#faq" class="hover:text-indigo-600 transition">Ayuda / FAQ</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition uppercase tracking-wider">Ingresar</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-pattern pt-40 pb-24 md:pt-56 md:pb-40 px-4 overflow-hidden relative">
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <div class="inline-block bg-white text-indigo-600 font-bold px-5 py-2 rounded-full text-xs md:text-sm mb-8 border border-indigo-100 shadow-sm animate-bounce">
                🚀 La nueva era de la gestión de eventos digitales
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8 leading-tight">
                Momentos que celebran la vida, <br> <span class="gradient-text">recuerdos que perduran</span>
            </h1>
            
            <p class="text-lg md:text-2xl text-slate-500 mb-12 max-w-3xl mx-auto font-light leading-relaxed">
                Plataforma integral para bodas, eventos corporativos y homenajes memorables. Gestiona invitaciones con QR, muros de recuerdos colaborativos y galerías inteligentes, todo en un solo lugar.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#demos" class="bg-slate-900 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-slate-800 transition shadow-2xl hover:-translate-y-1 flex items-center justify-center gap-3">
                    Explorar Demos Interactivas <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="caracteristicas" class="py-24 bg-white px-4 border-t border-slate-100">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <span class="text-indigo-500 font-bold tracking-widest uppercase text-sm mb-2 block">Funcionalidades Core</span>
                <h2 class="text-4xl md:text-5xl font-extrabold mb-6 text-slate-800">Soluciones integrales para cada momento</h2>
                <p class="text-slate-500 text-lg md:text-xl max-w-2xl mx-auto font-light">Ya sea una boda, un evento corporativo o un homenaje a un ser querido, nuestro sistema simplifica lo complejo para que tú solo te preocupes de vivir el momento.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-10 rounded-[2rem] bg-slate-50 border border-slate-100 hover:-translate-y-2 transition-all duration-300 hover:shadow-xl group">
                    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform shadow-inner">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800">Gestión de Asistencia</h3>
                    <p class="text-slate-500 leading-relaxed font-light text-lg">Controla quién asiste con un sistema de pases digitales. Ya sea para confirmar asistencias de invitados o registrar accesos, todo es seguro y digital.</p>
                </div>

                <div class="p-10 rounded-[2rem] bg-slate-50 border border-slate-100 hover:-translate-y-2 transition-all duration-300 hover:shadow-xl group">
                    <div class="w-16 h-16 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform shadow-inner">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800">Conexión y Memoria</h3>
                    <p class="text-slate-500 leading-relaxed font-light text-lg">Crea espacios de interacción. Permite que tus invitados compartan mensajes, anécdotas, trivias o condolencias en un muro digital diseñado para perdurar.</p>
                </div>

                <div class="p-10 rounded-[2rem] bg-slate-50 border border-slate-100 hover:-translate-y-2 transition-all duration-300 hover:shadow-xl group">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform shadow-inner">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800">Preservación Digital</h3>
                    <p class="text-slate-500 leading-relaxed font-light text-lg">Guarda cada recuerdo. La integración con OneDrive asegura que todas las fotos y archivos subidos se almacenen de forma segura, creando un archivo digital para siempre.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="demos" class="py-24 bg-slate-900 text-white px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <span class="text-indigo-400 font-bold tracking-widest uppercase text-sm mb-2 block">Pruébalo ahora mismo</span>
                <h2 class="text-4xl md:text-6xl font-extrabold mt-2 mb-6">Ingresa como un invitado real</h2>
                <p class="text-slate-400 text-lg md:text-xl max-w-3xl mx-auto font-light leading-relaxed">Interactúa con nuestras plantillas. Confirma asistencia para obtener tu código secreto, y luego prueba ingresar a la trivia o subir un mensaje al muro de deseos.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-800 rounded-[2rem] overflow-hidden border border-slate-700 flex flex-col group hover:border-indigo-500 transition-colors shadow-2xl">
                    <div class="h-56 bg-[url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-800 to-transparent"></div>
                        <div class="absolute inset-0 bg-indigo-900/20 group-hover:bg-transparent transition-colors"></div>
                        <span class="absolute top-4 right-4 bg-indigo-500 text-white text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-lg">Multi-Plantilla</span>
                    </div>
                    <div class="p-8 flex-grow flex flex-col">
                        <h3 class="text-3xl font-extrabold mb-3">Bodas & Matrimonios</h3>
                        <p class="text-base text-slate-400 mb-8 font-light flex-grow leading-relaxed">El día más importante requiere el mejor diseño. Elige el estilo de la invitación antes de entrar y descubre la experiencia completa.</p>
                        
                        <div class="space-y-4 bg-slate-900/50 p-6 rounded-2xl border border-slate-700">
                            <label class="text-xs font-bold text-indigo-400 uppercase tracking-widest block"><i class="fas fa-paint-brush mr-2"></i>Selecciona el diseño:</label>
                            <select id="selectorPlantilla" class="w-full bg-slate-800 border border-slate-600 text-white p-3 rounded-xl outline-none focus:border-indigo-500 cursor-pointer text-sm font-medium">
                                <option value="Editorial">Editorial (Default)</option>
                                <option value="Gala Real">Gala (Black Tie)</option>
                                <option value="Boho Chic">Boho Chic Romántico</option>
                                <option value="Estreno">Estreno (Cinematográfico)</option>
                                <option value="Pop Art">Pop Art (Colorful)</option>
                                <option value="UCM">MARVEL (Asamblea)</option>
                                <option value="DC">DC (Superheroes)</option>
                                <option value="Romance">Aura de Seda (Romántica)</option>
                                <option value="Magia">Noche Mágica (Encantada)</option>
                                <option value="Jardin">Jardín Nocturno (Nature)</option>
                            </select>
                            
                            <button onclick="abrirDemoMatrimonio()" class="w-full bg-white text-slate-900 font-extrabold py-4 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all flex items-center justify-center gap-3 uppercase tracking-wider text-sm mt-4 shadow-lg hover:-translate-y-1">
                                <i class="fas fa-play-circle text-lg"></i> Ingresar a la Demo
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-[2rem] overflow-hidden border border-slate-700 flex flex-col group hover:border-blue-500 transition-colors shadow-2xl">
                    <div class="h-56 bg-[url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-800 to-transparent"></div>
                        <div class="absolute inset-0 bg-blue-900/20 group-hover:bg-transparent transition-colors"></div>
                        <span class="absolute top-4 right-4 bg-slate-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-lg">Negocios</span>
                    </div>
                    <div class="p-8 flex-grow flex flex-col">
                        <h3 class="text-3xl font-extrabold mb-3">Evento Corporativo</h3>
                        <p class="text-base text-slate-400 mb-8 font-light flex-grow leading-relaxed">Ideal para cenas de fin de año, congresos o lanzamientos de marca. Diseño profesional y enfocado en networking empresarial.</p>
                        
                        <div class="space-y-4 bg-slate-900/50 p-6 rounded-2xl border border-slate-700">
                            <label class="text-xs font-bold text-indigo-400 uppercase tracking-widest block"><i class="fas fa-paint-brush mr-2"></i>Selecciona el diseño:</label>
                            <select id="selectorPlantillaCorporativo" class="w-full bg-slate-800 border border-slate-600 text-white p-3 rounded-xl outline-none focus:border-indigo-500 cursor-pointer text-sm font-medium">
                                <option value="A">Business Summit (Estándar)</option>
                                <option value="B">Vista Zen (Minimalista)</option>
                                <option value="C">Cyber Tech (Terminal)</option>
                                <option value="D">Gala Ejecutiva (Lujo Noir)</option>
                                <option value="E">Innovación SaaS (Apple/Mesh)</option>
                                <option value="F">Startup Creativa (Team Building)</option>
                            </select>
                            <button onclick="abrirDemoCorporativo()" class="w-full bg-white text-slate-900 font-extrabold py-4 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all flex items-center justify-center gap-3 uppercase tracking-wider text-sm mt-4 shadow-lg hover:-translate-y-1">
                                <i class="fas fa-play-circle text-lg"></i> Ingresar a la Demo
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-[2rem] overflow-hidden border border-slate-700 flex flex-col group hover:border-stone-500 transition-colors shadow-2xl">
                    <div class="h-56 bg-[url('https://images.unsplash.com/photo-1501901609772-df0848060b33?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-800 to-transparent"></div>
                        <div class="absolute inset-0 bg-stone-900/30 group-hover:bg-transparent transition-colors"></div>
                        <span class="absolute top-4 right-4 bg-stone-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-lg">Homenaje Libre</span>
                    </div>
                    <div class="p-8 flex-grow flex flex-col">
                        <h3 class="text-3xl font-extrabold mb-3">Memorial de Vida</h3>
                        <p class="text-base text-slate-400 mb-8 font-light flex-grow leading-relaxed">Un espacio íntimo de respeto. Los invitados pueden dejar condolencias y fotos históricas en un muro moderado.</p>
                        <div class="space-y-4 bg-slate-900/50 p-6 rounded-2xl border border-slate-700">
                            <label class="text-xs font-bold text-indigo-400 uppercase tracking-widest block"><i class="fas fa-paint-brush mr-2"></i>Selecciona el diseño:</label>
                            <select id="selectorPlantillaMemorial" class="w-full bg-slate-800 border border-slate-600 text-white p-3 rounded-xl outline-none focus:border-indigo-500 cursor-pointer text-sm font-medium">
                                <option value="1">PAZ ETERNA (Naturaleza)</option>
                                <option value="2">LEGADO DE LUZ (Clásico)</option>
                                <option value="3">BOSQUE DEL RECUERDO</option>
                                <option value="4">CIELO ESTRELLADO (Nocturno)</option>
                                <option value="5">LUZ CÁLIDA (Atardecer)</option>
                                <option value="6">GALERÍA NOIR (Moderno)</option>
                                <option value="7">BABY/INFANTIL</option>
                            </select>
                            <button onclick="abrirDemoMemorial()" class="w-full bg-white text-slate-900 font-extrabold py-4 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all flex items-center justify-center gap-3 uppercase tracking-wider text-sm mt-4 shadow-lg hover:-translate-y-1">
                                <i class="fas fa-play-circle text-lg"></i> Ingresar a la Demo
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="precios" class="py-32 bg-slate-50 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <span class="text-pink-500 font-bold tracking-widest uppercase text-sm mb-2 block">Planes de Servicio</span>
                <h2 class="text-4xl md:text-5xl font-extrabold mb-6 text-slate-800">Elige el plan ideal para tu evento</h2>
                <p class="text-slate-500 text-lg md:text-xl font-light">Soluciones diseñadas para cada tipo de celebración.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
                
                <div class="bg-white p-8 rounded-[2rem] shadow-lg border border-slate-100 flex flex-col hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Memorial</h3>
                    <p class="text-slate-500 text-sm mb-6 font-light">Para honrar memorias con respeto y distinción.</p>
                    <div class="mb-8">
                        <span class="text-4xl font-black text-slate-800">$10.000</span> <span class="text-slate-400 font-medium">CLP</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-slate-600 font-light text-sm">
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> QR de acceso</li>
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> Muro de recuerdos</li>
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> Galería fotográfica</li>
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> Integración OneDrive</li>
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> Moderación de contenido</li>
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> QR METÁLICO PARA LÁPIDAS</li>
                    </ul>
                    <button onclick="abrirModalSolicitud('Memorial')" class="block w-full py-4 bg-slate-100 text-slate-800 font-bold text-center rounded-xl hover:bg-slate-200 transition uppercase tracking-widest text-sm">
                        Elegir Memorial
                    </button>
                </div>

                <div class="bg-slate-900 p-8 rounded-[2rem] shadow-2xl border border-slate-800 flex flex-col relative transform md:-translate-y-4 hover:-translate-y-6 transition-all duration-300">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-pink-500 to-indigo-500 text-white px-6 py-1 rounded-full text-xs font-bold uppercase tracking-widest shadow-lg">
                        Más Popular
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Matrimonios</h3>
                    <p class="text-indigo-200 text-sm mb-6 font-light">La experiencia interactiva total para el gran día.</p>
                    <div class="mb-8">
                        <span class="text-4xl font-black text-white">$30.000</span> <span class="text-indigo-300 font-medium">CLP</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-indigo-100 font-light text-sm">
                        <li><i class="fas fa-check text-pink-400 mr-3"></i> Invitación Premium</li>
                        <li><i class="fas fa-check text-pink-400 mr-3"></i> Trivia interactiva</li>
                        <li><i class="fas fa-check text-pink-400 mr-3"></i> Muro de deseos</li>
                        <li><i class="fas fa-check text-pink-400 mr-3"></i> Integración OneDrive</li>
                        <li><i class="fas fa-check text-pink-400 mr-3"></i> Confirmación de asistencia</li>
                    </ul>
                    <button onclick="abrirModalSolicitud('Matrimonio')" class="block w-full py-4 bg-white text-indigo-900 font-bold text-center rounded-xl hover:bg-indigo-50 transition shadow-xl uppercase tracking-widest text-sm">
                        Elegir Matrimonio
                    </button>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-lg border border-slate-100 flex flex-col hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Corporativo</h3>
                    <p class="text-slate-500 text-sm mb-6 font-light">Eventos de empresa, congresos y lanzamientos.</p>
                    <div class="mb-8">
                        <span class="text-4xl font-black text-slate-800">$20.000</span> <span class="text-slate-400 font-medium">CLP</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-slate-600 font-light text-sm">
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> Invitación Profesional</li>
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> Gestión de asistentes</li>
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> Reportes de invitados</li>
                        <li><i class="fas fa-check text-emerald-500 mr-3"></i> Itinerario interactivo</li>
                    </ul>
                    <button onclick="abrirModalSolicitud('Corporativo')" class="block w-full py-4 bg-slate-100 text-slate-800 font-bold text-center rounded-xl hover:bg-slate-200 transition uppercase tracking-widest text-sm">
                        Elegir Corporativo
                    </button>
                </div>

            </div>
        </div>
    </section>

    <section id="faq" class="py-24 bg-white border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-indigo-500 font-bold tracking-widest uppercase text-sm mb-2 block"><i class="fas fa-life-ring mr-2"></i>Soporte Rápido</span>
                <h2 class="text-4xl font-extrabold text-slate-800 mb-4">Preguntas Frecuentes</h2>
                <p class="text-slate-500 font-light text-lg">Resolvemos tus dudas al instante para que todo salga perfecto.</p>
            </div>

            <div class="space-y-4">
                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
                    <button onclick="toggleFAQ(1)" class="w-full px-6 py-5 text-left flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800">¿Necesitan los invitados descargar alguna aplicación?</span>
                        <i id="faq-icon-1" class="fas fa-chevron-down text-indigo-500 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-1" class="hidden px-6 py-5 bg-white text-slate-600 font-light leading-relaxed border-t border-slate-100">
                        ¡No! Eventify es una plataforma 100% web. Tus invitados solo necesitan escanear el código QR que se les entregue (o hacer clic en el enlace que les envíes por WhatsApp) y podrán interactuar directamente desde el navegador de cualquier teléfono inteligente.
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
                    <button onclick="toggleFAQ(2)" class="w-full px-6 py-5 text-left flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800">¿Cómo acceden los invitados si no tienen conexión a internet el día del evento?</span>
                        <i id="faq-icon-2" class="fas fa-chevron-down text-indigo-500 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-2" class="hidden px-6 py-5 bg-white text-slate-600 font-light leading-relaxed border-t border-slate-100">
                        Los invitados pueden realizar una captura de pantalla a su Pase Personal o Código de Acceso una vez que confirman su asistencia en casa. Al llegar, simplemente muestran la foto guardada en su galería para que el anfitrión valide su ingreso en la recepción.
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
                    <button onclick="toggleFAQ(3)" class="w-full px-6 py-5 text-left flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800">¿Dónde se guardan las fotos y cómo puedo descargarlas?</span>
                        <i id="faq-icon-3" class="fas fa-chevron-down text-indigo-500 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-3" class="hidden px-6 py-5 bg-white text-slate-600 font-light leading-relaxed border-t border-slate-100">
                        Nuestro sistema se sincroniza en tiempo real con <strong>Microsoft OneDrive</strong>. Todas las fotos y videos que suban tus invitados se envían directamente a una carpeta privada en la nube, conservando su calidad original. Podrás descargar el álbum completo con un solo clic, y los invitados también podrán descargar sus fotos favoritas durante la fiesta.
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
                    <button onclick="toggleFAQ(4)" class="w-full px-6 py-5 text-left flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800">¿Qué pasa si un invitado sube un mensaje inapropiado al muro?</span>
                        <i id="faq-icon-4" class="fas fa-chevron-down text-indigo-500 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-4" class="hidden px-6 py-5 bg-white text-slate-600 font-light leading-relaxed border-t border-slate-100">
                        Como anfitrión (Admin), tienes control absoluto. Tienes acceso a un panel de moderación en vivo donde puedes ver todos los mensajes entrantes. Puedes "Ocultar" u "Aprobar" el contenido al instante, impidiendo que aparezcan en las pantallas gigantes.
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
                    <button onclick="toggleFAQ(5)" class="w-full px-6 py-5 text-left flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800">¿Puedo cambiar el diseño de la plantilla más adelante?</span>
                        <i id="faq-icon-5" class="fas fa-chevron-down text-indigo-500 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-5" class="hidden px-6 py-5 bg-white text-slate-600 font-light leading-relaxed border-t border-slate-100">
                        ¡Por supuesto! Entendemos que puedes cambiar de opinión sobre la estética de tu boda o evento. Desde tu panel de anfitrión, puedes cambiar la plantilla gráfica las veces que quieras sin perder ningún dato, mensaje o foto que ya se haya subido.
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
                    <button onclick="toggleFAQ(6)" class="w-full px-6 py-5 text-left flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800">¿Cómo funciona la confirmación de asistencia (RSVP)?</span>
                        <i id="faq-icon-6" class="fas fa-chevron-down text-indigo-500 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-6" class="hidden px-6 py-5 bg-white text-slate-600 font-light leading-relaxed border-t border-slate-100">
                        Al contratar Eventify, te daremos un Enlace Principal. Se lo envías a tu lista de invitados por WhatsApp. Ellos entran, completan el formulario con sus datos (y los de sus acompañantes), y el sistema les emitirá inmediatamente un Código Personal y un pase que usarán para entrar al evento y participar en las dinámicas.
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
                    <button onclick="toggleFAQ(7)" class="w-full px-6 py-5 text-left flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800">¿Por qué la galería de fotos está bloqueada hasta 1 hora después del inicio?</span>
                        <i id="faq-icon-7" class="fas fa-chevron-down text-indigo-500 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-7" class="hidden px-6 py-5 bg-white text-slate-600 font-light leading-relaxed border-t border-slate-100">
                        Hemos implementado este "bloqueo inteligente" por respeto a la solemnidad de las ceremonias. Queremos evitar que los invitados se distraigan con sus teléfonos o suban fotos mientras ocurren los momentos más importantes. Transcurrida la hora inicial, el sistema libera automáticamente la bóveda visual para que empiece la fiesta.
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-slate-500 mb-4 font-light">¿Tu pregunta no está aquí? Haz clic en el ícono verde abajo a la derecha y nuestro equipo te responderá enseguida.</p>
            </div>
        </div>
    </section>

    <footer class="bg-slate-950 text-slate-500 py-16 text-center border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4">
            <i class="fas fa-glass-cheers text-4xl text-indigo-500 mb-6"></i>
            <h4 class="text-2xl font-bold text-white mb-2">Eventify</h4>
            <p class="mb-8 font-light max-w-md mx-auto">Elevando el estándar de las celebraciones en la era digital.</p>
            <div class="border-t border-slate-800 pt-8 mt-8 text-sm">
                <p>Eventify © {{ date('Y') }}. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <div class="fixed bottom-6 right-6 z-[100] flex flex-col items-end gap-3 group">
        
        <div class="bg-white text-slate-700 text-xs md:text-sm font-bold py-2.5 px-4 rounded-2xl shadow-2xl border border-slate-100 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300 pointer-events-none relative flex items-center gap-2">
            ¿Tienes dudas? Escríbenos 👋
            <div class="absolute -bottom-1.5 right-6 w-3 h-3 bg-white transform rotate-45 border-b border-r border-slate-100"></div>
        </div>
        
        <a href="https://wa.me/56999347335?text=Hola%20equipo%20Eventify,%20tengo%20una%20duda%20sobre%20sus%20servicios." 
           target="_blank" 
           class="bg-[#25D366] text-white w-14 h-14 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform duration-300 relative cursor-pointer">
            <span class="absolute inline-flex h-full w-full rounded-full bg-[#25D366] opacity-75 wa-pulse group-hover:hidden"></span>
            <i class="fab fa-whatsapp text-3xl relative z-10"></i>
        </a>
    </div>

    <div id="modalSolicitud" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div class="bg-white p-8 rounded-[2rem] w-full max-w-md shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="modalSolicitudContent">
            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                <div>
                    <span class="text-indigo-500 font-bold text-[10px] uppercase tracking-widest block mb-1">Paso 1 de 2</span>
                    <h3 id="tituloPlan" class="text-2xl font-extrabold text-slate-800">Solicitar Plan</h3>
                </div>
                <button onclick="cerrarModalSolicitud()" class="text-slate-400 hover:text-rose-500 transition-colors bg-slate-50 hover:bg-rose-50 w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('solicitar.plan') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="plan" id="inputPlanSeleccionado">
                
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Tu Nombre Completo</label>
                    <input type="text" name="nombre" class="w-full border border-slate-200 bg-slate-50 p-3.5 rounded-xl outline-none focus:border-indigo-500 focus:bg-white transition-colors text-sm" placeholder="Ej: Camila & Roberto" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Correo de Contacto</label>
                    <input type="email" name="email" class="w-full border border-slate-200 bg-slate-50 p-3.5 rounded-xl outline-none focus:border-indigo-500 focus:bg-white transition-colors text-sm" placeholder="tucorreo@ejemplo.com" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Fecha de la Celebración</label>
                    <input type="date" name="fecha_evento" class="w-full border border-slate-200 bg-slate-50 p-3.5 rounded-xl outline-none focus:border-indigo-500 focus:bg-white transition-colors text-sm text-slate-600" required>
                </div>
                
                <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-indigo-600 transition-colors shadow-lg mt-6 flex items-center justify-center gap-2">
                    Continuar <i class="fas fa-paper-plane"></i>
                </button>
                <p class="text-center text-[10px] text-slate-400 mt-4">Al continuar, serás redirigido al pago seguro (si aplica) o un ejecutivo te contactará.</p>
            </form>
        </div>
    </div>

    <script>
        // Funciones Demos
        function abrirDemoMatrimonio() {
            const plantillaSeleccionada = document.getElementById('selectorPlantilla').value;
            const idEventoDePrueba = 1; 
            let baseUrl = "{{ url('/eventos/render-plantilla') }}";
            let url = `${baseUrl}/${idEventoDePrueba}?preview=${plantillaSeleccionada}`;
            window.open(url, '_blank');
        }

        function abrirDemoCorporativo() {
            const plantillaSeleccionada = document.getElementById('selectorPlantillaCorporativo').value;
            const idEventoDePrueba = 3; 
            let baseUrl = "{{ url('/eventos/render-plantilla') }}";
            let url = `${baseUrl}/${idEventoDePrueba}?preview=${plantillaSeleccionada}`;
            window.open(url, '_blank');
        }

        function abrirDemoMemorial() {
            const plantillaSeleccionada = document.getElementById('selectorPlantillaMemorial').value;
            const idEventoDePrueba = 2; 
            let baseUrl = "{{ url('/eventos/render-plantilla') }}";
            let url = `${baseUrl}/${idEventoDePrueba}?preview=${plantillaSeleccionada}`;
            window.open(url, '_blank');
        }

        // Funciones FAQ
        function toggleFAQ(id) {
            const content = document.getElementById('faq-content-' + id);
            const icon = document.getElementById('faq-icon-' + id);
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Funciones Modal Solicitud
        function abrirModalSolicitud(planName) {
            document.getElementById('inputPlanSeleccionado').value = planName;
            document.getElementById('tituloPlan').innerText = "Plan: " + planName;
            
            const modal = document.getElementById('modalSolicitud');
            const content = document.getElementById('modalSolicitudContent');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function cerrarModalSolicitud() {
            const modal = document.getElementById('modalSolicitud');
            const content = document.getElementById('modalSolicitudContent');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>