<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Pago Exitoso! | Eventify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
    
    <div class="max-w-lg w-full bg-white rounded-[2rem] shadow-2xl p-10 text-center border border-slate-100 transform transition-all animate-[bounce_1s_ease-in-out_1]">
        
        <div class="w-24 h-24 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-6 shadow-inner relative">
            <div class="absolute inset-0 rounded-full border-4 border-emerald-100 animate-ping"></div>
            <i class="fas fa-check"></i>
        </div>
        
        <span class="text-emerald-500 font-bold tracking-widest uppercase text-xs mb-2 block">¡Transacción Aprobada!</span>
        <h1 class="text-3xl font-extrabold mb-4 text-slate-800">Servicio Contratado</h1>
        
        <p class="text-slate-500 mb-6 leading-relaxed text-lg">
            Tu plan <strong>{{ $plan }}</strong> ha sido creado y está listo para ser personalizado.
        </p>

        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 mb-8 text-sm text-slate-600 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-indigo-500"></div>
            <i class="fas fa-envelope-open-text text-indigo-500 text-3xl mb-3"></i>
            <p>Revisa la bandeja de entrada de tu correo:</p>
            <p class="font-bold text-slate-800 text-lg mt-1">{{ $email }}</p>
            <p class="mt-3 text-xs text-slate-400">Te hemos enviado tus credenciales de anfitrión (usuario y contraseña) para que puedas ingresar a tu panel de control.</p>
        </div>

        <a href="{{ route('login') }}" class="block w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-indigo-600 transition shadow-lg hover:-translate-y-1 flex justify-center items-center gap-3 uppercase tracking-wider text-sm">
            Ir a Iniciar Sesión <i class="fas fa-sign-in-alt"></i>
        </a>
        
        <p class="text-[10px] text-slate-400 mt-6 mt-4">
            ¿No encuentras el correo? Revisa tu carpeta de Spam o Correo no deseado.
        </p>
    </div>

</body>
</html>