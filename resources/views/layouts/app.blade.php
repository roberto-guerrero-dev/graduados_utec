<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatablesb5theme/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/sweetalert/dist/sweetalert2.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('lib/datatables/datatables.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('lib/select2/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/fontawesome/fontawesome-free-6.7.2-web/css/all.min.css') }}" rel="stylesheet">
</head>
<body>
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --width-sidebar: 200px;
            --width-content: calc(100% - var(--width-sidebar));
            --height-li-img: 133.45px;
            --bg-primary-custom: #5E0022;
        }
        .bg-primary-custom {
            background-color: var(--bg-primary-custom) !important;
            color: white !important;
        }
        html, body {
            margin: 0;
            padding: 0;
        }
        #main-container {
            min-height: 100dvh;
            display: grid;
            grid-template-rows: auto 1fr auto;
            margin-left: var(--width-sidebar);
            transition: all 0.5s ease-in-out;
            word-wrap: break-word;
        }
        #main-container.adjusted {
            margin-left: 60px;
        }
        header.topbar {
            background-color:#f5f5f5;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end;
            box-shadow: 0 2px 10px #a5a5a5;
        }
        footer {
            background-color: #f9f9f9;
            color: #a5a5a5;
            text-align: center;
            padding: 10px 20px;
            border-top: 1px solid #e5e5e5;
        }
        main {
            transition: all 0.5s ease-in-out;
            padding: 10px 20px;
        }
        /* body {
            background: linear-gradient(45deg,rgb(184, 129, 149), #bf0046);
        } */
        #toggleSidebar {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000;
            cursor: pointer;
            margin-left: var(--width-sidebar);
            transition: margin-left 0.5s ease-in-out;
            color: #5E0022;
        }
        #sidebar {
            position: fixed;
            top: 10;
            left: 0;
            width: var(--width-sidebar);
            height: 100%;
            background-color: #5E0022;
            color: white;
            transition: width 0.5s ease-in-out;
        }
        #sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        #sidebar ul li a {
            padding: 10px 20px;
            display: grid;
            grid-template-columns: 40px 1fr;
            align-items: center;
            color: white;
            text-decoration: none;
            opacity: 1;
        }
        .option_text {
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }
        #sidebar ul li a:hover {
            background-color: #8f0738;
        }
        #sidebar ul li a.active {
            background-color: #8f0738;
            border-left: 3px #fff solid;
        }
        #logo-utec {
            max-width: 100px;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }
        .no_redirect_element {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
            height: var(--height-li-img);
        }
        #sidebar.option_text.hide_element {
            grid-template-columns: 40px 0fr;
        }
        .option_text.hide_element {
            opacity: 0;
        }
        #logo-utec.hide_element {
            opacity: 0;
        }
        #sidebar.sidebar_shrink {
            width: 60px;
        }
        .dropdown-menu-sm .dropdown-item {
            padding: 5px; /* Ajusta el espaciado */
            font-size: 14px;     /* Coincide con btn-sm */
            margin: 0; /* Elimina el margen */
        }
        .dropdown-menu{
            padding: 0;
            margin: 0;
        }

    </style>
    <aside id="sidebar" class="">
            <ul>
                <li class="no_redirect_element">
                    <img src="{{ asset('img/logo-utec.png') }}" alt="Logo UTEC" id="logo-utec" class="">
                </li>
                <li><a href="{{ url('/home') }}" class="{{ request()->is('home') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>  <span class="option_text">Inicio</span></a></li>
                <li><a href="{{ url('/graduados/form') }}" class="{{ request()->is('graduados/form') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i>  <span class="option_text">Graduados</span></a></li>
                <li><a href="{{ url('/facultades') }}" class="{{ request()->is('facultades') ? 'active' : '' }}">
                <i class="fas fa-building-columns"></i>  <span class="option_text">Facultades</span></a></li>
                <li><a href="{{ url('/carreras') }}" class="{{ request()->is('carreras') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i>  <span class="option_text">Carreras</span></a></li>
                <li><a href="{{ url('/graduados/reporte') }}" class="{{ request()->is('graduados/reporte') ? 'active' : '' }}">
                <i class="fas fa-file-lines"></i>  <span class="option_text">Reportes</span></a></li>
                <li><a href="{{ url('/usuarios') }}" class="{{ request()->is('usuarios') ? 'active' : '' }}">
                <i class="fas fa-users"></i>  <span class="option_text">Usuarios</span></a></li>
            </ul>
        </aside>
<div class="hamburger" id="toggleSidebar"><i id="toggle" class="fa-solid fa-xmark"></i></div>
    <div id="main-container" class="">
        <header class="topbar">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>

            <!-- Dropdown -->
            <div class="dropdown">
            <button class="btn bg-primary-custom btn-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user"></i> {{ strtoupper(Auth::user()->name) }}
            </button>
            <ul class="dropdown-menu dropdown-menu-sm w-100" aria-labelledby="userDropdown">
                <li>
                <a class="dropdown-item" href="#"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
         Cerrar sesión
      </a>
                </li>
            </ul>
            </div>

        </header>

        <main class=" mt-4">
            @yield('content')
        </main>

        <footer>
                <p>&copy; {{ date('Y') }} Mi Aplicación. Todos los derechos reservados.</p>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('lib/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/sweetalert/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/utils/customSweetAlert.js') }}"></script>
    <!-- <script src="{{ asset('lib/datatables/datatables.min.js') }}"></script> -->
    <script src="{{ asset('lib/datatablesb5theme/datatables.min.js') }}"></script>
    <script src="{{ asset('lib/select2/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>

    <script>
        $(function() {

            $('#toggleSidebar').on('click', function() {
                $('#sidebar').toggleClass('sidebar_shrink');
                $('#main-container').toggleClass('adjusted');
                $('#toggle').toggleClass('fa-xmark fa-bars');
                $('#logo-utec').toggleClass('hide_element');
                $('.option_text').toggleClass('hide_element');
                $(this).css('margin-left', $('#sidebar').hasClass('sidebar_shrink') ? '60px' : '200px');
            });
        });

    </script>
    @yield('scripts')
</body>
</html>
