@section('title') Admnistrador de camellones @endsection
@section('meta-description') Administrador de mapas de camellones del Sistema Gestor de Jardines @endsection
@section('cintillo-ubica') <a href="/camellones" class="nolink">Camellones</a> -> camellón  @endsection
@section('cintillo') &nbsp; @endsection
<div>
    <div class="regresar">
        <a href="/camellones" class="nolink">
            Regresar al administrador de camellones
        </a>
    </div>
    <!-- ------------------- Título ------------------------------- -->
    @if($camID=='nuevo')
        <h3>Ingresando nuevo camellón<br> al campus {{ $campus }}</h3>
    @else
        <h3>Editando camellón {{ $came }}<br> en campus {{ $campus }} </h3>
    @endif


    <div class="row">
        <!-- ------------------------------------------------------------------------------>
        <!-- ------------------------------ MAPA ------------------------------------------>
        @if($camID != 'nuevo')
            <div class="col-sm-12 col-md-6">
                @if($geojson != '')
                    {{-- {{ $temp }} --}}
                    <div wire:ignore>
                        <div id="map"></div>
                        <!-- borrar polígono -->
                        <button type="button" wire:click="BorrarPoligono({{ $camID }})" class="my-2" wire:confirm="Estás por eliminar el polígono y por ende el camellón. Esta acción no se puede revertir y se perderá toda la información asociada. ¿Estás seguro de querer continuar?">
                            <i class="bi bi-trash">Eliminar polígono</i>
                        </button>
                        @error('geojson')<error>{{ $message }}</error>@enderror
                    </div>
                @else
                    <!-- ---------------------------------------------------- -->
                    <!-- ---------- Carga mapa nuevo ----------------------- -->
                    <div class="row">
                        <!-- file geojson -->
                        <div class="col-sm-12 col-md-10 form-group">
                            <label for="NvoGeoJson" class="form-label">Archivo GeoJson<red>*</red></label>
                            <input wire:model="NvoGeoJson" wire:submit="GuardaNuevoMapa()" id="NvoGeoJson" type="file" class="form-control @error('geojson') error @enderror"   accept="application/geo+json" @if($camID=='nuevo') disabled @endif>
                            <div class="form-text">Carga el archivo GeoJson con el polígono del camellón.</div>
                            @error('NvoGeoJson')<error>{{ $message }}</error>@enderror
                            @error('geojson')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- xmin --->
                        {{-- <div class="col-sm-6 col-md-6 form-group">
                            <label for="xmin" class="form-label">Longitud (x) mínima</label>
                            <input wire:model="xmin" id="xmin" type="number" class="form-control" @if($camID=='nuevo') disabled @endif>
                            <div class="form-text">Valor mínimo de coordenadas de longitud (x) de la extensión del polígono del camellón, en sistema decimal (de -180.0 a 180.0).</div>
                            @error('xmin')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- xmax -->
                        <div class="col-sm-6 col-md-6 form-group">
                            <label for="xmax" class="form-label">Longitud (x) máxima</label>
                            <input wire:model="xmax" id="xmax" type="number" class="form-control" @if($camID=='nuevo') disabled @endif>
                            <div class="form-text">Valor máximo de coordenadas de longitud (x) de la extensión del polígono del camellón, en sistema decimal (de -180.0 a 180.0).</div>
                            @error('xmax')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- ymin -->
                        <div class="col-sm-6 col-md-6 form-group">
                            <label for="ymin" class="form-label">Latitud (y) mínima</label>
                            <input wire:model="ymin" id="ymin" type="number" class="form-control" @if($camID=='nuevo') disabled @endif>
                            <div class="form-text">Valor mínimo de coordenadas de latitud (y) de la extensión del polígono del camellón, en sistema decimal (de -90.0 a 90.0).</div>
                            @error('ymin')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- ymax -->
                        <div class="col-sm-6 col-md-6 form-group">
                            <label for="ymax" class="form-label">Latitud (y) máxima</label>
                            <input wire:model="ymax" id="ymax" type="number" class="form-control" @if($camID=='nuevo') disabled @endif>
                            <div class="form-text">Valor máximo de coordenadas de longitud (x) de la extensión del polígono del camellón, en sistema decimal (de -90.0 a 90.0).</div>
                            @error('ymax')<error>{{ $message }}</error>@enderror
                        </div> --}}
                    </div>

                @endif
            </div>
        @endif


        <div class="col-sm-12 col-md-6">
            <div class="row">
                <!-- Jardin -->
                <div class="col-sm-12 col-md-6 form-group">
                    <label class="form-label" for="jardin">Jardín al que pertenece<red>*</red></label>
                    <input wire:model="jardin" id="jardin" type="text" class="form-control" disabled>
                    @error('jardin')<error>{{ $message }}</error>@enderror
                    <div class="form-text"></div>
                </div>

                <div class="col-sm-12 col-md-6 form-group">
                    <label for="campusName" class="form-label">Campus en el que se encuentra<red>*</red></label>
                    <input wire:model="campusName" id="campus" type="text" class="form-control" disabled>
                    @error('campusName')<error>{{ $message }}</error>@enderror
                    <div class="form-text"></div>
                </div>
                <div class="col-sm-12 col-md-6 form-group">
                    <label for="NombreCorto" class="form-label">Nombre corto del camellón<red>*</red></label>
                    <input wire:model.live="NombreCorto" id="NombreCorto"  type="text" class="form-control @error('NombreCorto') error @enderror" >
                    @error('NombreCorto')<error>{{ $message }}</error>@enderror
                    <div class="form-text">Nombre de pocas letras (sin espacios ni caracteres)  <b>y único</b> que utilizará el sistema para identificar el camellón. Recomendamos usar como prefijo las siglas del jardín ej: JebOax_A1 </div>
                </div>
                @if($camID != 'nuevo')
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="NombreLargo" class="form-label">Nombre largo del camellón</label>
                        <input wire:model="NombreLargo" id="NombreLargo" type="text" class="form-control" @if($camID=='nuevo') disabled @endif>
                        @error('NombreLargo')<error>{{ $message }}</error>@enderror
                        <div class="form-text"> Nombre completo del camellón tal y como lo identifica la gente. </div>
                    </div>
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="ZonaCorto" class="form-label">Nombre corto de la zona del camellón</label>
                        <input wire:model="ZonaCorto" id="ZonaCorto" type="text" class="form-control" @if($camID=='nuevo') disabled @endif>
                        @error('ZonaCorto')<error>{{ $message }}</error>@enderror
                        <div class="form-text">En caso de haberlo, el nombre corto de pocas letras con el que se identifica la zona en la que se encuentra el camellón.</div>
                    </div>
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="ZonaLargo" class="form-label">Nombre completo de la zona del camellón</label>
                        <input wire:model="ZonaLargo" id="ZonaLargo" type="text" class="form-control" @if($camID=='nuevo') disabled @endif>
                        @error('ZonaLargo')<error>{{ $message }}</error>@enderror
                        <div class="form-text">En caso de haberlo, el nombre completo utilizado para identificar la zona en la que se encuentra el camellón.</div>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="notas" class="form-label">Notas</label>
                        <textarea wire:model="notas" id="notas" class="form-control" @if($camID=='nuevo') disabled @endif></textarea>
                        @error('notas')<error>{{ $message }}</error>@enderror
                        <div class="form-text"></div>
                    </div>
                    <!-- color -->
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="color" class="form-label">Color predeterminado</label>
                        <input wire:model="color" id="color" type="color" class="form-control" @if($camID=='nuevo') disabled @endif>
                        @error('color')<error>{{ $message }}</error>@enderror
                        <div class="form-text">Determina un color predeterminado para distinguir el polígono</div>
                    </div>
                @endif
            </div>
            <div class="row my-3">
                <div class="col-3">
                    @if($camID=='nuevo')
                        <button wire:click="crearDatos()" class="btn btn-primary"> Crear camellón</button>
                    @else
                        <button wire:click="guardarDatos()" class="btn btn-primary"> Guardar</button>
                    @endif
                </div>
                <div class="col-3">
                    <a href="/camellones">
                        <button class="btn btn-secondary"> Cancelar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
















    <div onclick="VerNoVer('nota','GeoJson')">NotaJson</div>
    <div id="sale_notaGeoJson" style="display:none; border:1px solid black;">
        El sistema utiliza archivos GeoJson de tipo Multipolygon.<br>
        Sobre GeoJson: El sistema va a incorporar dos campos al GeoJson, uno denominado
        SisGesJarId y otro denominado SisGesJarCamellon, que tienen el valor de cam_id
        de la base de datos y cam_camellon de la base de datos.

        {<br>
            "type": "FeatureCollection",<br>
            "name": "camellones",<br>
            "crs": {<br>
                "type": "name", "properties": {<br>
                    "name": "urn:ogc:def:crs:OGC:1.3:CRS84"<br>
                }<br>
            },<br>
            "features": [{<br>
                "type": "Feature",<br>
                "properties": {<br>
                    "SisGesJarId": "03",<br>
                    "SisGesJarCamellon": "A1a"<br>
                    "Otros campos...": null,<br>
                },<br>
                "geometry": {<br>
                    "type": "MultiPolygon", "coordinates": [ [ [ <br>
                        [ -96.721957, 17.065598, 0.0 ], [ -96.722156, 17.065613, 0.0 ], [ -96.722145, 17.06567, 0.0 ], [ -96.722133, 17.065678, 0.0 ], [ -96.722141, 17.065689, 0.0 ], [ -96.722096, 17.06595, 0.0 ], [ -96.722014, 17.065942, 0.0 ], [ -96.722024, 17.065883, 0.0 ], [ -96.72206, 17.065886, 0.0 ], [ -96.722071, 17.065825, 0.0 ], [ -96.722033, 17.065821, 0.0 ], [ -96.722061, 17.06566, 0.0 ], [ -96.721929, 17.065648, 0.0 ], [ -96.721935, 17.065614, 0.0 ], [ -96.721957, 17.065598, 0.0 ] <br>
                    ] ] ] <br>
                } <br>
            }]<br>
        }<br>
    </div>
    <div class="regresar">
        <a href="/camellones" class="nolink">
            Regresar al administrador de camellones
        </a>
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
                var geojsonFeature =JSON.parse(mapita.cam_mapa)
                ///// Detecta color
                if(event.DestacaId != null){
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
