<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Contraseña Actualizada</title>
</head>
<body style="background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; padding: 40px 20px; margin: 0; -webkit-font-smoothing: antialiased;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        
        <div style="background-color: #0f172a; padding: 30px 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: 2px;">EVENTIFY</h1>
        </div>

        <div style="padding: 40px 30px; text-align: center;">
            <div style="background-color: #ecfdf5; width: 70px; height: 70px; border-radius: 50%; line-height: 70px; margin: 0 auto 20px auto; font-size: 30px; border: 2px solid #a7f3d0;">
                ✅
            </div>
            
            <h2 style="color: #1e293b; margin: 0 0 15px 0; font-size: 22px; font-weight: 700;">¡Contraseña Actualizada!</h2>
            
            <p style="color: #475569; font-size: 16px; line-height: 1.6; margin-bottom: 30px;">
                Hola <strong>{{ $user->nombre }}</strong>,<br><br>
                Te escribimos para confirmarte que la contraseña de tu cuenta en Eventify ha sido cambiada exitosamente hace unos instantes.
            </p>

            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 30px; text-align: left;">
                <p style="margin: 0; color: #64748b; font-size: 14px;">
                    <strong style="color: #334155;">¿No reconoces esta actividad?</strong><br>
                    Si no fuiste tú quien realizó este cambio, por favor contacta inmediatamente a nuestro soporte técnico para proteger tu cuenta.
                </p>
            </div>
            
            <a href="{{ route('login') }}" style="display: inline-block; background-color: #334155; color: #ffffff; text-decoration: none; padding: 14px 35px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                Ir a mi panel
            </a>
        </div>
    </div>

    <p style="text-align: center; color: #94a3b8; font-size: 12px; margin-top: 20px;">
        Este es un aviso automático de seguridad.
    </p>

</body>
</html>