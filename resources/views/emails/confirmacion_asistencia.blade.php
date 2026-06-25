<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia Confirmada</title>
</head>
<body style="background-color: #f4f4f5; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 40px 0; margin: 0; -webkit-font-smoothing: antialiased;">
    
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e4e4e7;">

        <div style="background-color: #064e3b; padding: 40px 20px; text-align: center; border-bottom: 4px solid #10b981;">
            <p style="color: #a7f3d0; font-size: 12px; text-transform: uppercase; letter-spacing: 3px; margin: 0 0 10px 0;">
                {{ $invitado->evento->nombre_evento }}
            </p>
            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 300; letter-spacing: 1px; font-family: Georgia, 'Times New Roman', serif;">
                ¡Asistencia Confirmada!
            </h1>
        </div>

        <div style="padding: 40px 30px; text-align: center;">
            <h2 style="color: #18181b; margin-top: 0; font-size: 22px; font-weight: 600;">¡Hola, {{ $invitado->nombre_invitado }}!</h2>
            
            <p style="color: #52525b; font-size: 16px; line-height: 1.6; margin-bottom: 35px; max-width: 90%; margin-left: auto; margin-right: auto;">
                Hemos registrado exitosamente tus lugares. A continuación, te entregamos tus códigos de acceso personales. <strong>Guárdalos bien</strong>, ya que cada invitado necesitará el suyo para participar en las dinámicas interactivas del evento.
            </p>
            
            <div style="background: linear-gradient(145deg, #f8fafc, #f1f5f9); border: 1px solid #cbd5e1; border-radius: 12px; padding: 30px 20px; margin: 0 auto 35px auto; max-width: 400px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <p style="margin: 0; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; font-weight: bold; text-align: center;">
                    Tus Pases Secretos
                </p>
                
                <div style="width: 40px; height: 2px; background-color: #10b981; margin: 15px auto 20px auto;"></div>
                
                <table style="width: 100%; border-collapse: collapse;">
                    @foreach($codigos as $item)
                    <tr>
                        <td style="padding: 12px 5px; border-bottom: {{ $loop->last ? 'none' : '1px dashed #cbd5e1' }}; color: #334155; font-size: 13px; font-weight: bold; text-transform: uppercase; text-align: left;">
                            {{ $item['nombre'] }}
                        </td>
                        <td style="padding: 12px 5px; border-bottom: {{ $loop->last ? 'none' : '1px dashed #cbd5e1' }}; text-align: right;">
                            <span style="background-color: #ffffff; border: 1px solid #e2e8f0; color: #064e3b; padding: 6px 12px; border-radius: 6px; font-family: 'Courier New', Courier, monospace; font-size: 15px; font-weight: 900; letter-spacing: 2px; display: inline-block;">
                                {{ $item['codigo'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <a href="{{ route('eventos.show', $invitado->evento->slug) }}" style="display: inline-block; background-color: #064e3b; color: #ffffff; text-decoration: none; padding: 16px 35px; border-radius: 50px; font-weight: bold; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; box-shadow: 0 4px 6px rgba(6, 78, 59, 0.2);">
                Ver la Invitación
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