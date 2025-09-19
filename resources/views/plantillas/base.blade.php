<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TITULO -->
    <title>@yield('title')</title>

    <!--META DESCRIPCIÓN-->
    <meta name="description" content=@yield('meta-description')>

    <!--FAVICON-->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!--GOOGLE FONTS-->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@600;700&family=Roboto&family=Roboto+Condensed&display=swap" rel="stylesheet"> --}}

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- <!--CSS OWL CAROUSEL-->
    <link rel="stylesheet" href="/owlcarousel/assets/owl.carousel.css">
    <link rel="stylesheet" href="/owlcarousel/assets/owl.theme.default.css"> --}}

    <!--css FANCYBOX-->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"> --}}

    <!--  LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!--- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <!-- HOJA DE ESTILOS  y JS -->
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/style2.css">
    <script src="{{asset('MyJs.js')}}"></script>

    @livewireStyles
</head>

<body>
    @livewireScripts
    <header>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <!-- -------------------------------- INICIA BARRA DE MENÚ -------------------------------------------------- -->
        <nav class="navbar navbar-expand-md texto-nav fondo-nav" aria-label="Offcanvas navbar large">
            <div class="container-fluid px-4 py-1" id="header">

                <!--Logo-->
                <a class="navbar-brand p-0 ms-3" href="/">
                    <img src="/imagenes/logo-nav.png" alt="logo del sistema" style="width:90px;">
                </a>

                <!--botón hamburguesa-->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!--Menú superior   -->
                <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                    <div class="offcanvas-header">
                        <a class="offcanvas-logo" href="index.html" id="offcanvasNavbar2Label">
                            <img src="/imagenes/logo-nav.png" alt="logo del Jardín Etnobotánico">
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1">
                            <!-- -------------------------------------------------------------------------------- -->
                            <!-- -------------------- INICIA MENÚ SISTEMA --------------------------------------- -->
                            @if(Auth::user())
                                <li class="nav-item">
                                    <a class="nav-link @if(request()->path() == 'home') active @endif" href="/home">
                                        Home
                                    </a>
                                </li>

                                <!--dropdown 1-->
                                @if(in_array('admin',session('rol')))
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle @if(in_array(request()->path(),['recorridos','mapa'])) active @endif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Admin
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item @if(request()->path() == 'usuarios') active @endif" href="/usuarios">Usuarios</a></li>
                                            <li><a class="dropdown-item @if(request()->path() == 'laespecie') active @endif" href="/laespecie">Jardines y Campus</a></li>
                                            {{-- <li><a class="dropdown-item @if(request()->path() == 'elclavo/busca') active @endif" href="/elclavo/busca">Clavo</a></li> --}}
                                        </ul>
                                    </li>
                                @endif

                                {{-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle @if(in_array(request()->path(),['recorridos','mapa'])) active @endif" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Cédulas
                                    </a>
                                    @if(in_array('cedulas',session('rol')) or in_array('traduce',session('rol')))
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item @if(request()->path() == 'catCedulas') active @endif" href="/catCedulas">Catálogo de Cédulas</a></li>
                                            <li><a class="dropdown-item @if(request()->path() == 'especies') active @endif" href="/especies">Especies del jardín</a></li>
                                            <li><a class="dropdown-item @if(request()->path() == 'especiesixmx') active @endif" href="/especiesixmx">Especies de IxMx</a></li>
                                        </ul>
                                    @endif
                                </li> --}}

                                <li class="nav-item">
                                    <a class="nav-link @if(request()->path() == '') active @endif" href="#">
                                        ?
                                    </a>

                                </li>

                                <!---->
                                <li class="nav-item">
                                    <form action="{{route('logout')}}" method="post">
                                        @csrf
                                        <button type="submit" class="nolink btn" style="padding:0;margin:0;">
                                                Salir
                                        </button>
                                    </form>
                                </li>
                            @else
                                <!-- -------------------------------------------------------------------------------- -->
                                <!-- -------------------- INICIA MENÚ PÚBLICO --------------------------------------- -->
                                <li class="nav-item">
                                    <a class="nav-link @if(request()->path() == 'ingreso') active @endif" href="/ingreso">
                                        Ingresar
                                    </a>
                                </li>

                                {{-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle @if(in_array(request()->path(),['recorridos','mapa'])) active @endif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Admin
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item @if(request()->path() == 'usuarios') active @endif" href="/usuarios">Usuarios y roles</a></li>
                                        <li><a class="dropdown-item @if(request()->path() == 'catalogo/campus') active @endif" href="/catalogo/campus">Catálogo de Jardines y Campus</a></li>
                                    </ul>
                                </li> --}}

                                <li class="nav-item">
                                    <a class="nav-link @if(request()->path() == '') active @endif" href="#">
                                        ?
                                    </a>
                                </li>
                                <!-- -------------------- TERMINA MENÚ PÚBLICO --------------------------------------- -->
                                <!-- -------------------------------------------------------------------------------- -->

                            @endif
                            <!-- -------------------- TERMINA MENÚ SISTEMA --------------------------------------- -->
                            <!-- -------------------------------------------------------------------------------- -->
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- -------------------------------- TERMINA BARRA DE MENÚ -------------------------------------------------- -->
        <!-- ------------------------------------------------------------------------------------------------------ -->

        <!-- ------------------------------------------------------------------------------------------------------ -->
        <!-- -------------------------------- INICIA BANNER -------------------------------------------------- -->
        @hasSection('banner')
            <section class="@yield  ('banner') pb-5">
                <div class="container-fluid p-0">
                    <div class="row inicio @yield('banner-img')">
                        <div class="col-12 text-end p-0">
                            <h1>@yield('banner-title')</h1>
                        </div>
                    </div>
                    <div class="row redes-header text-start">
                        <div class="col iconos">
                            <a href="https://www.facebook.com/jardinoaxaca" target="_blank">
                                <img src="/imagenes/icono-facebook.png" alt="icono facebook">
                            </a>
                            <a href="https://www.instagram.com/jardinetnobotanicodeoaxaca/" target="_blank">
                                <img src="/imagenes/icono-instagram.png" alt="icono instagram ">
                            </a>
                            <a href="https://www.youtube.com/@jardinetnobiologicodeoaxaca" target="_blank">
                                <img src="/imagenes/icono-youtube.png" alt="icono mapa">
                            </a>
                            <a href="https://goo.gl/maps/vdvcHAUMTHQaDZ676" target="_blank">
                                <img src="/imagenes/icono-mapa.png" alt="icono mapa">
                            </a>
                            <a href="mailto:etnobotanico@infinitummail.com" target="_blank">
                                <img src="/imagenes/icono-correo.png" alt="icono correo">
                            </a>
                        </div>
                        <div class="col">
                            <a href="#bienvenido">
                                <div class="button-scroll-down">
                                    <p>SCROLL</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- -------------------------------- TERMINA BANNER -------------------------------------------------- -->
        <!-- ------------------------------------------------------------------------------------------------------ -->
    </header>

    <!-- ------------------------------------------------------------------------------------------------------ -->
    <!-- -------------------------------- INICIA BARRA DE SISTEMA --------------------------------------------- -->
    <a name="bienvenido"></a>
    @hasSection('cintillo-ubica')
        <div style="background-color:#CDC6B9;  padding-left:15px; color: #87796d; font-family: 'Roboto Condensed', sans-serif;padding:3px;">
            <b>Gestor de Jardines</b>
            @yield('cintillo-ubica')&nbsp; |
            @if(Auth::user())&nbsp; <b>{{ Auth::user()->usrname }}</b> &nbsp; | @endif &nbsp;

            <!-- Indicador de Buzón -->
            @if(Auth::user())
                @if( session('buzon') > 0 )
                    <a href="/buzon" class="nolink">
                        <span style="border:1px solid #CD7B34;padding:1px;color:#CD7B34; font-weight:bold">
                            <i class="bi bi-envelope-fill"></i>
                            {{ session('buzon') }}
                            @if(session('buzon') =='1')mensaje @else mensajes @endif
                        </span>
                    </a>
                @else
                    <a href="/buzon" class="nolink">
                        <i class="bi bi-envelope"></i> Buzón &nbsp;
                    </a> |
                @endif
            @endif

            @yield('cintillo')
        </div>
    @endif
    <!-- -------------------------------- TERMINA BARRA DE SISTEMA --------------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------ -->



    <!-- ------------------------------------------------------------------------------------------------------ -->
    <!-- ----------------------------------- INICIA ZONA DE CONTENIDO  ---------------------------------------- -->
    <div class="p-5" style="background-color:#efebe8;">
        <div class="container py-5 px-3">

            @if(isset($slot))
                <!--  CARGA SLOT DE LIVEWIRE -->
                {{ $slot }}
            @else
                @yield('main-Nolivewire')
            @endif
        </div>
    </div>
    <!-- ----------------------------------- TERMINA ZONA DE CONTENIDO  ---------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------ -->



    <!-- ------------------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------------ INICIA FOOTER  -------------------------------------------- -->
    <footer>
        <div class="container-fluid ">
            <div class="row justify-content-around p-5">

                <!--Primera columna-->
                <div class="col-sm-12 col-xl-12 col-xxl-3 mb-4 botones">
                    <div class="row pb-3">
                        <div class="col">
                            <a href="/">
                                <img src="/imagenes/logo-footer.png" class="logo" alt="Logo del Jardín" style="width:100px;">
                            </a>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <a href="/" class="nolink">Sistema Gestor de Jardines</a>
                        </div>
                    </div>

                    <div class="row pt-2 justify-content-center redes_footer">
                        <div class="col iconos">
                            <a href="https://www.facebook.com/jardinoaxaca" target="_blank">
                                <img src="/imagenes/icono-facebook.png" alt="icono facebook">
                            </a>
                            <a href="https://www.instagram.com/jardinetnobotanicodeoaxaca/" target="_blank">
                                <img src="/imagenes/icono-instagram.png" alt="icono instagram ">
                            </a>
                            <a href="https://www.youtube.com/@jardinetnobiologicodeoaxaca" target="_blank">
                                <img src="/imagenes/icono-youtube.png" alt="icono mapa">
                            </a>
                            <a href="https://goo.gl/maps/vdvcHAUMTHQaDZ676" target="_blank">
                                <img src="/imagenes/icono-mapa.png" alt="icono mapa">
                            </a>
                            <a href="mailto:etnobotanico@infinitummail.com" target="_blank">
                                <img src="/imagenes/icono-correo.png" alt="icono correo">
                            </a>

                        </div>
                    </div>
                </div>

                <!--Segunda columna-->
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 mt-4">
                    <div class="row">
                        <div class="col">
                            <div class="col pb-2">
                                <h5>Programación y mantenimiento</h5>
                                <p>Enrique Scheinvar <br> Investigador por México, Secihti/JebOax<br>enrique.scheinvar@secihti.mx</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h5>Diseño web</h5>
                            <p>Alma Lizeth Pérez Bautista<br> Servicio social, JebOax, 2023<br></p>
                            <p>Enrique Scheinvar<br>Investigador por México Secihti/JebOax, 2025</p>
                        </div>
                    </div>
                </div>

                <!--Tercera columna-->
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xxl-3 mt-4">
                    <h5><a href="#" class="nolink">Licencia</a></h5>
                    <p>Este software se distribuye bajo la Licencia Pública General de GNU (GPL) versión 3, lo que significa que es software libre: puedes usarlo, copiarlo, modificarlo y redistribuirlo bajo los términos de la licencia. El código fuente está disponible públicamente para fomentar la transparencia, la auditoría técnica y el desarrollo colaborativo.</p>
                </div>

                <!--Cuarta columna-->
                {{-- <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2 mt-4">
                    <div class="row">
                        <div class="col">
                            <h5>Horario de oficinas</h5>
                            <p>Oficina<br>Lunes - Viernes: 10:00 a 17:00 horas<br></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <p>Biblioteca<br>Lunes-Viernes: 9:00 a 17:00 horas<br></p>
                        </div>
                    </div>
                </div> --}}

                <!--Quinta columna-->
                <div class="col-sm-12 col-lg-12 col-xl-1 col-xxl-1 mt-4 mb-4 pt-5">
                    <a href="#header">
                        <div class="button-scroll-up">
                            <p>SUBIR</p>
                        </div>
                    </a>
                </div>

            </div>
            <div style="width: 100%; background-color:white; ">
                <center>
                    <img src="/imagenes/pleca.png" style=" width:70%;center;">
                </center>
            </div>
        </div>
    </footer>
    <!-- ------------------------------------------ TERMINA FOOTER  -------------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------ -->




    <!-- ------------------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------- INICIA ZONA DE SCRIPTS  ---------------------------------------- -->
    <!--BOOTSTRAP 5-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!--CDN JQUERY-->
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <!--owl carousel-->
    {{-- <script src="/owlcarousel/owl.carousel.js"></script> --}}
    <script>
        // $(document).ready(function () {
        //     $(".owl-carousel").owlCarousel({
        //         loop: true,
        //         margin: 10,
        //         dotsEach: 1,
        //         // nav:true
        //         autoplay: true,
        //         autoplayTimeout: 8000,
        //         autoplaySpeed: 5000,
        //         responsive: {
        //             0: {
        //                 items: 1
        //             },
        //             576: {
        //                 items: 1
        //             },
        //             992: {
        //                 items: 1
        //             }
        //         }

        //     });
        // });
    </script>

    <!--fancybox-->
    {{-- <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Your custom options
        });
    </script> --}}

    @yield('scripts')
    <!-- ------------------------------------- TERMINA ZONA DE SCRIPTS  ---------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------ -->


</body>

</html>
