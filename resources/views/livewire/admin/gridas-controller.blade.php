@section('title') Admnistrador de gridas @endsection
@section('meta-description') Administrador de mapas de gridas del Sistema Gestor de Jardines @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
<div>
    <h2>Administrador de Gridas</h2>

    <div class="row">
        <div style="font-size: 80%;color:grey;">
            Este catálogo es administrado por el rol <b>admin-campus</b> (y al campus sobre el que tenga privilegio)
            {{-- @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif --}}
            @if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif <br>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-sm-6 col-md-4 form-group">
            <label class="form-label">Campus y jardín</label>
            <select wire:model="CampusSelected" class="form-select">
                <option value=""> Indica Campus [jardin]</option>
                @foreach ($campus as $cam)
                    <option value="{{ $cam->ccam_siglas }}">{{ $cam->ccam_name }} [{{ $cam->cjar_name }}]</option>
                @endforeach
            </select>
            <div class="form-text"></div>
        </div>

        <div class="col-sm-6 col-md-4 form-group">
            <label class="form-label">Gridas</label>
            <select wire:model="GridaSelected" class="form-select">
                <option value=""> Selecciona una grida </option>
                @foreach ($gridas as $g)
                    <option value="{{ $g->gri_id }}"> {{ $g->gri_name }} [{{ $g->gri_resx }}, {{ $g->gri_resy }}] </option>
                @endforeach
            </select>
            <div class="form-text"></div>
        </div>

        <div class="col-sm-6 col-md-4">
            <!-- nuevo camellón -->
            @if($CampusSelected != '')
                <br>
                <button wire:click="AbrirModalGridas('0')" type="button" class="btn btn-secondary">
                    <i class="bi bi-plus-square"></i> Nueva grida
                </button>
            @endif
        </div>
    </div>


    <div class="row">
        @if($CampusSelected != '' )
            <!-- --------------------------------- MAPA LEAFLET --------------------------- -->
            <div class="col-sm-12 col-md-6" wire:ignore>
                <div id="map"></div>
                <div class="form-text">Si no aparece el mapa, recarga la página (ctrl+R)</div>
            </div>
            <!-- -------------------------------- TABLA DE CAMELLONES ------------------------->
            <div class="col-sm-12 col-md-6 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th><span wire:click="ordena('gri_name')" class="PaClick">Nombre</span></th>
                        <th><span wire:click="ordena('gri_resx')" class="PaClick">Res X</span> /
                            <span wire:click="ordena('gri_resy')" class="PaClick">Res Y</span></th>
                        <th><span wire:click="ordena('gri_explica')" class="PaClick">Explica</span></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($gridas as $g)
                            <tr>
                                <!-- Nombre -->
                                <td>{{ $g->gri_name }}</td>

                                <!-- Resolución X, Y -->
                                <td>{{ $g->gri_resx }} / {{ $g->gri_resy }}</td>

                                <!-- Explicaicón-->
                                <td>{{ $g->gri_explica }}</td>
                                <!-- Mapa y editor -->
                                <td>
                                    <i class="bi bi-pencil-square"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($gridas->count() == 0) -- Aún no hay gridas registrados -- @endif
            </div>
        @endif
    </div>

    <livewire:admin.ModalGridasController>




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
                ///// convierte texto recibido en geoJson
                var geojsonFeature =JSON.parse(mapita.gri_mapa)
                // console.log("gri_id2:",mapita.gri_id, geojsonFeature);

                // L.geoJSON(geojsonFeature).addTo(map);
                /// Plotea el Json del polígono
                L.geoJSON(geojsonFeature,{
                    // onEachFeature: onEachFeature, //ejecuta función  onEachFeature,
                    style:{
                        "color":'#A8A8A8',
                        "weight": 0.5,
                        "opacity": 1.0
                    },

                }).addTo(map);
                console.log("gri_id3:",mapita.gri_id);
            });

        });

        /* ------------ Cierra Mapa de Leaflet ---------- */
        Livewire.on('CierraMapa', (event) => {
            $("#map").replaceWith(`<div id="map">`)
        });

    </script>

</div>
