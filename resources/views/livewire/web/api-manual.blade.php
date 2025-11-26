{{-- @extends('plantillas.base') --}}

@section('title') Manual API @endsection
@section('meta-description') Manual de uso de la API del Sistema Gestor de Jardines @endsection
<!-- silenciar banner if required -->
@if(Auth()->user())
    @section('cintillo-ubica') -> {{ request()->path() }} @endsection
    @section('cintillo') &nbsp; @endsection

@else
    @section('banner') banner-2lineas @endsection <!-- banner-1linea banner-2lineas banner-3lineas -->
    @section('banner-title') Manual de uso<br>de API @endsection
    @section('banner-img') imagen1 @endsection <!-- imagen1 a imagen10 -->
@endif


<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
{{-- @section('main-Nolivewire')@endsection --}}
<div>
    <h2>Manual de API</h2>

    @if(Auth()->user() AND array_intersect(['api','api-read'],session('rol')))
        <div style="background-color: #CDC6B9;padding:5px;">
            <h3>Token {{ Auth()->user()->email }}</h3>
            @if(Auth()->user()->api_token != '')
                <!-- token -->
                <textarea wire:model="token" class="form-control" id="ElToken" rows=3 style="width:95%;display: inline-block;"></textarea>
                <!-- copiar a clipboard-->
                <i onclick="copyToClipboard()"  class="bi bi-clipboard2-check PaClick"></i>
                <!-- botón logout-->
                <button wire:click="logoutToken()" wire:loading.attr="disabled" wire:target="logoutToken"  class="btn btn-sm btn-primary m-2">Logout tocken</button>
                <red wire:loading wire:target="logoutToken()" style="display:none"> Cancelando token... por favor, espera.</red>
            @else
                <div class="row">
                    <!-- botón login -->
                    <div class="col-sm-9 col-md-4">
                        <label class="form-label">Contraseña</label>
                        <input type="password" wire:model="passwd" class="form-control">
                        @error('passwd')<error>{{ $message }}</error>@enderror
                    </div>
                    <div class="col-sm-3 col-md-8"> <br>
                        <button wire:click="loginToken()"  wire:loading.attr="disabled" wire:target="loginToken" class="btn btn-sm btn-primary m-2">Solicitar tocken</button>
                    </div>
                </div>
                <red wire:loading wire:target="loginToken()" style="display:none"> Cargando token... por favor, espera.</red>
            @endif
            {{ $mensaje }}
        </div>

    @endif

    <div style="margin-top:30px;">
        <div style="margin-top: 10px; margin-bottom:10px;">
            <h3>Camellones y campus</h3>
            <p>Regresa un listado de camellones.</p>
            <div style="background-color:blue;padding:10px;color:wheat;display:inline-block;">GET</div>
            <div style="display:inline-block; font-weight:bold;font-size:110%;">/api/camellones </div>
            <div style="display:inline-block;font-size:80%;margin-left:20px;"> Listado de camellones y sus mapas</div>
            <div style="margin-top:10px;">
                <b onclick="VerNoVer('head','Camellon')" class="PaClick">Headers</b>
                <ul id="sale_headCamellon" style="display: none;">
                    <li><red><b>Accept</b></red> application/json</li>
                    <li><red><b>Authorization</b></red> bearer {token}
                </ul>

            </div>
            <div style="margin-top:10px;">
                <b onclick="VerNoVer('par','Camellon')" class="PaClick">Parámetros</b>
                <ul id="sale_parCamellon" style="display: none;">
                    <li><red><b>paginar</b></red> permite subdividir la petición en páginas de tamaño determinado. Como valor se indica el número de registros por página</li>
                    <li><red><b>filtro[campo][operador]</b></red> para generar filtros de búsqueda indicando como [campo] el nombre
                        de la columna solicitada y [operador] alguno de los siguientes: =,>,<,>=,<=,!=,ilike <br>
                        Se puede incluir más de un parámetro filtro, en cuyo caso aplicará el lógico AND entre ellos</li>
                    <li><red><b>selecciona</b></red>: para seleccionar las columnas que se desea obtener. Como valor, se indican los
                        nombres de las columnas solicitadas, sepearadas por coma.</li>
                    <li><red><b>ordena</b></red>: ordena los datos por el campo indicado como valor. Si se desea ordenar de manera
                    descendente, anteponer una barra media antes del nombre.
                    Se puede incluir más de un parámetro orden en la petición.</li>
                </ul>
            </div>
            <div style="margin-top:10px;">
                <b onclick="VerNoVer('camp','Camellon')" class="PaClick">Campos</b>
                <ul id="sale_campCamellon" style="display:none;">
                    <li><b><red>cjar_id</red></b> Número id único del jardín.
                    <li><b><red>cjar_name</red></b> Texto del nombre corto del jardín.
                    <li><b><red>cjar_siglas</red></b> Texto con siglas únicas del nombre del jardín.
                    <li><b><red>ccam_id</red></b> Número id único del campus.
                    <li><b><red>ccam_name</red></b> Texto con nombre corto del campus.
                    <li><b><red>ccam_siglas</red></b> Texto con siglas únicas del nombre del campus.
                    <li><b><red>ccam_nombre</red></b> Texto con nombre corto del campus.
                    <li><b><red>cam_id</red></b> Número id único del camellón.
                    <li><b><red>cam_camellon</red></b> Texto con el nombre corto del camellón.
                    <li><b><red>cam_camellonname</red></b> Texto con el nombre completo del camellón.
                    <li><b><red>cam_zona</red></b> Texto con el nombre corto de la zona en la que se encuentra el camellón.
                    <li><b><red>cam_zonaname</red></b> Texto con el nombre completo de la zona en la que se encuentra el camellón.
                    <li><b><red>cam_mapa</red></b> Json con el polígono georeferenciado del camellón.
                    <li><b><red>cam_xmin</red></b> Coordenadas X extremo mínimas del camellón.
                    <li><b><red>cam_xmax</red></b> Coordenadas X extremo máximas del camellón.
                    <li><b><red>cam_ymin</red></b> Coordenadas Y extremo mínimas del camellón.
                    <li><b><red>cam_ymax</red></b> Coordenadas Y extremo máximas del camellón.
                    <li><b><red>cam_ctroy</red></b> Número decimal con la latitud-Y del centro geográfico del camellón.
                    <li><b><red>cam_zoom</red></b> Número entre 1 y 25 que refiere al zoom predeterminado para ver el camellón.
                </ul>
            </div>
        </div>
    </div>

    <div style="margin-top:30px;">
        <h3>Campus y Camellones</h3>

        <p>Regresa un listado de ... Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut obcaecati quos perferendis iusto earum inventore soluta minima quia, vel ab omnis aperiam vero, voluptatum maiores nihil odio magnam quae possimus.</p>
        <div>
            <div style="background-color:blue;padding:10px;color:wheat;display:inline-block;">PUT</div>
            <div style="display:inline-block;">/api/v4/assessment/{assessment_id} </div>
            <div style="display:inline-block;font-size:80%;margin-left:20px;">    Retrieves an assessment</div>
        </div>
    </div>
</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts')
    <script>
        async function copyToClipboard() {
            const textToCopy = document.getElementById("ElToken").value;

            try {
                await navigator.clipboard.writeText(textToCopy);
                alert("Token copiado al portapapeles");
            } catch (err) {
                console.error('Failed to copy text: ', err);
                alert("Error al copiar token.");
            }
        }
</script>
@endsection
