@section('title')  @endsection
@section('meta-description') Datos de la bitácora de colecta de los ejemplares @endsection
@section('cintillo-ubica') -> <a href="/ejemplares" class="nolink">Ejemplares</a> @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>
    @include('plantillas.MenuDeEjemplar')

    <div class="row">
        <!-- ------------------------------------------------------------ -->
        <!-- ----------------- COLUMNA IZQUIERDA ------------------------ -->
        <div class="col-12 col-md-7">
            <div class="row">
                <!-- nombre del jardín -->
                <div class="col-12">
                    <img src="/avatar/jardines/{{ $JardinData->cjar_logo }}" style="width:50px;">
                    {{ $JardinData->cjar_nombre }}
                </div>
            </div>

            <!-- campus -->
            <div class="row py-1">
                <div class="col-3">Campus: </div>
                <div class="col-8">{{ $JardinData->ccam_nombre }}  ({{ $JardinData->ccam_siglas }})</div>
            </div>

            <!-- ID ejemplar-->
            <div class="row py-1">
                <div class="col-3">Id de ejemplar:</div>
                <div class="col-8">{{ $idEjem }}</div>
            </div>

            <!-- Nombre científico -->
            <div class="row py-1">
                <div class="col-3">Nombre científico</div>
                <div class="col-8">
                    @if($ejemplar_ScName) {{ $ejemplar_ScName->scn_name }}
                    @else<error> -- no definido --</error>
                    @endif
                </div>
            </div>

            <!--Nombres comunes: -->
            <div class="row py-1">
                <div class="col-3">Nombres comunes:</div>
                <div class="col-8">
                    @if($ejemplar_CoName){{ implode(', ',$ejemplar_CoName->pluck('con_nombre')->toArray()) }}
                    @else<error> -- no definido --</error>
                    @endif
                </div>
            </div>

            <!-- Imágenes -->
            <div class="row py-1">
                <div class="col-12">
                    <center>
                        <?php $imags=$Imagenes; ?>
                        @include('plantillas.imagenes')
                    </center>
                </div>
            </div>

            <!-- Alias -->
            <div class="row py-1">
                <div class="col-3">Alias del ejemplar:</div>
                <div class="col-8">
                    @if($alias)
                        @foreach ($alias as $a)
                            {{ $a->alias_nombre }} {{ $alias->count() }}
                        @endforeach
                    @endif
                </div>
            </div>



            <!-- Camellón -->
            <div class="row py-1">
                <div class="col-3">Camellón</div>
                <div class="col-8">
                    @if($ejemplar_ubica){{ $ejemplar_ubica->sig_camcamellon }}
                    @else<error>-- Falta ubicar --</error>
                    @endif
                </div>
            </div>

            <!-- Bitácora -->
            <div class="row py-1">
                <div class="col-3">Bitácora</div>
                <div class="col-8">
                    @if($ejemplar->ejm_bitid > '0'){{ $ejemplar->ejm_bitid }}
                    @else <error>Falta bitácora</error>
                    @endif
                </div>
            </div>
        </div>


        <!-- ------------------------------------------------------------ -->
        <!-- ----------------- COLUMNA DERECHA ------------------------ -->
        <div class="col-12 col-md-5">
            <!-- ACCIONES -->
            <div class="row">
                <div class="col-12 form-group py-2">
                    <label class="form-label">Reportar:</label><br>
                    <button class="btn btn-success btn-sm">Flor</button>
                    <button class="btn btn-success btn-sm">Polinizador</button>
                    <button class="btn btn-success btn-sm">Nombre</button>
                    <button class="btn btn-success btn-sm">Fruto</button>
                    <button class="btn btn-success btn-sm">Uso</button>
                </div>
            </div>
            <div class="row">
                @if($ejemplar_ubica)
                    <div class="col-12">
                        <div id="map" style="width:180px;"></div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ------------------------------------------------------------ -->
    <!-- ----------------- FILA FINAL DE ABAJO ---------------------- -->
    <div class="row">
        <div class="col-12 form-group py-2">
            <button>Reubicar</button>
            <button>Dar de baja</button>
            <button>Cosechar semilla</button>
            <button>Cosechar plántula</button>
            <button>Reportar evento</button>
            <button>Reportar conteo</button>
        </div>
    </div>







    <script>
        Livewire.on('AvisoExitoInicio',()=>{
            alert(event.detail.msj);
            //  console.log(event.detail.msj);
        })
        ////////////////////////////////////////////////////////////////
        ////--------------- SCRIPTS DE LEAFLET ---------------------////
        ////////////////////////////////////////////////////////////////
        /* ---- Función accesoria de Abre Mapa de Camellones para poner etiquetas --- */
        function onEachFeature(feature,layer){
            // console.log('a',feature );
            //----- Agrega etiqueta a cada polígono -------//
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
            // console.log('b',event.captura)
            ///// Genera espacio de mapa
            var map = L.map('map',{maxZoom:24}).setView([event.y, event.x], event.zoom  );
            ///// Envía fondo de streetMap
            if(event.streetmap==1){
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            }
            //////////////////////////////////////////////
            /////////// Recibe array de camellones y los pinta
            if(event.mapas){
                event.mapas.forEach(function(mapita) {
                    // console.log("va3:",mapita.cam_id);
                    ///// convierte texto recibido en geoJson
                    var geojsonFeature =JSON.parse(mapita.cam_mapa)
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

                    ///// Agrega etiqueta a cada polígono.
                    L.geoJSON(geojsonFeature,{
                        // onEachFeature: onEachFeature, //ejecuta función  ParaCadaPoligono, que agrega nombre
                        style:{
                            "color":color,
                            "weight": linea,
                            "opacity": opacidad
                        },
                    }).addTo(map);

                    //--------------------------------------------//
                    //--------- CAPTURA COORDENADAS --------------//
                    Livewire.on('CapturaCoordenadas', (event) => {
                        map.on('click', function(e){
                            var coord = e.latlng;
                            var lat = coord.lat;
                            var lng = coord.lng;
                            @this.set('latitud',lat);  //Envia var a laravel
                            @this.set('longitud',lng)  //Envia var a laravel
                            //-- Si hay punto previo, lo borra
                            if(typeof NuevoCirculo != 'undefined'){
                                map.removeLayer(NuevoCirculo);
                            }
                            //-- Pinta el nuevo punto
                            NuevoCirculo = L.circle(coord,{
                                color:'blue',
                                fillColor: 'transparent',
                                fillOpacity: 1,
                                radius:0.3
                            }).addTo(map)

                            // console.log("Clic en " + lat + " latitud y " + lng + "longitud");
                        });
                    });
                });
            }

            //////////////////////////////////////////////
            /////// Recibe array de ubicaciones (puntos) y los pinta
            if(event.Ubicaciones){
                event.Ubicaciones.forEach(function(ubica){
                    //-- verifica que haya ícono --/
                    if(ubica.icon_file){
                        IconArch = ubica.icon_file;
                    }else{
                        IconArch = '/iconos/PuntoRojo.png';
                    }
                    console.log('icon',IconArch);
                    //-- Si es igual a DestacaUbicaId... --//
                    if(event.DestacaUbicaId == ubica.sig_id){
                        var MiColor='red';
                        var MiSize=0.5;
                        var ElIcono = L.icon({
                            iconUrl: ubica.icon_file,
                            iconSize:     [25, 25], // size of the icon
                            // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
                            // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                        });
                        L.marker([ubica.sig_x, ubica.sig_y],{icon:ElIcono}).addTo(map);
                    }else{
                        var MiColor='green';
                        var MiSize=0.1;
                        /////Plotea punto
                        L.circle([ubica.sig_x, ubica.sig_y],{
                            color: MiColor,
                            fillColor: MiColor,
                            fillOpacity: 1,
                            radius: MiSize,
                        }).addTo(map);
                    }
                });
            }

        });

        /* ------------ Cierra Mapa de Leaflet ---------- */
        Livewire.on('CierraMapa', (event) => {
            $("#map").replaceWith(`<div id="map">`)
        });


    </script>
</div>
