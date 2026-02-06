@section('title') Manual del SisGesJar @endsection
@section('meta-description') Manuales de uso del Sistema Gestor de Jardines @endsection
<!-- silenciar banner if required -->
@if(Auth()->user())
    @section('cintillo-ubica') -> {{ request()->path() }} @endsection
    @section('cintillo') &nbsp; @endsection

@else
    @section('banner') banner-2lineas @endsection <!-- banner-1linea banner-2lineas banner-3lineas -->
    @section('banner-title') Manuales de uso<br>del SisGesJar @endsection
    @section('banner-img') imagen1 @endsection <!-- imagen1 a imagen10 -->
@endif


<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
{{-- @section('main-Nolivewire')@endsection --}}
<div>
    <h2>Manuales del Sistema Gestor de Jardines (SiGesJar)</h2>
    <ul>
        <li>Ingresando un nuevo usuario al SiGesJar</li>
        <ul>
            <li> Alta de un nuevo usuario [<error>cualquier usuario</error>]</li>
            <li> Recuperación de contraseña de un usuario [<error>cualquier usuario</error>]</li>
            <li> Editando los datos del usuario [<error>cualquier usuario</error>]</li>
            <li> El buzón del usuario [<error>cualquier usuario</error>]</li>
        </ul>
        <li>Sobre los roles y la asignación de roles [<error>admin, admin-campus</error>])</li>

        <li>Búsqueda en el catálogo de imágenes [<error>admin-campus</error>, admin-colviva curador-cientifico ]</li>
        <li>Búsqueda en el catálogo de autoridades [<error>?</error>]</li>
        <li>Búsqueda en el catálogo de bitácoras [<error>?</error>]</li>
        <li>Ingresando nombres científicos [<error>curador-científico</error>]</li>

        <li>Ingresando un nuevo jardín </li>
        <ul>
            <li> Alta de un nuevo jardín y sus campus en el sistema [<error>admin</error>]</li>
            <li> Creando el mapa de camellones [<error>cualquier usuario</error>] </li>
            <li> Alta de camellones de un campus [<error>admin-campus</error>]</li>
            <li> Creando una grida para digitalizar la colección por cuadrantes [<error>cualquier usuario</error>]</li>
            <li> Alta de gridas de campus [<error>admin-campus</error>]</li>

            <li> Digitalizando la colección por cuadrantes con kobo collect [<error>admin-campus, admin-colviva, curador-cientifico, capturista-colviva</error>]</li>
            <li> Ingresando la información desde kobo collect al SisGesJar</li>
        </ul>

        <li>Ingresando un nuevo ejemplar al SisGesJar</li>
        <ul>
            <li>Creando el ejamplar; Cargando bitácora de colecta; Asignando nombre científico; Asignando nombre común; Asingando etiquetas o identificadores del ejemplar; Indicando la posición del ejemplar en el jardín</li>
        </ul>
    </ul>
    <h3>Roles en el SiGesJar</h3>
    <ul>
        <li><b>Admin</b> Persona sin adscripción a un jardín, que administra el acceso de administradores de jardín, así como de campus y jardines.</li>
        <li><b>admin-campus</b> Persona adscrita a un jardín que administra los camellones de los campus, gridas y usuarios y roles de su jardín.</li>
        <li><b>admin-colviva</b> Persona que adscrita a un jardín que </li>
        <li><b>curador-cientifico</b> Persona que </li>
        <li><b>capturista-colviva</b> Persona que </li>
    </ul>
</div>
