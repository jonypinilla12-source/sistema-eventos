<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus Credenciales - Eventify</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; color: #334155;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" max-width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); max-width: 600px; width: 100%;">
                    
                    <tr>
                        <td style="background-color: #4f46e5; padding: 40px 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: bold; letter-spacing: 1px;">EVENTIFY</h1>
                            <p style="color: #e0e7ff; margin: 10px 0 0 0; font-size: 16px;">Elevando el estándar de las celebraciones</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="margin: 0 0 20px 0; color: #1e293b; font-size: 24px;">¡Felicidades, {{ $usuario->nombre }}! 🎉</h2>
                            <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.6; color: #475569;">
                                Tu pago para el plan <strong>{{ $evento->nombre_evento }}</strong> ha sido procesado con éxito. Hemos preparado todo para que puedas empezar a diseñar tu evento ahora mismo.
                            </p>
                            <p style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.6; color: #475569;">
                                Aquí tienes tus credenciales de acceso seguro como anfitrión:
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f1f5f9; border-radius: 12px; border-left: 4px solid #4f46e5;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <p style="margin: 0 0 15px 0; font-size: 15px;">
                                            <span style="color: #64748b; font-weight: bold; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Usuario / Correo:</span><br>
                                            <span style="color: #0f172a; font-weight: bold; font-size: 18px;">{{ $usuario->email }}</span>
                                        </p>
                                        <p style="margin: 0; font-size: 15px;">
                                            <span style="color: #64748b; font-weight: bold; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Contraseña temporal:</span><br>
                                            <span style="color: #4f46e5; font-weight: bold; font-size: 22px; letter-spacing: 3px;">{{ $password }}</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 40px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('login') }}" style="background-color: #0f172a; color: #ffffff; text-decoration: none; padding: 16px 36px; border-radius: 50px; font-size: 16px; font-weight: bold; display: inline-block; text-transform: uppercase; letter-spacing: 1px;">Ingresar a mi Panel</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 40px 0 0 0; font-size: 13px; line-height: 1.5; color: #64748b; text-align: center;">
                                * Te recomendamos ingresar y cambiar esta contraseña desde tu perfil por motivos de seguridad.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 25px 20px; text-align: center;">
                            <p style="margin: 0; font-size: 13px; color: #94a3b8; line-height: 1.6;">
                                © {{ date('Y') }} Eventify. Todos los derechos reservados.<br>
                                Este es un correo automático, por favor no respondas a este mensaje.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>