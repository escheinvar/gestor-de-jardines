@section('title') Admnistrador de camellones @endsection
@section('meta-description') Administrador de mapas de camellones del Sistema Gestor de Jardines @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
<div>
    <h2>Administrador de camellones</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol <b>admin-campus</b> (y al campus sobre el que tenga privilegio)
        {{-- @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif --}}
         @if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif <br>
    </div>
    <div class="row my-3">
        <div class="col-sm-6 col-md-4 form-group">
            <label class="form-label">Campus y jardín</label>
            <select wire:model.live="CampusSelected" class="form-select">
                <option value=""> Indica Campus [jardin]</option>
                @foreach ($campus as $cam)
                    <option value="{{ $cam->ccam_siglas }}">{{ $cam->ccam_name }} [{{ $cam->cjar_name }}]</option>
                @endforeach
            </select>
            <div class="form-text"></div>
        </div>
        <div class="col-sm-6 col-md-4">
            <!-- nuevo camellón -->
            @if($CampusSelected != '')
                <br>
                <a href="/camellon/nuevo_{{ $CampusSelected }}">
                    <button type="button" class="btn btn-secondary">
                        <i class="bi bi-plus-square"></i> Nuevo camellón
                    </button>
                </a>
            @endif
        </div>
    </div>
    <div class="row">
        @if($CampusSelected != '' and $camellones->count() > 0)
            <!-- --------------------------------- MAPA LEAFLET --------------------------- -->
            <div class="col-sm-12 col-md-6" wire:ignore>
                <div id="map"></div>
                <div class="form-text">Si no aparece el mapa, recarga la página (ctrl+R)</div>
            </div>
            <!-- -------------------------------- TABLA DE CAMELLONES ------------------------->
            <div class="col-sm-12 col-md-6 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th><span wire:click="ordena('cjar_siglas')" class="PaClick">Jardin</span> /
                            <span wire:click="ordena('ccam_name')" class="PaClick">Campus</span></th>
                        <th><span wire:click="ordena('cam_camellon')" class="PaClick">Camellón</span></th>
                        <th><span wire:click="ordena('cam_zona')" class="PaClick">Zona</span></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($camellones as $c)
                            <tr wire:click="redirige({{ $c->cam_id }})" class="PaClick @if($c->cam_act == '0') inact @endif">
                                <!-- jardin /campus -->
                                <td>{{ $c->cjar_siglas }} / {{ $c->ccam_name }}</td>
                                <!-- nombre camellon -->
                                <td>
                                    {{ $c->cam_camellon }} @if($c->cam_camellonname != '')/ {{ $c->cam_camellonname }} @endif
                                    {{-- <div style="display:inline-block;width:20px;background-color:{{ $c->cam_color }}"> &nbsp; </div> --}}
                                </td>

                                <!-- nombre de zona-->
                                <td>{{ $c->cam_zona }} @if($c->cam_zonaname != '') / {{ $c->cam_zonaname }} @endif</td>
                                <!-- Mapa y editor -->
                                <td>
                                    @if($c->cam_mapa == '')
                                        <i class="bi bi-geo-alt" style="color:{{ $c->cam_color }};"></i>
                                    @else
                                        <i class="bi bi-geo-alt-fill" style="color:{{ $c->cam_color }};"></i>
                                    @endif
                                    <i class="bi bi-pencil-square"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($camellones->count() == 0) -- Aún no hay camellones registrados -- @endif
            </div>
        @endif
    </div>


    <script>
        /* ---- Función accesoria de Abre Mapa de Camellones para poner etiquetas --- */
        function onEachFeature(feature,layer){
            // console.log(feature);
            if (feature.properties) {
                let popupContent = "Camellón: <b>" + feature.properties.SisGesJarCamellon + "</b>"; // Assuming a 'name' property
                popupContent += "<br><a href='/camellon/" + feature.properties.SisGesJarId + "'><i class='bi bi-pencil-square'></i>Editar</a>";
                layer.bindPopup(popupContent);
            }
        }

        /* ----------------------------------------------------------------------------- */
        /* -------------- Abre Mapa de Camellones en LeafLet --------------------------- */
        /* -------------- Recibe instrucciones de MapaCamellones() --------------------- */
        Livewire.on('IniciaMapaCamellones', (event) => {
            // console.log('Datos:',event.zoom, event.x, event.y);
            ///// Genera espacio de mapa
            var map = L.map('map',{maxZoom:24}).setView([event.y, event.x], event.zoom  );
            ///// Envía fondo de streetMap
            if(event.streetmap==1){
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            }
            ///// Recibe array de camellones
            event.mapas.forEach(function(mapita) {
                console.log("va3:",mapita.cam_id);
                ///// convierte texto recibido en geoJson
                // var geojsonFeature =JSON.parse(mapita.cam_mapa)
                var geojsonFeature =mapita.cam_mapa
                ///// Detecta color
                if(event.DestacaId != 'null'){
                    if(mapita.cam_id == event.DestacaId){
                        var color=mapita.cam_color;
                        var opacidad=1.0;
                        var linea=1;
                    }else{
                        var color='#A8A8A8';
                        var opacidad=0.25;
                        var linea=0;
                    }
                }else{
                    var color=mapita.cam_color;
                    var opacidad=0.15;
                    var linea=1;
                }
                ///// Plotea el Json del polígono
                L.geoJSON(geojsonFeature,{
                    onEachFeature: onEachFeature, //ejecuta función  onEachFeature,
                    style:{
                        "color":color,
                        "weight": linea,
                        "opacity": opacidad
                    },

                }).addTo(map);
            });
        });

        /* ------------ Cierra Mapa de Leaflet ---------- */
        Livewire.on('CierraMapa', (event) => {
            $("#map").replaceWith(`<div id="map">`)
        });

    </script>








</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts')

@endsection


