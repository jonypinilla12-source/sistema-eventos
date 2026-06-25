<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body style="background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; padding: 40px 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        
        <div style="background-color: #10b981; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">¡Ka-ching! Nueva Venta 🎉</h1>
        </div>

        <div style="padding: 30px;">
            <p style="color: #475569; font-size: 16px;">Hola Administrador,</p>
            <p style="color: #475569; font-size: 16px;">El sistema acaba de procesar un pago exitoso a través de MercadoPago y ha autogenerado un nuevo evento.</p>

            <div style="background-color: #f1f5f9; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #0f172a; border-bottom: 1px solid #cbd5e1; padding-bottom: 10px;">Datos del Cliente</h3>
                <p style="margin: 5px 0; color: #334155;"><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
                <p style="margin: 5px 0; color: #334155;"><strong>Email:</strong> {{ $cliente->email }}</p>
            </div>

            <div style="background-color: #eff6ff; padding: 20px; border-radius: 8px; margin: 20px 0 border: 1px solid #bfdbfe;">
                <h3 style="margin-top: 0; color: #1e3a8a; border-bottom: 1px solid #bfdbfe; padding-bottom: 10px;">Datos del Evento Creado</h3>
                <p style="margin: 5px 0; color: #1e40af;"><strong>Plan Contratado:</strong> {{ $plan }}</p>
                <p style="margin: 5px 0; color: #1e40af;"><strong>Nombre Evento:</strong> {{ $evento->nombre_evento }}</p>
                <p style="margin: 5px 0; color: #1e40af;"><strong>Fecha Evento:</strong> {{ \Carbon\Carbon::parse($evento->fecha_principal)->format('d/m/Y') }}</p>
                <p style="margin: 5px 0; color: #1e40af;"><strong>Carpeta OneDrive:</strong> {{ $evento->onedrive_folder_id ? 'Creada Exitosamente ✅' : 'Fallo en creación ❌' }}</p>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/login') }}" style="display: inline-block; background-color: #0f172a; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 6px; font-weight: bold;">
                    Ir al Panel de Administración
                </a>
            </div>
        </div>
    </div>
</body>
</html>