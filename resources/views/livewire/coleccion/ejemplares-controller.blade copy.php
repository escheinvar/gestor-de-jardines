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
        <div class="col-sm-12 col-md-4 form-group">
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
        <div class="col-sm-12 col-md-4 form-group">
            <label for="camellon" class="form-label">Camellón</label>
            <select wire:model="camellon" id="camellon" class="@error('camellon') is-invalid @enderror form-select">
                @if($campus != '')
                    <option value="">Indica un camellón</option>
                    @foreach ($camellones as $c)
                        <option value="{{ $c->cam_camellon }}">{{ $c->cam_camellon }}</option>
                    @endforeach
                    <option value="todos">Todos</option>
                    <option value="nulos">Ninguno</option>
                @else
                    <option value="">Indica un campus primero</option>
                @endif
            </select>
            <div class="form-text"></div>
            @error('camellon')<error>{{ $message }}</error>@enderror
        </div>

        {{--
        <!-- -->
        <div class="col-sm-12 col-md-4 form-group">
            <label for="" class="form-label"></label>
            <input wire:model="" id="" class="@error('') is-invalid @enderror form-control" type="text">
            <div class="form-text"></div>
            @error('')<error>{{ $message }}</error>@enderror
        </div>
        <!-- -->
        <div class="col-sm-12 col-md-4 form-group">
            <label for="" class="form-label"></label>
            <select wire:model="" id="" class="@error('') is-invalid @enderror form-select">
                <option value=""></option>
            </select>
            <div class="form-text"></div>
            @error('')<error>{{ $message }}</error>@enderror
        </div>
        --}}

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
        <div class="row">
            <!-- ------------------------------------------------------------------------- -->
            <!-- ----------------------- BÚSQUEDA EN MAPA -------------------------------- -->
            <div class="col-sm-12 col-md-6">
                <div id="map"></div>
            </div>

            <!-- ------------------------------------------------------------------------- -->
            <!-- --------------------------- TABLA --------------------------------------- -->
            <div class="col-sm-12 col-md-6">
                @if($ejemplares)
                    @if(count($ejemplares) == 0)
                        -- No hay ejemplares -->
                    @endif

                    <div class="table-responsive-sm">
                        <table class="table table-striped">
                            <thead>
                            </thead>
                            <tbody>
                                @foreach ($ejemplares as $e)
                                    <tr>
                                        <td>
                                            {{ $e->ejm_ccamsiglas }}
                                        </td>
                                        <td>
                                            <a href="/ejem_inicio/{{ $e->ejm_id }}">
                                                ID {{ $e->ejm_id }}
                                            </a>
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
    /* ---- Función accesoria de Abre Mapa de Camellones para poner etiquetas --- */
    function onEachFeature(feature,layer){
        // console.log('va3:',feature );
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
        // console.log('va1:',event.captura)
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
        if(event.mapas != 'null'){
            event.mapas.forEach(function(mapita) {
                console.log("va1:",mapita.cam_id);
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
                    onEachFeature: onEachFeature, //ejecuta función  ParaCadaPoligono, que agrega nombre
                    style:{
                        "color":color,
                        "weight": linea,
                        "opacity": opacidad
                    },
                }).addTo(map);

                //// --------------------------------------------////
                //// --------- CAPTURA COORDENADAS --------------////
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
        if(event.Ubicaciones != 'null'){
            event.Ubicaciones.forEach(function(ubica){
                //-- verifica que haya ícono --/
                console.log('for2',ubica)
                if(ubica.icon_file){
                    console.log('si')
                    IconArch = ubica.icon_file;
                }else{
                    console.log('no')
                    IconArch = '/iconos/PuntoRojo.png';
                }

                //-- Si es igual a DestacaUbicaId... --//
                if(event.DestacaUbicaId == ubica.sig_id){
                    var MiColor='red';
                    var MiSize=0.5;
                    var ElIcono = L.icon({
                        iconUrl: IconArch,
                        iconSize:     [25, 25], // size of the icon
                    });
                    L.marker([ubica.sig_y, ubica.sig_x],{icon:ElIcono}).addTo(map);
                }else{
                    var MiColor='green';
                    var MiSize=0.1;
                    /////Plotea punto
                    L.circle([ubica.sig_y, ubica.sig_x],{
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
