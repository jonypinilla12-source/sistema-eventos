<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background-color: #f4f4f5; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 40px 0; margin: 0; -webkit-font-smoothing: antialiased;">
    
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e4e4e7;">

        <div style="background-color: {{ $tipoRecordatorio === '1_dia' ? '#312e81' : '#881337' }}; padding: 40px 20px; text-align: center; border-bottom: 4px solid {{ $tipoRecordatorio === '1_dia' ? '#6366f1' : '#fb7185' }};">
            <p style="color: {{ $tipoRecordatorio === '1_dia' ? '#c7d2fe' : '#fecdd3' }}; font-size: 12px; text-transform: uppercase; letter-spacing: 3px; margin: 0 0 10px 0;">
                Recordatorio Oficial
            </p>
            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 300; letter-spacing: 1px; font-family: Georgia, 'Times New Roman', serif;">
                {{ $tipoRecordatorio === '1_dia' ? '¡Nos vemos mañana!' : '¡Empezamos en 1 Hora!' }}
            </h1>
        </div>

        <div style="padding: 40px 30px; text-align: center;">
            <h2 style="color: #18181b; margin-top: 0; font-size: 22px; font-weight: 600;">¡Hola, {{ $invitado->nombre_invitado }}!</h2>
            
            <p style="color: #52525b; font-size: 16px; line-height: 1.6; margin-bottom: 35px; max-width: 85%; margin-left: auto; margin-right: auto;">
                {{ $tipoRecordatorio === '1_dia' ? 'Ya casi está todo listo.' : 'La espera ha terminado.' }} 
                Te recordamos que el evento <br><strong style="color: #18181b; font-size: 18px;">{{ $invitado->evento->nombre_evento }}</strong><br> está a punto de comenzar.
            </p>
            
            <div style="background: linear-gradient(145deg, #f8fafc, #f1f5f9); border: 1px solid #cbd5e1; border-radius: 12px; padding: 30px 20px; margin: 0 auto 35px auto; max-width: 320px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <p style="margin: 0; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; font-weight: bold;">
                    Tu Pase VIP
                </p>
                
                <div style="width: 40px; height: 2px; background-color: {{ $tipoRecordatorio === '1_dia' ? '#6366f1' : '#fb7185' }}; margin: 15px auto;"></div>
                
                <p style="margin: 0; color: #0f172a; font-size: 34px; font-weight: 900; letter-spacing: 5px; font-family: 'Courier New', Courier, monospace;">
                    {{ $invitado->numero_invitado }}
                </p>
                
                <p style="margin: 15px 0 0 0; color: #94a3b8; font-size: 11px;">
                    Ten este código a la mano para las dinámicas
                </p>
            </div>

            <a href="{{ route('eventos.show', $invitado->evento->slug) }}" style="display: inline-block; background-color: #18181b; color: #ffffff; text-decoration: none; padding: 16px 35px; border-radius: 50px; font-weight: bold; font-size: 13px; letter-spacing: 2px; text-transform: uppercase;">
                Ver Ubicación e Invitación
            </a>
        </div>

        <div style="background-color: #fafafa; padding: 25px; text-align: center; border-top: 1px solid #f4f4f5;">
            <p style="color: #a1a1aa; font-size: 11px; margin: 0; line-height: 1.6;">
                Este es un mensaje automático enviado por el sistema de {{ $invitado->evento->nombre_evento }}.<br>
                Por favor, no respondas a este correo.
            </p>
        </div>

    </div>
</body>
</html>