<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- DataTables Buttons -->
<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

</head>
<body>
    <style>
        body {
            overflow-x: hidden;
        }
        #sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #5E0022;
            color: white;
            transition: left 0.3s;
            z-index: 1000;
        }

        #sidebar.active {
            left: 0;
        }

        #sidebar ul {
            list-style: none;
            padding: 0;
        }

        #sidebar ul li a {
            color: white;
            display: block;
            padding: 15px;
            text-decoration: none;
        }

        #sidebar ul li a:hover {
            background-color: #870031;
        }

        #sidebar ul li a.active {
            background-color: #870031;
            font-weight: bold;
        }

        #content {
            margin-left: 0;
            transition: margin-left 0.3s;
            padding: 20px;
        }

        #content.shifted {
            margin-left: 250px;
        }

        .topbar {
            background-color: #e9ecef;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hamburger {
            font-size: 24px;
            cursor: pointer;
        }
    </style>

<div id="sidebar" class="active">
    <ul>
        <li><a href="{{ url('/home') }}" class="{{ request()->is('home') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i> Inicio</a></li>
        <li><a href="{{ url('/graduados/form') }}" class="{{ request()->is('graduados') ? 'active' : '' }}">
        <i class="bi bi-mortarboard-fill"></i> Graduados</a></li>
        <li><a href="{{ url('/facultades') }}" class="{{ request()->is('facultades') ? 'active' : '' }}">
        <i class="bi bi-building"></i> Facultades</a></li>
        <li><a href="{{ url('/carreras') }}" class="{{ request()->is('carreras') ? 'active' : '' }}">
        <i class="bi bi-briefcase-fill"></i> Carreras</a></li>
        <li><a href="{{ url('/graduados/form') }}" class="{{ request()->is('graduados/form') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-bar-graph-fill"></i> Reportes</a></li>
        <li><a href="{{ url('/usuarios') }}" class="{{ request()->is('usuarios') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Usuarios</a></li>
    </ul>
</div>

    <div id="content" class="shifted">
        <div class="topbar">
            <div class="hamburger" id="toggleSidebar">&#9776;</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-dark btn-sm">Cerrar sesión</button>
            </form>
        </div>

        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables CSS -->

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables Buttons y dependencias -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#toggleSidebar').click(function() {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('shifted');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
