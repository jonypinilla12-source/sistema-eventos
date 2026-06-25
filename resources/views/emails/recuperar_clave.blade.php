<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Recuperar Contraseña</title>
</head>
<body style="background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; padding: 40px 20px; margin: 0; -webkit-font-smoothing: antialiased;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        
        <div style="background-color: #0f172a; padding: 40px 20px; text-align: center; border-bottom: 4px solid #0ea5e9;">
            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 800; letter-spacing: 2px;">EVENTIFY</h1>
            <p style="color: #94a3b8; margin: 8px 0 0 0; font-size: 14px; letter-spacing: 1px;">ELEVANDO EL ESTÁNDAR DE LAS CELEBRACIONES</p>
        </div>

        <div style="padding: 40px 30px; text-align: center;">
            <div style="background-color: #f0fdf4; width: 60px; height: 60px; border-radius: 50%; line-height: 60px; margin: 0 auto 20px auto; font-size: 24px;">
                🔒
            </div>
            
            <h2 style="color: #1e293b; margin: 0 0 20px 0; font-size: 22px; font-weight: 700;">Recuperación de Acceso</h2>
            
            <p style="color: #475569; font-size: 16px; line-height: 1.6; margin-bottom: 35px;">
                Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Haz clic en el botón inferior para crear una nueva clave segura.
            </p>
            
            <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" style="display: inline-block; background-color: #0ea5e9; color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 8px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px rgba(14, 165, 233, 0.25);">
                RESTABLECER CONTRASEÑA
            </a>

            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <p style="color: #94a3b8; font-size: 12px; line-height: 1.5; margin: 0;">
                    Este enlace expirará en 60 minutos por razones de seguridad.<br>
                    Si no fuiste tú quien solicitó este cambio, puedes ignorar o eliminar este correo.
                </p>
            </div>
        </div>
    </div>

    <p style="text-align: center; color: #94a3b8; font-size: 12px; margin-top: 20px;">
        &copy; {{ date('Y') }} Eventify. Todos los derechos reservados.
    </p>

</body>
</html>