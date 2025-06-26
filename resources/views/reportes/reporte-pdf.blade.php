<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header {
            text-align: center;
            color: #5E0022;
        }
        .logo {
            width: 100px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #999;
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #5E0022;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/logo-institucional-utec.jpeg') }}" style="width: 40%; height: auto;" alt="Logo"><br>
        <h2>{{ $titulo }}</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Género</th>
                <th>Carrera</th>
                <th>Facultad</th>
                <th>Modalidad</th>
                <th>Fecha</th>
                <th>Ciclo</th>
                <th>Teléfonos</th>
                <th>Correos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resultados as $r)
                <tr>
                    <td>{{ $r->nombre }}</td>
                    <td>{{ $r->genero }}</td>
                    <td>{{ $r->carrera }}</td>
                    <td>{{ $r->facultad }}</td>
                    <td>{{ $r->modalidad }}</td>
                    <td>{{ $r->fecha_graduacion }}</td>
                    <td>{{ $r->ciclo_graduacion }}</td>
                    <td>{{ $r->telefonos }}</td>
                    <td>{{ $r->correos }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>