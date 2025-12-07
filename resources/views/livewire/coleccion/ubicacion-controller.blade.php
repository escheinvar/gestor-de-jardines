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
    <!-- -------------------- TERMINA DATOS GENERALES DEL EJEMPLAR ------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- aviso de privilegios -->
    <div style="font-size: 80%;color:grey;">
        Ubicación: Sección administrada por <b>admin-colviva</b>
        @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif
        @if($edit_adcolviva=='0') <error style="font-size: 90%;"> (No autorizado)</error> @else <span style="font-size:90%;color:green;"> (Autorizado) </span>@endif <br>
    </div>

    @if($HayUbica=='0')<h3>Primer ubicación</h3> @else <h3>Ubicación</h3> @endif
    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- SECCIÓN DE UBICACIÓN Y MAPA  -------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <div>
        <!-- -------- Acciones ---------------- -->
        @if($edit_adcolviva=='1')
            <div class="row">
                <div class="col-2 col-md-1" style="font-size:70%;center">
                    <center>
                        <a href="#" class="nolink">
                            <img src="" style="width:50px;height:50px;border:1px solid black;" class="mx-2">
                            Mover
                        </a>
                    </center>
                </div>
                <div class="col-2 col-md-1" style="font-size:70%;center">
                    <center>
                        <a href="#" class="nolink">
                            <img src="" style="width:50px;height:50px;border:1px solid black;" class="mx-2">
                            Retirar
                        </a>
                    </center>
                </div>
                <div class="col-2 col-md-1" style="font-size:70%;center">
                    <center>
                        <a href="#" class="nolink">
                            <img src="" style="width:50px;height:50px;border:1px solid black;" class="mx-2">
                            Transferir
                        </a>
                    </center>
                </div>
            </div>
        @endif

        <!-- -------- MAPA ----------------- -->
        <div class="row">
            <!-- Mapa  -->
            <div class="col-sm-12 @if($edit_adcolviva=='1')col-md-8 @endif p-3">
                <div wire:ignore>
                    <div id="map"></div>
                </div>
            </div>

            <!-- -------- CUESTIONARIO ----------------- -->
            @if($edit_adcolviva=='1')
                <div class="col-sm-12 col-md-4">
                    <div class="row">
                        <!-- campus -->
                        <div class="col-12 form-group">
                            <label for="campus">Campus<red>*</red></label>
                            <select wire:model="campus" type="text" disabled class="@error('campus') is-invalid @enderror form-select">
                                <option value="">{{ $ejemplar->ejm_ccamsiglas }}</option>
                            </select>
                            <div class="form-text"></div>
                            @error('campus')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Camellón -->
                        <div class="col-12 form-group">
                            <label for="camellon">Camellón<red>*</red></label>
                            <select wire:model="camellon" wire:change="MuestraCamellon()" type="text" class="@error('camellon') is-invalid @enderror form-select">
                                <option value="">Selecciona el camellón</option>
                                @foreach ($camellones as $c)
                                    <option value="{{ $c->cam_id }}">{{ $c->cam_camellon }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('camellon')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-12">
                            <!-- latitud, longitud y botón coordenadas -->
                            <div class="row">
                                <!-- botón de coordenadas -->
                                <div class="col-4 form-group" style="vertical-align: top;"><br>
                                    <button wire:click="SeleccionaCoords()" class="btn {{ $color1 }}">Capturar<br>coordenadas<br>en mapa</button>

                                </div>
                                <div class="col-8 form-group">
                                    <div class="row">
                                        <!-- latitud -->
                                        <div class="col-12 form-group">
                                            <label for="latitud">Latitud (X)<red>*</red></label>
                                            <input wire:model="latitud" type="text" class="@error('latitud') is-invalid @enderror form-control">
                                            <div class="form-text"></div>
                                            @error('latitud')<error>{{ $message }}</error>@enderror
                                        </div>
                                        <!-- longitud -->
                                        <div class="col-12 form-group">
                                            <label for="longitud">Longitud (Y)<red>*</red></label>
                                            <input wire:model="longitud" type="text" class="@error('longitud') is-invalid @enderror form-control">
                                            <div class="form-text"></div>
                                            @error('longitud')<error>{{ $message }}</error>@enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Restricción -->
                        <div class="col-12 form-group">
                            <label for="restriccion">Restriccion de la ubicación<red>*</red></label>
                            <select wire:model="restriccion" type="text" class="@error('restriccion') is-invalid @enderror form-select">
                                <option value="0">Público</option>
                                <option value="1">Privado</option>
                            </select>
                            <div class="form-text"></div>
                            @error('restriccion')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Notas -->
                        <div class="col-12 form-group">
                            <label for="notas">Notas a la ubicación</label>
                            <textarea wire:model="notas" type="text" class="@error('notas') is-invalid @enderror form-control"></textarea>
                            <div class="form-text"></div>
                            @error('notas')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Tipo de crecimiento -->
                        <div class="col-6 form-group">
                            <label for="tipocrecim"><br>Tipo de crecimiento<red>*</red></label>
                            <select wire:model.live="tipocrecim" type="text" class="@error('tipocrecim') is-invalid @enderror form-select">
                                <option value="">Indica uno</option>
                                @foreach ($tiposcrecimiento as $t)
                                    <option value="{{ $t->con_txt }}">{{ $t->con_txt }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                @if($tipocrecim=='individual distinguible')Indica el número total de individuos del ejemplar.
                                @elseif($tipocrecim=='individual en colonia')Indica el número de individuos que hay en las colonias y el número de colonias contadas
                                @elseif($tipocrecim=='colonial')Indica el número total de colonias que tiene el ejemplar
                                @elseif($tipocrecim=='indistinguible')Indica la extensión que ocupa el ejemplar en metros<sup>2</sup>:
                                @endif
                            </div>
                            @error('tipocrecim')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Número de colonias -->
                        <div class="col-3 form-group">
                            <label for="colonias">No. de colonias: @if($tipocrecim=='individual distinguible' or $tipocrecim=='indistinguible') @else <red>*</red>@endif</label>
                            <input wire:model="colonias" type="text" class="@error('colonias') is-invalid @enderror form-control" @if($tipocrecim=='individual distinguible' or $tipocrecim=='indistinguible') disabled @endif>
                            <div class="form-text">
                            </div>
                            @error('colonias')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Número de individuos -->
                        <div class="col-3 form-group">
                            <label for="cantidad">
                                @if($tipocrecim=='indistinguible')Extensión en m<sup>2</sup>:
                                @else No. individuos
                                @endif
                                @if($tipocrecim=='colonial') @else <red>*</red> @endif
                            </label>
                            <input wire:model="cantidad" type="text" class="@error('cantidad') is-invalid @enderror form-control" @if($tipocrecim=='colonial') disabled @endif>
                            <div class="form-text">
                            </div>
                            @error('cantidad')<error>{{ $message }}</error>@enderror
                        </div>

                        <!--  ícono -->
                        <div class="col-10 form-group">
                            <label for="icono">Ícono<red></red></label>
                            <select wire:model="icono" type="text" class="@error('icono') is-invalid @enderror form-select">
                                <option value="">Selecciona un ícono</option>
                                @foreach ($iconos as $i)
                                    <option value="{{ $i->icon_name }}">{{ $i->icon_name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('icono')<error>{{ $message }}</error>@enderror
                        </div>
                        <div class="col-2">
                            <img src="">
                        </div>

                        <div class="col-12 form-group my-3">
                            <button wire:click="GuardaUbicacion()" wire:loadding.attr="disabled" class="btn btn-primary">Guardar</button>
                            @if($errors->count()>0)<error>Hay {{ $errors->count() }} errores</error> @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>



    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- SECCIÓN DE SUB-COLECCIONES  --------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <div>
        <hr class="titulo">
        <a name="subcolecciones">
            <H3>Subcolecciones</H3>
        </a>
    </div>




    <script>
        Livewire.on('AvisoExito',()=>{
            alert(event.detail.msj);
            //  console.log(event.detail.msj);
        })
        ////////////////////////////////////////////////////////////////
        ////--------------- SCRIPTS DE LEAFLET ---------------------////
        ////////////////////////////////////////////////////////////////
        /* ---- Función accesoria de Abre Mapa de Camellones para poner etiquetas --- */
        function onEachFeature(feature,layer){
            // console.log('a',feature );
            if (feature.properties) {
                // let popupContent = "Camellón: <b>" + feature.properties.SisGesJarCamellon + "</b>"; // Assuming a 'name' property
                // popupContent += "<br><a href='/camellon/" + feature.properties.SisGesJarId + "'><i class='bi bi-pencil-square'></i>Editar</a>";
                // layer.bindPopup(popupContent);
                layer;
                // console.log('onEch');
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
            ///// Recibe array de camellones
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
                ///// Plotea el Json del polígono
                L.geoJSON(geojsonFeature,{
                    onEachFeature: onEachFeature, //ejecuta función  onEachFeature,
                    style:{
                        "color":color,
                        "weight": linea,
                        "opacity": opacidad
                    },
                }).addTo(map);

                //--------- CAPTURA COORDENADAS --------------//
                Livewire.on('CapturaCoordenadas', (event) => {
                    map.on('click', function(e){
                        var coord = e.latlng;
                        var lat = coord.lat;
                        var lng = coord.lng;
                        @this.set('latitud',lat);
                        @this.set('longitud',lng)
                        L.marker(coord).addTo(map)
                        console.log("Clic en " + lat + " latitud y " + lng + "longitud");
                    });
                });
            });
        });

        /* ------------ Cierra Mapa de Leaflet ---------- */
        Livewire.on('CierraMapa', (event) => {
            $("#map").replaceWith(`<div id="map">`)
        });


    </script>
</div>
