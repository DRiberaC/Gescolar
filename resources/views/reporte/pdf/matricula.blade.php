<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Matrícula</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-top: 30px;
        }

        .row-data {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .footer {
            text-align: right;
            margin-top: 50px;
        }

        /* Estilos adicionales para las tablas */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <table>

        <tr>
            <td class="text-center">
                <h3>
                    Matrícula estudiantil
                </h3>
            </td>
        </tr>

        <tr>
            <td class="text-center">
                <b>{{ $configuracion->nombre }}</b>
                <br />
                {{ $configuracion->descripcion }}
                <br />
                {{ $configuracion->direccion }}
                <br />
                {{ $configuracion->telefono }}
                <br />
                {{ $configuracion->correo_electronico }}
            </td>
        </tr>
    </table>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Información del Estudiante</th>
                <th scope="col">Información de la Matrícula</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <p><strong>Nombre:</strong> {{ $matricula->estudiante->nombre }}</p>
                    <p><strong>Fecha de Nacimiento:</strong> {{ $matricula->estudiante->fecha_nacimiento }}</p>
                    <p><strong>Teléfono:</strong> {{ $matricula->estudiante->telefono }}</p>
                </td>
                <td>
                    <p><strong>Gestión:</strong> {{ $matricula->gestion->nombre }}</p>
                    <p><strong>Periodo:</strong> {{ $matricula->periodo->nombre }}</p>
                    <p><strong>Nivel:</strong> {{ $matricula->nivel->nombre }}</p>
                    <p><strong>Grado:</strong> {{ $matricula->grado->nombre }}</p>
                    <p><strong>Paralelo:</strong> {{ $matricula->paralelo->nombre }}</p>
                    <p><strong>Fecha de Inscripción:</strong> {{ $matricula->fecha }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Tabla para mostrar la configuración -->


    <div class="footer">
        <p>&copy; {{ date('Y') }} Sistema de Matrícula</p>
    </div>
</body>

</html>
