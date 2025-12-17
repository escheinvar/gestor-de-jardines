@section('title')  @endsection
@section('meta-description') Datos de la bitácora de colecta de los ejemplares @endsection
@section('cintillo-ubica') -> <a href="/ejem_ejemplares" class="nolink">Ejemplares</a> @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>
    <h2>Ejemplares</h2>
    <!-- ------------------------------------------------------------------------- -->
    <!-- ----------------------- CAMPOS DE BÚSQUEDA------------------------------- -->
    <div class="row py-3">
        <!-- Campus -->
        <div class="col-sm-12 col-md-3 form-group">
            <label for="campus" class="form-label">Campus</label>
            <select wire:model.live="campus" wire:change="BuscaEnCampus()" id="campus" class="@error('campus') is-invalid @enderror form-select" type="text">
                <option value="">Indica un campus   </option>
                @foreach ($campuses as $c)
                    <option value="{{ $c->ccam_siglas }}"> [{{ $c->ccam_siglas }}] {{ $c->ccam_name }}</option>
                @endforeach
            </select>
            <div class="form-text"></div>
            @error('campus')<error>{{ $message }}</error>@enderror
        </div>

        <!-- Camellón -->
        <div class="col-sm-12 col-md-3 form-group">
            <label for="camellon" class="form-label">Camellón</label>
            <select wire:model="camellon" wire:change="BuscaEnCamellon()" id="camellon" class="@error('camellon') is-invalid @enderror form-select">
                @if($campus != '')
                    <option value="">Indica un camellón</option>
                    @foreach ($camellones as $c)
                    <option value="{{ $c->cam_camellon }}">
                        {{ $c->cam_camellon }}
                        @if($c->cam_mapa =='')[** NO GEOGRÁFICO**]@endif
                    </option>
                    @endforeach
                    <option value="Ninguno">Sin asignación a camellón</option>

                @else
                    <option value="">Indica un campus primero</option>
                @endif
            </select>
            <div class="form-text"></div>
            @error('camellon')<error>{{ $message }}</error>@enderror
        </div>

        <!-- Familia, Género /sp -->
        <div class="col-sm-12 col-md-3 form-group">
            <label for="" class="form-label">Familia, Género o especie:</label>
            <input wire:model="" id="" class="@error('') is-invalid @enderror form-control" disabled>
            <div class="form-text"></div>
            @error('')<error>{{ $message }}</error>@enderror
        </div>

        <!-- Colección -->
        <div class="col-sm-12 col-md-3 form-group">
            <label for="" class="form-label">Colección:</label>
            <input wire:model="" id="" class="@error('') is-invalid @enderror form-control" disabled>
            <div class="form-text"></div>
            @error('')<error>{{ $message }}</error>@enderror
        </div>

        <!-- Colección -->
        <div class="col-sm-12 col-md-3 form-group">
            <label for="" class="form-label">Alias:</label>
            <input wire:model="" id="" class="@error('') is-invalid @enderror form-control" disabled>
            <div class="form-text"></div>
            @error('')<error>{{ $message }}</error>@enderror
        </div>

         <!-- Colección -->
        <div class="col-sm-12 col-md-3 form-group">
            <br>
            <button class="btn btn-primary" disabled>Buscar</button>
        </div>

        <div class="col-3">
            @if($edit=='1')
                <a href="/ejem_bitacora/0">
                    <label class="form-lagel">&nbsp;</label><br>
                    <button type="buton" class="btn btn-primary">
                        @if($edit=='1')
                            <i class="bi bi-plus-square-fill agregar" style=""> Nuevo ejemplar</i>
                        @endif
                    </button>
                </a>
            @endif
        </div>
    </div>

    <!-- ------------------------------------------------------------------------- -->
    <!-- --------------------------- MAPA Y TABLA -------------------------------- -->
    {{-- @if($campus != '' and $camellones->count() > '0') --}}
        <div class="row" >
            <!-- ------------------------------------------------------------------------- -->
            <!-- ----------------------- BÚSQUEDA EN MAPA -------------------------------- -->
            <div class="col-sm-12 col-md-6" wire:ignore>
                <div id="map"></div>
            </div>

            <!-- ------------------------------------------------------------------------- -->
            <!-- --------------------------- TABLA --------------------------------------- -->
            <div class="col-sm-12 col-md-6">
                @if($ejemplares)
                    @if(count($ejemplares) == 0)
                        -- No hay ejemplares -->
                    @endif

                    <div style="clear: both;">
                        @if(count($ejemplares) > 0)
                            <i class="bi bi-file-earmark-arrow-down PaClick" style="float: right;"> Descargar a csv</i>
                        @endif
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Campus</th>
                                    <th>Camellón</th>
                                    <th>Familia</th>
                                    <th>Nombre cientifico</th>
                                    <th>Faltantes</th>
                            </thead>
                            <tbody>
                                @foreach ($ejemplares as $e)
                                    <tr>
                                        <td>
                                            <a href="/ejem_inicio/{{ $e->ejm_id }}">
                                                ID {{ $e->ejm_id }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $e->ejm_ccamsiglas }}
                                        </td>
                                        <td>
                                            {{ $e->sig_camcamellon }}
                                        </td>
                                        <td>
                                            {{ $e->scn_familia }}
                                        </td>
                                        <td>
                                            {{ $e->scn_name }}
                                        </td>
                                        <td>
                                            <div style="font-size: 70%;">
                                                @if($e->ejm_bitid=='0') <div><i class="bi bi-journals" style="color:rgb(55, 0, 255);">Bitacora</i></div> @endif
                                                @if($e->sig_camcamellon =='') <div><i class="bi bi-geo-alt-fill" style="color:red;">Ubicar</i></div> @endif
                                                @if($e->scn_name=='')<div><i class="bi bi-tag-fill" style="color:rgb(201, 16, 185);">Sc. name</i> </div>@endif
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    {{-- @elseif($campus != '' AND $camellones->count()=='0')
        -- Aún no hay camellones en este campus --
    @endif --}}

<script>
    Livewire.on('AvisoExitoInicio',()=>{
        alert(event.detail.msj);
        //  console.log(event.detail.msj);
    })
    ////////////////////////////////////////////////////////////////
    ////--------------- SCRIPTS DE LEAFLET ---------------------////
    ////////////////////////////////////////////////////////////////
    ///// $this->MapaCamellones($camellones, $streetMap, $DestacaCamId, $Ejemplares, $DestacaEjemId, $etiquetas)
    /////
    ///// Esta función requiere que se definan las siguientes variables:
    ///// $camellones = cat_camellon::get() ó 'null' con la seleccion de camellones a mapear (si es 'null', solo muestra los ejemplares)
    ///// $streetMap='1' ó '0' Indica si se muestra fondo de StreeMap (1) o no (0)
    ///// $DestacaCamId= 'null' ó cam_id. Cuando cam_id, destaca y centra el camellón indicado.
    ///// $Ejemplares= 'null' o ej_ubicaciones::join('cat_iconos','sig_icono','=','icon_name')->get()
    /////               con el listado de puntos a mostrar (y sus íconos). Si no hay join de íconos,
    /////               solo muestra camellones
    ///// $DestacaEjemId= 'null' o sig_id; con el id del registro a destacar
    ///// $etiquetas='1' ó '0' Indica si semuestran popups con datos de ejemplares y camellones


    /* ---- Función accesoria de Abre Mapa de Camellones para poner etiquetas --- */
    function onEachFeature(feature,layer){
        // console.log(feature.properties.SisGesJarCamellon)
        //----- Agrega etiqueta a cada polígono -------//
        if (feature.properties) {
            let popupContent = "Camellón: <b>" + feature.properties.SisGesJarCamellon + "</b>";
            // popupContent += "<br><a href='/camellon/" + feature.properties.SisGesJarId + "'><i class='bi bi-pencil-square'></i>Editar</a>";
            layer.bindPopup(popupContent);
        }
    }

    /* ----------------------------------------------------------------------------- */
    /* -------------- Abre Mapa de Camellones en LeafLet --------------------------- */
    /* -------------- Recibe instrucciones de MapaCamellones() --------------------- */
    Livewire.on('IniciaMapaCamellones', (event) => {
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
        if(event.camellones != 'null'){
            event.camellones.forEach(function(mapita) {
                ///// convierte texto recibido en geoJson
                var geojsonFeature =JSON.parse(mapita.cam_mapa)
                ///// Detecta color
                if(event.DestacaCamId != 'null'){
                    if(mapita.cam_id == event.DestacaCamId){
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
                if(event.etiquetas =='1'){
                    // console.log('camellon')
                    L.geoJSON(geojsonFeature,{
                        onEachFeature: onEachFeature, //ejecuta función  ParaCadaPoligono, que agrega nombre
                        style:{
                            "color":color,
                            "weight": linea,
                            "opacity": opacidad
                        },
                    }).addTo(map);
                ///// Agrega los polígonos (sin etiqueta)
                }else{
                    L.geoJSON(geojsonFeature,{
                        style:{
                            "color":color,
                            "weight": linea,
                            "opacity": opacidad
                        },
                    }).addTo(map);
                }

                //// --------------------------------------------------------////
                //// --------------- CAPTURA COORDENADAS --------------------////
                //// ---- requiere $this->dispatch('CapturaCoordenadas') desde
                //// ---- el controlador ------------------------------------
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
                        console.log("Clic en " + lat + " latitud y " + lng + "longitud");
                    });
                });
            });
        }

        //////////////////////////////////////////////
        /////// Recibe array de ejemplares (puntos) y los pinta
        if(event.Ejemplares != 'null'){
            event.Ejemplares.forEach(function(ubica){
                if(event.DestacaEjemId == ubica.sig_id){ ///// si es destaca
                    icono = '/iconos/PuntoRojo.png';
                    tamanio = [20,20];
                    textoPopup="<b>Este ejemplar</b>";
                }else{
                    if(ubica.sig_icono != null){
                        icono = ubica.sig_icono; ///// si NO es destaca y sí tiene ícono
                        tamanio = [20,20];
                    }else{
                        icono = '/iconos/PuntoVerde.png'; ///// si NO es destaca y NO tiene ícono
                        tamanio = [12,12];
                    }
                    textoPopup="<img src="+ ubica.img_ruta +" style='width:150px;'><br><b>Ejemplar Id:"+ ubica.sig_ejmid +"<b><br><a href='/ejem_inicio/" + ubica.sig_ejmid + "' ><i class='bi bi-pencil-square'></i> Ver ejemplar </a> ";
                }
                ///// Genera objeto de ícono
                iconoDeEjemplar = L.icon({
                    iconUrl: icono, // Ruta a tu imagen
                    iconSize: tamanio, // Tamaño del icono
                });
                //// Lo pinta
                EjemplarPoint = L.marker([ubica.sig_y, ubica.sig_x], {icon: iconoDeEjemplar});
                EjemplarPoint.addTo(map);
                EjemplarPoint.bindPopup(textoPopup);
            });
        }
    });

    /* ------------ Cierra Mapa de Leaflet ---------- */
    Livewire.on('CierraMapa', (event) => {
        $("#map").replaceWith(`<div id="map">`)
    });
</script>


</div>
