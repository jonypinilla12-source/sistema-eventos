<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body style="background-color: #f1f5f9; font-family: sans-serif; padding: 40px 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">
        
        <div style="background-color: #4f46e5; padding: 30px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Nueva Dedicatoria</h1>
        </div>

        <div style="padding: 30px;">
            <p style="color: #334155; font-size: 16px;">Hola <strong>{{ $evento->usuario->nombre }}</strong>,</p>
            <p style="color: #475569;">Has recibido un nuevo mensaje en el memorial de <strong>{{ $evento->nombre_evento }}</strong>. Para que aparezca publicado en el sitio, debes aprobarlo primero.</p>

            <div style="background-color: #f8fafc; border-left: 4px solid #4f46e5; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; color: #1e293b; font-style: italic;">"{{ $interaccion->contenido_texto }}"</p>
                <p style="margin: 10px 0 0 0; color: #64748b; font-size: 12px; font-weight: bold;">— {{ $interaccion->nombre_autor }} ({{ $interaccion->vinculo_autor }})</p>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('eventos.interacciones', $evento->evento_id) }}" style="background-color: #4f46e5; color: #ffffff; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                    Ir a Moderar Dedicatorias
                </a>
            </div>
        </div>
    </div>
</body>
</html>