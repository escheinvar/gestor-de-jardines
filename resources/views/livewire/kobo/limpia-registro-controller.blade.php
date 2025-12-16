@section('title') Revisa datos de Kobo @endsection
@section('meta-description') Revisa y confirma los datos de kobo @endsection
@section('cintillo-ubica') Kobo -> Revisa @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>
    <div>
        <a href="/kobo" class="nolink"> <- Regresar</a>
    </div>

    <h2>Revisa {{ $dato->kobo2_id }} </h2>



    <div class="row">
        <!--------------------------------------------------------------------------------->
        <!----------------------------- COLUMNA IZQUIERDA --------------------------------->
        <!--------------------------------------------------------------------------------->
        <div class="col-12 col-md-6">
            <div class="row">
                <!-- Nombre científico -->
                <div class="col-6 form-group">
                    <label for="scname" class="form-label">Nombre científico</label>
                    <input wire:model="scname" id="scname" class="@error('scname') is-invalid @enderror form-control">
                    <div class="form-text"></div>
                    @error('scname')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Nombres comunes -->
                <div class="col-6 form-group">
                    <label for="comname" class="form-label">Nombre común</label>
                    <i onclick="VerNoVer('nuevo','nombre')" class="bi bi-plus-square agregar"></i> <br>
                    <!-- -----nuevo Nombre --------- -->
                    <div id="sale_nuevonombre" style="display:none;">
                        <input wire:model="NuevoNombreComun" class="form-control agregar" style="">
                        <button wire:click="AgregarNombreComun()" class="btn btn-sm btn-primary"> + </button>
                    </div>
                    <!-- lista de nombres -->
                    <?php $cont='0'; ?>
                    @foreach ($comname as $c)
                        @if($c != '')
                            <?php $cont++; ?>
                            <div style="display:inline-block; background-color:#CDC6B9; padding:4px; margin:2px; border-radius:7px;">
                                @if($cont=='1')<b> @endif {{ $c }}</b>
                                <i wire:click="BorrarNombreComun('{{ $c }}')" wire:confirm="Vas a eliminar el nombre común {{ $c }}. ¿Seguro deseas continuar?" class="bi bi-trash PaClick" style="color:#87796d;"></i>
                            </div>
                        @endif
                    @endforeach
                    <!-- fin de campo-->
                    <div class="form-text"></div>
                    @error('comname')<error>{{ $message }}</error>@enderror
                </div>
            </div>

            <!-- Íconos de ligas de búsqueda -->
            <div class="row py-3">
                <!-- Búsqueda de nombre científico -->
                <div class="col-6">
                    @if($scname != '')
                        <!-- iNaturalist -->
                        <div class="iconoWWW">
                            <a href="https://mexico.inaturalist.org/taxa/search?q={{ $scname }}" target="inaturalist" class="nolink">
                                <img src="/iconos/iNaturalist.png" class="iconoWWW">
                                <BR>iNaturalist
                            </a>
                        </div>

                        <!-- enciclovida -->
                        <div class="iconoWWW">
                            <a href="https://enciclovida.mx/busquedas/resultados?utf8=%E2%9C%93&busqueda=basica&id=&nombre={{ $scname }}" target="enciclovida" class="nolink">
                                <img src="/iconos/Enciclovida.png" class="iconoWWW">
                                <br>Enciclov.
                            </a>
                        </div>

                        <!-- wold Flora Online -->
                        <div class="iconoWWW">
                            <a href="https://www.worldfloraonline.org/search?query={{ $scname }}" target="WorldFlora" class="nolink">
                                <img src="/iconos/WorldFloraOnline.jpeg" class="iconoWWW">
                                <br>WFO
                            </a>
                        </div>

                        <!-- kew -->
                        <div class="iconoWWW">
                            <a href="https://www.kew.org/search?textsearch={{ $scname }}" target="kew" class="nolink">
                                <img src="/iconos/Kew.jpeg" class="iconoWWW">
                                <br>Kew
                            </a>
                        </div>

                        <!-- tropicos -->
                        <div class="iconoWWW">
                            <a href="https://www.tropicos.org/name/Search?name={{ $scname }}" target="tropicos" class="nolink">
                                <img src="/iconos/Tropicos.png" class="iconoWWW" style="background-color:#c7d2b9">
                                <br>Tropicos
                            </a>
                        </div>

                        <!-- herbario conabio -->
                        <div class="iconoWWW">
                            <a href="http://www.conabio.gob.mx/otros/cgi-bin/herbario.cgi" target="herbarioConabio" class="nolink">
                                <img src="/iconos/Conabio.png" class="iconoWWW">
                                <br>Herbario
                            </a>
                        </div>

                        <!-- red de herbarios -->
                        <div class="iconoWWW">
                            <a href="https://herbanwmex.net/portal/taxa/index.php?taxon={{ $scname }}" target="RedHerbarios" class="nolink">
                                <img src="/iconos/RedHerbariosMexicanos.jpeg" class="iconoWWW">
                                <br>Red Herbs
                            </a>
                        </div>

                        <!-- wikipedia -->
                        <div class="iconoWWW">
                            <a href="https://es.wikipedia.org/w/index.php?search={{ $scname }}" target="wikipedia" class="nolink">
                                <img src="/iconos/wikipedia.png" class="iconoWWW" style="background-color: white;">
                                <BR>Wikipedia
                            </a>
                        </div>

                        <!-- Google -->
                        <div class="iconoWWW">
                            <a href="https://www.google.com/search?q={{ $scname }}" target="google" class="nolink">
                                <img src="/iconos/Google.png" class="iconoWWW">
                                <br>Google
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Búsqueda de primer nombre común -->
                <div class="col-6">
                    @if(count($comname) > '0')
                        <!-- iNaturalist -->
                        <div class="iconoWWW">
                            <a href="https://mexico.inaturalist.org/taxa/search?q={{ $comname[0] }}" target="inaturalist" class="nolink">
                                <img src="/iconos/iNaturalist.png" class="iconoWWW">
                                <BR>iNaturalist
                            </a>
                        </div>

                        <!-- enciclovida -->
                        <div class="iconoWWW">
                            <a href="https://enciclovida.mx/busquedas/resultados?utf8=%E2%9C%93&busqueda=basica&id=&nombre={{ $scname }}" target="enciclovida" class="nolink">
                                <img src="/iconos/Enciclovida.png" class="iconoWWW">
                                <br>Enciclovida
                            </a>
                        </div>

                        <!-- wikipedia -->
                        <div class="iconoWWW">
                            <a href="https://es.wikipedia.org/w/index.php?search={{ $comname[0] }}" target="wikipedia" class="nolink">
                                <img src="/iconos/wikipedia.png" class="iconoWWW" style="background-color: white;">
                                <BR>Wikipedia
                            </a>
                        </div>

                        <!-- Google -->
                        <div class="iconoWWW">
                            <a href="https://www.google.com/search?q={{ $comname[0] }}" target="google" class="nolink">
                                <img src="/iconos/Google.png" class="iconoWWW">
                                <br>Google
                            </a>
                        </div>

                    @endif
                </div>
            </div>

            <!-- imágenes -->
            <div class="row">
                <div class="col-12">
                    <!-- imagen de ubicación -->
                    @if($dato->kobo2_fotoubica)
                        <div style="display:inline-block;">
                            <b>Ubicación</b><br>
                            <a href="/kobotmp/{{ $dato->kobo2_id }}_ubica.jpg" target="new" class="nolink">
                                <img src="/kobotmp/{{ $dato->kobo2_id }}_ubica.jpg" style="width:200px;">
                            </a>
                        </div>
                    @endif

                    <!-- imagen de ejemplar -->
                    @if($dato->kobo2_fotoejemplar)
                        <div style="display:inline-block;">
                            <b>Ejemplar</b><br>
                            <a href="/kobotmp/{{ $dato->kobo2_id }}_ejemplar.jpg" target="new" class="nolink">
                                <img src="/kobotmp/{{ $dato->kobo2_id }}_ejemplar.jpg" style="width:200px;">
                            </a>
                        </div>
                    @endif

                    <!-- imagen de ejemplar -->
                    @if($dato->kobo2_fotoejemplar2)
                        <div style="display:inline-block;">
                            <b>Ejemplar 2</b><br>
                            <a href="/kobotmp/{{ $dato->kobo2_id }}_ejemplar2.jpg" target="new" class="nolink">
                                <img src="/kobotmp/{{ $dato->kobo2_id }}_ejemplar2.jpg" style="width:200px;">
                            </a>
                        </div>
                    @endif

                    <!-- imagen de flor -->
                    @if($dato->kobo2_fotoflor)
                        <div style="display:inline-block;">
                            <b>Estructura reproductiva</b><br>
                            <a href="/kobotmp/{{ $dato->kobo2_id }}_flor.jpg" target="new" class="nolink">
                                <img src="/kobotmp/{{ $dato->kobo2_id }}_flor.jpg" style="width:200px;">
                            </a>
                        </div>
                    @endif

                    <!-- imagen de hoja -->
                    @if($dato->kobo2_fotohoja)
                        <div style="display:inline-block;">
                            <b>Hoja</b><br>
                            <a href="/kobotmp/{{ $dato->kobo2_id }}_hoja.jpg" target="new" class="nolink">
                                <img src="/kobotmp/{{ $dato->kobo2_id }}_hoja.jpg" style="width:200px;">
                            </a>
                        </div>
                    @endif

                    <!-- imagen de frutos -->
                    @if($dato->kobo2_fotofrutos)
                        <div style="display:inline-block;">
                            <b>Hoja</b><br>
                            <a href="/kobotmp/{{ $dato->kobo2_id }}_fruto.jpg" target="new" class="nolink">
                                <img src="/kobotmp/{{ $dato->kobo2_id }}_fruto.jpg" style="width:200px;">
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="row">
                    <!-- Cantidad -->
                    <div class="col-6 form-group">
                        <label for="cantidad" class="form-label">Cantidad de individuos<red>*</red></label>
                        <input wire:model="cantidad" id="cantidad" class="@error('cantidad') is-invalid @enderror form-control" type="number">
                        @error('cantidad')<error>{{ $message }}</error>@enderror
                        <div class="form-text">Indica el número de individuos que conforman este ejemplar. Si son incontables (tipo pastos), pon 0</div>
                    </div>

                    <!-- Extensión -->
                    <div class="col-6 form-group">
                        <label for="exten" class="form-label">Extensión de individuos (mts<sup>2</sup>)<red>*</red></label>
                        <input wire:model="exten" id="exten" class="@error('exten') is-invalid @enderror form-control" type="number">
                        @error('exten')<error>{{ $message }}</error>@enderror
                        <div class="form-text">Indica el espacio, en metros cuadrados (mts. de largo x mts. de ancho) que ocupa el ejemplar a nivel de piso. </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Autor -->
                    <div class="col-6 form-group">
                        <label for="autor" class="form-label">Autor de imágenes<red>*</red></label>
                        <input wire:model="autor" id="autor" class="@error('autor') is-invalid @enderror form-control">
                        <div class="form-text"></div>
                        @error('autor')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- fecha y hora -->
                    <div class="col-6 form-group">
                        <label for="fecha" class="form-label">Fecha y hora de imágenes<red>*</red></label>
                        <input wire:model="fecha" id="fecha" class="@error('fecha') is-invalid @enderror form-control" type="datetime-local">
                        <div class="form-text"></div>
                        @error('fecha')<error>{{ $message }}</error>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- notas ubica -->
                <div class="col-12 form-group">
                    <label for="ubicanotas" class="form-label">Notas de la ubicación</label>
                    <textarea wire:model="ubicanotas" id="ubicanotas" class="@error('ubicanotas') is-invalid @enderror form-control"></textarea>
                    <div class="form-text"></div>
                    @error('ubicanotas')<error>{{ $message }}</error>@enderror
                </div>
            </div>
        </div>

        <!--------------------------------------------------------------------------------->
        <!----------------------------- COLUMNA DERECHA ----------------------------------->
        <!--------------------------------------------------------------------------------->
        <div class="col-12 col-md-6">
            <!-- botones antes y después -->
            <div class="row">
                <div class="col-12">
                    <span style="float: left;">
                        @if($prev != $dato->kobo2_id)
                            <a href="/koboView/{{ $prev }}" class="nolink"><- ({{ $prev }}) anterior</a>
                        @endif
                    </span>

                    <span style="float: right;">
                        @if($next != $dato->kobo2_id)
                            <a href="/koboView/{{ $next }}" class="nolink">siguiente ({{ $next }}) -></a>
                        @endif
                    </span>


                </div>
            </div>

            <!-- mapa--->
            <div class="row">
                <div class="col-12" style="clear:both" wire:ignore>
                    <div id="map"></div>
                </div>
            </div>

            <!-- botones antes y después -->
            <div class="row">
                <div class="col-12">
                    <span style="float: left;">
                        @if($prev != $dato->kobo2_id)
                            <a href="/koboView/{{ $prev }}" class="nolink"><- ({{ $prev }}) anterior</a>
                        @endif
                    </span>

                    <span style="float: right;">
                        @if($next != $dato->kobo2_id)
                            <a href="/koboView/{{ $next }}" class="nolink">siguiente ({{ $next }}) -></a>
                        @endif
                    </span>


                </div>
            </div>

            <!-- MENÚ DE GRIDAS -->
            <div class="row">
                @if($gridas->count() > '0')
                    <div class="col-12 form-group">
                        <label class="form-label" for="grida">Grida</label>
                        <select wire:change="MapaConGrida()" wire:model="grida" id="grida" class="@error('grida') is-invalid @enderror form-select" @if($camellon =='') disabled @endif>
                            <option value="">No visualizar ninguna grida</option>
                            @foreach ($gridas as $g)
                                <option value="{{ $g->gri_id }}">{{ $g->gri_name }} [{{ $g->gri_resx }}mts x {{ $g->gri_resy }}mts] </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="row">
                <!-- ubica name -->
                <div class="col-6 form-group">
                    <label for="ubicaname" class="form-label">Etiqueta de la ubicación</label>
                    <input wire:model="ubicaname" id="ubicaname" class="@error('ubicaname') is-invalid @enderror form-control">
                    <div class="form-text"></div>
                    @error('ubicaname')<error>{{ $message }}</error>@enderror
                </div>

                <!-- etiqueta del ejemplar -->
                <div class="col-6 form-group">
                    <label for="ejmname" class="form-label">Etiquetas del ejemplar:</label>
                    <i onclick="VerNoVer('etiqueta','Ejemplar')" class="bi bi-plus-square agregar"></i> <br>
                    <!-- -----nueva etiqueta --------- -->
                    <div id="sale_etiquetaEjemplar" style="display:none;">
                        <input wire:model="NuevaEtiquetaejemplar" class="form-control agregar" style="">
                        <button wire:click="AgregarEtiquetaEjemplar()" class="btn btn-sm btn-primary"> + </button>
                    </div>
                    <!-- lista de etiquetas -->
                    @foreach ($ejmname as $e)
                        @if($e != '')
                            <div style="display:inline-block; background-color:#CDC6B9; padding:4px; margin:2px; border-radius:7px;">
                                {{ $e }}
                                <i wire:click="BorrarEtiquetaEjemplar('{{ $e }}')" wire:confirm="Vas a eliminar la etiqueta del ejemplar {{ $e }}. ¿Seguro deseas continuar?" class="bi bi-trash PaClick" style="color:#87796d;"></i>
                            </div>
                        @endif
                    @endforeach
                    <!-- fin de etiqueta ejemplar-->
                    <div class="form-text"></div>
                    @error('comname')<error>{{ $message }}</error>@enderror
                </div>
            </div>

            <div class="row">
                <!-- campus -->
                <div class="col-6 form-group">
                    <label for="campus" class="form-label">Campus<red>*</red></label>
                    <select wire:model="campus" wire:change="cambiaCampus()" id="campus" class="@error('campus') is-invalid @enderror form-select">
                        @foreach($campuses as $c)
                            <option value="{{ $c->ccam_siglas }}"> [{{ $c->ccam_siglas }}] {{ $c->ccam_name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text"></div>
                    @error('campus')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Camellón -->
                <div class="col-6 form-group">
                    <label class="form-label">Camellón<red>*</red> {{ $dato->kobo2_camellon }} </label>
                    <select wire:model="camellon" wire:change="cambiaCamellon()" id="camellon" class="form-select">
                        <option value="">Indica el camellón</option>
                        @foreach ($camellones as $c)
                            <option value="{{ $c->cam_camellon }}">{{ $c->cam_camellon }} @if($c->cam_mapa =='') [--No geográfico--] @endif</option>
                        @endforeach
                    </select>
                    <div class="form-text"></div>
                    @error('camellon')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Coordenadas X -->
                <div class="col-3 form-group">
                    <label for="longitud" class="form-label">Coordenadas x (longitud)</label>
                    <input wire:model="longitud" id="longitud" class="@error('longitud') is-invalid @enderror form-control">
                    <div class="form-text"></div>
                    @error('longitud')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Coordenadas Y -->
                <div class="col-3 form-group">
                    <label for="latitud" class="form-label">Coordenadas y (latitud)</label>
                    <input wire:model="latitud" id="latitud" class="@error('latitud') is-invalid @enderror form-control">
                    <div class="form-text"></div>
                    @error('latitud')<error>{{ $message }}</error>@enderror
                </div>

                <!-- boton coordenadas-->
                <div class="col-6 my-2">
                    <center><br><br>
                        <button wire:click="tomarCoordenadas()" class="btn btn-sm @if($TomCors=='0')btn-secondary @else btn-danger @endif"  @if($camellon =='') disabled @endif>
                            <i class="bi bi-geo-fill"></i> Cambiar ubicación
                        </button>
                    </center>
                </div>
            </div>

            <div class="row">
                <!-- clavo -->
                <div class="col-6 form-group">
                    <label for="clavo" class="form-label">Clavo</label><br>
                    <input wire:model="clavo" id="clavo" class="@error('clavo') is-invalid @enderror form-control" style="width:75%;display:inline-block;">
                    <a href="https://jeboax.com/Busqueda_clavo" target="clavosJEBOax">
                        <img src="/avatar/jardines/JebOax.jpg" class="iconoWWW">
                    </a>
                    <div class="form-text"></div>
                    @error('clavo')<error>{{ $message }}</error>@enderror
                </div>
            </div>

            <!-- botones finales -->
            <div class="row p-4">
                <div class="col-6">
                    <button wire:click="Guardar()" class="btn btn-primary">
                        Guardar
                    </button>
                    @if( count($errors) > '0') <error>Hay {{ count($errors) }} errores</error>  @endif
                </div>
            </div>
        </div>


        <!--------------------------------------------------------------------------------->
        <!----------------------------- RENGLÓN FINAL DE ABAJO ---------------------------->
        <!--------------------------------------------------------------------------------->
        <div class="row m-4 p-4">
            <div class="col-12" style="clear: both;">
                <DIV STYLE="float: right;">
                    <button wire:click="IngresarEjemplar()" wire:loading.attr="disabled" class="btn btn-primary" @if($dato->kobo2_saved == '0') disabled @endif>
                        Ingresar ejemplar a la colección
                    </button>
                    @if($dato->kobo2_saved=='0') <span class="form-text">Guarda primero</span>@endif


                    <a href="/kobo">
                        <button class="btn btn-secondary">
                            Cancelar
                        </button>
                    </a>
                </DIV>
            </div>
        </div>
    </div>






    <script>
        Livewire.on('AvisoExitoKobo2',()=>{
            alert(event.detail.msj);
            //  console.log(event.detail.msj);
        })

        Livewire.on('RecargaPagina', ()=>{
            window.location.reload();
        })

        Livewire.on('IrAKoboInicial',()=>{
            window.location.href = event.detail.url
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
                                radius:0.1
                            }).addTo(map)
                            // console.log("Clic en " + lat + " latitud y " + lng + "longitud");
                        });
                    });
                });
            }

            //////////////////////////////////////////////
            //////////////////////// Recibe y pinta grida
            if(event.Grida != 'null'){
                event.Grida.forEach(function(gri) {
                    console.log('grida1',gri.gri_mapa)
                    ///// convierte texto recibido en geoJson
                    var geojsonFeature =JSON.parse(gri.gri_mapa)
                    // console.log('grida',event.grida.gri_mapa)
                    L.geoJSON(geojsonFeature,{
                            style:{
                                "color":'#606060',
                                "weight": 0.5,
                                "opacity": 1
                            },
                    }).addTo(map);
                })
            }

            //////////////////////////////////////////////
            /////// Recibe puntos kobo y los pinta
            if(event.kobos != 'null'){
                event.kobos.forEach(function(k){
                    // console.log(k.kobo2_saved)
                    if(k.kobo2_saved =='0'){
                        icono='/iconos/PuntoGrisClaro.png'
                    }else{
                        icono= '/iconos/PuntoNegro.png'
                    }
                    var iconoDeKobo = L.icon({
                        iconUrl: icono, // Ruta a tu imagen
                        iconSize: [8, 8], // Tamaño del icono
                    });
                    var kobopoint = L.marker([k.kobo2_y, k.kobo2_x], {icon: iconoDeKobo});
                    kobopoint.addTo(map);
                    kobopoint.bindPopup("<img src='/kobotmp/"+k.kobo2_id+ "_ejemplar.jpg' style='width:150px;'><br>id:"+ k.kobo2_id +"<br>Etiqueta: " + k.kobo2_nombreejemplar + "<br>Nombre cient: "+ k.kobo2_nombrecient +"<br>Nombre común: " + k.kobo2_nombrecom + "<br><a href='/koboView/" + k.kobo2_id + "' ><i class='bi bi-pencil-square'></i> Ver </a> ");
                })
            }
            //////////////////////////////////////////////
            /////// Recibe array de ejemplares (puntos) y los pinta
            if(event.Ejemplares != 'null'){
                event.Ejemplares.forEach(function(ubica){
                    //-- verifica que haya ícono --/
                    // console.log('for2',ubica)
                    if(ubica.icon_file){
                        IconArch = ubica.icon_file;
                    }else{
                        IconArch = '/iconos/PuntoRojo.png';
                    }

                    //-- Si es igual a DestacaEjemId... --//
                    if(event.DestacaEjemId == ubica.sig_id){
                        var MiColor='red';
                        var MiSize=0.5;
                        var ElIcono = L.icon({
                            iconUrl: IconArch,
                            iconSize: [10, 10], // size of the icon
                        });
                        var marcador = L.marker([ubica.sig_y, ubica.sig_x],{
                            icon:ElIcono
                        });
                        // if(event.etiquetas=='1'){
                            marcador.bindPopup(
                                "Ejemplar <b> Este ejemplar </b><br><a href='/ejem_inicio/" + ubica.sig_ejmid + "'><i class='bi bi-eye'></i>Ver</a>"
                            );
                        // }
                        marcador.addTo(map);
                    }else{
                        var MiColor='green';
                        var MiSize=0.1;
                        /////Plotea punto
                        var marcador = L.circle([ubica.sig_y, ubica.sig_x],{
                            color: MiColor,
                            fillColor: MiColor,
                            fillOpacity: 1,
                            radius: MiSize,
                        });
                        if(event.etiquetas=='1'){
                            marcador.bindPopup(
                                "Ejemplar <b>"+ ubica.sig_ejmid + "</b><br><a href='/ejem_inicio/" + ubica.sig_ejmid + "'><i class='bi bi-eye'></i>Ver</a>"
                            );
                        }
                        marcador.addTo(map);
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
