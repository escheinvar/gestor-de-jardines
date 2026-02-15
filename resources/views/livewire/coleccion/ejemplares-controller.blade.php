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
        <!-- -------------------- Campus ---------------------->
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

        <!-- -------------------- Camellón ---------------------->
        <div class="col-sm-12 col-md-3 form-group">
            <label for="camellon" class="form-label">Camellón</label>
            <select wire:model.live="camellon" wire:change="BuscaEnCamellon()" id="camellon" class="@error('camellon') is-invalid @enderror form-select" @if($campus =='') disabled @endif>
                @if($campus != '')
                    <option value="">Indica un camellón</option>
                    @if($camellones->count() > 0)
                        <option value="Todos">Cualquiera</option>
                    @endif
                    @foreach ($camellones as $c)
                        <option value="{{ $c->cam_camellon }}">
                            {{ $c->cam_camellon }}
                            @if($c->cam_mapa =='')[** NO GEOGRÁFICO**]@endif
                        </option>
                    @endforeach
                    @if($camellones->count() > 0)
                        <option value="Ninguno">Sin camellón</option>
                    @endif
                @else
                    <option value="">Indica un campus primero</option>
                @endif
            </select>
            <div class="form-text"></div>
            @error('camellon')<error>{{ $message }}</error>@enderror
        </div>

        <!-- -------------------- Buscar por Colección ---------------------->
        <div class="col-sm-12 col-md-3 form-group">
            <label for="coleccion" class="form-label">Colección:</label>
            <select wire:model.live="coleccion" wire:change="BuscaEnCamellon()" id="coleccion" class="@error('coleccion') is-invalid @enderror form-select" @if($campus =='' or $camellon=='') disabled @endif>
                <option value="">Todas</option>
                @foreach ($colecciones as $col)
                    <option value="{{ $col->ccol_coleccion }}">{{ $col->ccol_coleccion }}</option>
                @endforeach
                {{-- <option value="NingunaColeccion">Sin colección asignada</option> --}}
            </select>
            <div class="form-text"></div>
            @error('coleccion')<error>{{ $message }}</error>@enderror
        </div>
    </div>

    <div class="row py-3">
        <!-- -------------------- Buscar por texto de Familia, Género /sp Alias ---------------------->
        <div class="col-sm-12 col-md-3 form-group">
            <label for="buscar" class="form-label">Familia, nombre científico o común o alias:</label>
            <input wire:model.live="buscar" id="buscar" class="@error('buscar') is-invalid @enderror form-control" @if($campus =='' or $camellon=='') disabled @endif>
            <div class="form-text">Usa % como comodín (xej: agave% para todos los agaves).</div>
            @error('buscar')<error>{{ $message }}</error>@enderror
        </div>



        <!-- -------------------- Botón de buscar ---------------------->
        <div class="col-sm-12 col-md-3 form-group">
            <br>
            <i class="bi bi-x-square agregar mx-2" wire:click="BorrarBuscar()"></i>
            <button wire:click="BuscaEnCamellon()" class="btn btn-primary" @if($campus =='' or $camellon=='' or $buscar=='') disabled @endif>Buscar</button>
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
            {{-- <h3>Mapa de {{ $campus }}</h3> --}}
            <div class="col-sm-12 col-md-6" wire:ignore>
                <br><br>
                <div id="map"></div>
            </div>

            <!-- ------------------------------------------------------------------------- -->
            <!-- --------------------------- TABLA --------------------------------------- -->
            <div class="col-sm-12 col-md-6">
                @if($ejemplares)
                    <div style="clear: both;">
                        @if(count($ejemplares) > 0)
                            <i class="bi bi-file-earmark-arrow-down PaClick" style="float: right;"> Descargar a csv</i>
                        @endif
                    </div>
                    <div>
                        <h3>{{ $campus }}</h3>
                        @if($ejemplares){{ $ejemplares->count() }}@endif
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr style="vertical-align: middle;text-align:center;">
                                    <th>Id</th>
                                    <th>Camellón</th>
                                    <th>[Familia]<br>Nombre cientifico</th>
                                    <th>Nombre común</th>
                                    <th>Colección</th>
                                    <th>Alias</th>
                            </thead>
                            <tbody>
                                @foreach ($ejemplares as $e)
                                    <tr>
                                        <!-- ID -->
                                        <td style="font-size: 80%;">
                                            <a href="/ejem_inicio/{{ $e->ejm_id }}">
                                                {{ $e->ejm_id }}
                                            </a>
                                        </td>

                                        <!-- camellón -->
                                        <td style="font-size: 80%;">
                                            @if($e->ubicacion)
                                                {{ $e->ubicacion->sig_camcamellon }}
                                            @else
                                                <center><error>
                                                    <a href="/ejem_ubica/{{ $e->ejm_id }}" class="nolink">
                                                        <i class="bi bi-exclamation-octagon-fill" style="font-size:80%;"></i>
                                                    </a>
                                                </error></center>
                                            @endif
                                        </td>

                                        <!-- familia y Nombre científico -->
                                        <td style="font-size: 80%;">
                                            @if($e->nombreCientifico)
                                                [{{ $e->nombreCientifico->scn_familia }}]
                                                {{ $e->nombreCientifico->scn_name }}
                                            @endif
                                            @if(!$e->nombreCientifico or $e->nombreCientifico->scn_name =='')
                                                <center><error>
                                                    <a href="/ejem_nombres/{{ $e->ejm_id }}" class="nolink">
                                                        <i class="bi bi-exclamation-octagon-fill" style="font-size:80%;"></i>
                                                    </a>
                                                </error></center>
                                            @endif
                                        </td>


                                        <!-- Nombre común -->
                                        <td style="font-size: 80%;">
                                            @if($e->nombresComunes->count() > 0)
                                                @foreach ($e->nombresComunes as $n)
                                                    <div class="elemento">
                                                        {{ $n->con_nombre }}
                                                    </div>
                                                @endforeach
                                            @else
                                                <center>
                                                    <a href="/ejem_nombres/{{ $e->ejm_id }}" class="nolink">
                                                        <i class="bi bi-exclamation-octagon-fill"></i>
                                                    </a>
                                                </center>
                                            @endif
                                        </td>

                                        <!-- Colecciones -->
                                        <td style="font-size: 80%;">
                                            @if($e->colecciones->count() > 0)
                                                @foreach ($e->colecciones as $n)
                                                    <div class="elemento">
                                                        {{ $n->col_ccolcoleccion }}
                                                    </div>
                                                @endforeach
                                            @else
                                                <center>
                                                    <a href="/ejem_ubica/{{ $e->ejm_id }}" class="nolink">
                                                        <i class="bi bi-exclamation-octagon-fill"></i>
                                                    </a>
                                                </center>
                                            @endif
                                        </td>

                                        <!-- Alias -->
                                        <td style="font-size: 80%;">
                                            @if($e->alias)
                                                @foreach ($e->alias as $n)
                                                <div class="elemento">
                                                    {{ $n->alias_nombre }}
                                                </div>
                                                @endforeach
                                            @else
                                                <center>
                                                    <i class="bi bi-exclamation-octagon-fill" style="font-size:80%;"></i>
                                                </center>
                                            @endif
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(count($ejemplares) == 0)
                        -- No hay ejemplares -->
                    @endif
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
