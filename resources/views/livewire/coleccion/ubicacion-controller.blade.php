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
        <!-- -------- MAPA Y CUESTIONARIO ----------------- -->
        <div class="row">
            <!-------------------------------------------------------------------------------->
            <!------------------- COLUMNA IZQUIERDA ------------------------------------------>
            <!-------------------------------------------------------------------------------->
            <div class="col-sm-12 @if($edit_adcolviva=='1')col-md-8 @endif p-3">
                <!-- bOTONES DE ACCIÓN -->
                @if($edit_adcolviva=='1')
                    <div class="row my-3">
                        <div class="col-8"></div>
                        <div class="col-2" style="font-size:70%;center">
                            <center>
                                <button wire:click="ActivarDesactivarMovimientos()" class="btn btn-sm @if($MovimientoActivo=='1') btn-danger @else btn-secondary @endif" style="width:100px;">
                                    <img src="/iconos/IconoMoverPlanta.png" style="width:30px;height:30px;border:0x solid black;" class="mx-2">
                                    @if($MovimientoActivo=='0')Mover @else Moviendo @endif
                                </button>
                            </center>
                        </div>
                        <div class="col-2" style="font-size:70%;center">
                            <center>
                                <a href="#retirar" class="nolink">
                                    <button wire:click="VerNoVerBaja()" class="btn btn-sm @if($verBaja=='0') btn-secondary @else btn-danger @endif" style="width:100px;">
                                        <img src="/iconos/IconoPlantaMuerta.png" style="width:30px;height:30px;border:0px solid black;" class="mx-2">
                                        Retirar
                                    </button>
                                </a>
                            </center>
                        </div>
                    </div>
                @endif


                <!-- MAPA  -->
                <div class="row">
                    <!----------------- Mapa ----------------- -->
                    <div class="col-12" wire:ignore>
                        <div id="map"></div>
                    </div>
                </div>
            </div>

            <!-------------------------------------------------------------------------------->
            <!------------------- COLUMNA DERECHA ------------------------------------------>
            <!-------------------------------------------------------------------------------->
            @if($edit_adcolviva=='1')
                <!-- -------- CUESTIONARIO ----------------- -->
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
                            <select wire:model="camellon" wire:change="MuestraCamellon()" type="text" class="@error('camellon') is-invalid @enderror form-select" @if($MovimientoActivo=='0') disabled @endif>
                                <option value="">Selecciona el camellón</option>
                                @foreach ($camellones as $c)
                                    <option value="{{ $c->cam_id }}">{{ $c->cam_camellon }} @if($c->cam_mapa =='')[** NO GEOGRÁFICO**]@endif </option>
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
                                    <button wire:click="SeleccionaCoords()" class="btn {{ $color1 }}" @if($MovimientoActivo=='0') disabled @endif>
                                        Capturar<br>coordenadas<br>en mapa
                                    </button>

                                </div>
                                <div class="col-8 form-group">
                                    <div class="row">
                                        <!-- grida -->
                                        <div class="col-12 form-group">
                                            <label for="grida">Grida</label>
                                            <select wire:model="grida" wire:change="SeleccionaGrida()" id="grida" class="@error('grida') is-invalid @enderror form-select" @if($MovimientoActivo=='0') disabled @endif>
                                                <option value="">Selecciona la grida</option>
                                                @foreach ($gridas as $g)
                                                    <option value="{{ $g->gri_id }}">{{ $g->gri_name }} [{{ $g->gri_resx }} x {{ $g->gri_resy }}]</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- longitud -->
                                        <div class="col-6 form-group">
                                            <label for="longitud">Longitud (X)<red>*</red></label>
                                            <input wire:model="longitud" type="text" class="@error('longitud') is-invalid @enderror form-control" @if($MovimientoActivo=='0') readonly @endif>
                                            <div class="form-text"></div>
                                            @error('longitud')<error>{{ $message }}</error>@enderror
                                        </div>
                                        <!-- latitud -->
                                        <div class="col-6 form-group">
                                            <label for="latitud">Latitud (Y)<red>*</red></label>
                                            <input wire:model="latitud" type="text" class="@error('latitud') is-invalid @enderror form-control" @if($MovimientoActivo=='0') readonly @endif>
                                            <div class="form-text"></div>
                                            @error('latitud')<error>{{ $message }}</error>@enderror
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

                        <!-- Número de colonias -->
                        <div class="col-6 form-group">
                            <label for="colonias">Extensión del ejemplar en m<sup>2</sup> (a nivel de piso): <red>*</red></label>
                            <input wire:model="colonias" type="text" class="@error('colonias') is-invalid @enderror form-control">
                            @error('colonias')<error>{{ $message }}</error>@enderror
                            <div class="form-text">
                                Mts. largo x mts.ancho a nivel de piso.
                            </div>
                        </div>

                        <!-- Número de individuos -->
                        <div class="col-6 form-group">
                            <label for="cantidad">Número de individuos del ejemplar<red>*</red></label>
                            <input wire:model="cantidad" type="text" class="@error('cantidad') is-invalid @enderror form-control">
                            @error('cantidad')<error>{{ $message }}</error>@enderror
                            <div class="form-text">
                                Si son incontables, poner cero (0).
                            </div>
                        </div>

                        <!--  ícono -->
                        <div class="col-10 form-group">
                            <label for="icono">Ícono<red></red></label>
                            <select wire:model.live="icono" type="text" class="@error('icono') is-invalid @enderror form-select">
                                <option value="">Selecciona un ícono</option>
                                @foreach ($iconos as $i)
                                    <option value="{{ $i->icon_name }}">{{ $i->icon_name }}</option>
                                @endforeach
                            </select>
                            @error('icono')<error>{{ $message }}</error>@enderror
                            <div class="form-text"><i onclick="VerNoVer('ver','Iconos')" class="bi bi-arrow-down-right-square-fill PaClick" ></i> Desplegar íconos</div>
                        </div>
                        <div class="col-2">
                            @if($icono != '')
                                <img src="{{ $iconos->where('icon_name',$icono)->value('icon_file') }}" style="width:60px;">
                            @endif
                        </div>

                        <div class="col-12 form-group my-3">
                            <button wire:click="GuardaUbicacion()" wire:loadding.attr="disabled" class="btn btn-primary">Guardar</button>
                            @if($errors->count()>0)<error>Hay {{ $errors->count() }} errores</error> @endif
                        </div>
                    </div>

                </div>
            @endif
        </div>

        <!-------------------------------------------------------------------------------->
        <!------------------- RENGLÓN DE ABAJO ------------------------------------------->
        <!-------------------------------------------------------------------------------->
        <div class="row my-3" id="sale_verIconos" style="display:none">
            <div class="col-12">
                @foreach ($iconos as $i)
                    <div style="display:inline-block;font-size:60%; padding:10px;">
                        <center>
                        <img src="{{ $i->icon_file }}" style="width:30px; height:30px;"><br>
                        {{ $i->icon_name }}
                        </center>
                    </div>
                @endforeach
            </div>
        </div>
         <div class="row my-3">
            <!----------------- Alias ----------------- -->
            <div class="col-12 col-md-6 form-group">
                @if($edit_adcolviva=='1')
                    <i class="bi bi-plus-square-fill PaClick agregar" wire:click="abreModalAlias()" style="margin-right:5px;"></i>
                @endif
                <H3 style="display: inline-block;">Alias de ubicación</H3><br>
                @if($alias->count() > '0')
                    @foreach ($alias as $a)
                        {{ $a->alias_nombre }} ({{ $a->alias_tipo }})
                        @if($edit_adcolviva=='1')
                            <i wire:click="BorrarAlias('{{ $a->alias_id }}')" wire:confirm="Vas a eliminar este el alias {{ $a->alias_nombre }} de la ubicación. ¿Deseas continuar?" class="bi bi-trash agregar"></i>&nbsp; &nbsp;
                        @endif
                    @endforeach
                @else
                    -- no hay alias --
                @endif
            </div>

            <!----------------- Sub Colección ----------------- -->
            <div class="col-12 col-md-6 form-group">
                @if($edit_adcolviva=='1')
                    <i class="bi bi-plus-square-fill PaClick agregar" wire:click="AbreElModalDecolecciones('{{ $idEjem }}')" style="margin-right:5px;"></i>
                @endif
                <h3  style="display: inline-block;">Sub colecciones: </h3>
                @if($subcolecciones->count() > '0')
                    @foreach ($subcolecciones as $s)
                        <div style="display:block-inline; font-size:110%;">
                            <li>
                                {{ $s->col_ccolcoleccion }}
                                @if($edit_adcolviva=='1') <i class="bi bi-trash agregar" wire:click="SacaDeColeccion('{{ $s->col_id }}')" wire:confirm="Estás por sacar a este ejemplar de la colección {{ $s->col_ccolcoleccion }}. ¿Deseaas continuar?"></i>@endif
                            </li>
                        </div>
                    @endforeach
                @else
                    -- el ejemplar no es parte de ninguna subcolección --
                @endif

            </div>
        </div>
        <!----------------- Imágenes ----------------- -->
        <div class="row">
            <div class="col-12">
                @if($edit_adcolviva=='1')
                    <i wire:click="AbreModalObjeto('0','ejemplar','ejemplar_ubicación','ej','{{ $idEjem }}')" class="bi bi-plus-square-fill agregar" ></i>
                @endif
                <h3 style="display: inline-block;"> Imágenes</h3><br>
                 <?php $imags=$imagenes; ?>
                @include('plantillas.imagenes')
            </div>
        </div>

        <!-- ------------------- SECCIÓN DE RETIRAR EJEMPLAR --------------------->
        @if($edit_adcolviva=='1')
            <div class="row" style="@if($verBaja=='0') display:none; @else display:block; @endif" id="sale_retiraejemplar">
                <div class="col-12 my-4">
                    <a name="retirar">
                        <h3>Retirar ejemplar</h3>
                    </a>
                    <p>Hola <b>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</b>, estás por retirar a este ejemplar de la colección de este campus. Al retirar un ejemplar, éste ya no estará visible y se almacenará en los datos históricos de la colección.</p>
                    <div class="col-6 form-group">
                        <label for="razonBaja" class="form-label">En dos o tres palabras, indica la causa de la baja del ejemplar<red>*</red></label>
                        <input  wire:model="razonBaja" id="razonBaja" class="@error('razonBaja') is-invalid @enderror form-control" type="text" >
                        <div class="form-text"></div>
                        @error('razonBaja')<error>{{ $message }}</error>@enderror
                    </div>
                    <div class="col-6 form-group">
                        <label for="fechaBaja" class="form-label">Indica la fecha de la baja<red>*</red></label>
                        <input  wire:model="fechaBaja" id="fechaBaja" class="@error('fechaBaja') is-invalid @enderror form-control" type="date" >
                        <div class="form-text"></div>
                        @error('fechaBaja')<error>{{ $message }}</error>@enderror
                    </div>
                    <div class="col-12 form-group">
                        <label for="explicaBaja" class="form-label">Explica ampliamente, la causa o razones de la baja<red>*</red></label>
                        <textarea wire:model="explicaBaja" id="explicaBaja" class="@error('explicaBaja') is-invalid @enderror form-control"></textarea>
                        <div class="form-text"></div>
                        @error('explicaBaja')<error>{{ $message }}</error>@enderror
                    </div>
                    <div class="col-12 m-4">
                        <button wire:click="DarDeBaja()" wire:confirm="El ejemplar será dado de baja y no será visible en el sistema. ¿Quieres continuar?" class="btn btn-primary btn-sm">Dar de baja de la colección</button>
                        <button wire:click="VerNoVerBaja()" class="btn btn-secondary btn-sm">Cancelar</button>
                    </div>
                </div>

            </div>
        @endif
    </div>



    <livewire:coleccion.ModalAliasController />
    <livewire:coleccion.ModalSubcoleccionesController />


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
                    // var geojsonFeature =JSON.parse(mapita.cam_mapa)
                    var geojsonFeature =mapita.cam_mapa
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
                        textoPopup="<img src="+ ubica.img_ruta +" style='width:150px;'><br><b>Ejemplar Id:"+ ubica.sig_ejmid +"<b><br><a href='/ejem_ubica/" + ubica.sig_ejmid + "' ><i class='bi bi-pencil-square'></i> Ver ejemplar </a> ";
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

            //////////////////////////////////////////////
            /////// Recibe array de ejemplares (puntos) y los pinta
            // if(event.Ejemplares != 'null'){
            //     event.Ejemplares.forEach(function(ubica){
            //         //-- verifica que haya ícono --/
            //         // console.log('for2',ubica)
            //         if(ubica.icon_file){
            //             IconArch = ubica.icon_file;
            //         }else{
            //             IconArch = '/iconos/PuntoRojo.png';
            //         }

            //         //-- Si es igual a DestacaEjemId... --//
            //         if(event.DestacaEjemId == ubica.sig_id){
            //             var MiColor='red';
            //             var MiSize=0.5;
            //             var ElIcono = L.icon({
            //                 iconUrl: IconArch,
            //                 iconSize:     [25, 25], // size of the icon
            //             });
            //             var marcador = L.marker([ubica.sig_y, ubica.sig_x],{
            //                 icon:ElIcono
            //             });
            //             if(event.etiquetas=='1'){
            //                 marcador.bindPopup(
            //                     "Ejemplar <b>"+ ubica.sig_ejmid + "</b><br><a href='/ejem_inicio/" + ubica.sig_ejmid + "'><i class='bi bi-eye'></i>Ver</a>"
            //                 );
            //             }
            //             marcador.addTo(map);
            //         }else{
            //             var MiColor='green';
            //             var MiSize=0.1;
            //             /////Plotea punto
            //             var marcador = L.circle([ubica.sig_y, ubica.sig_x],{
            //                 color: MiColor,
            //                 fillColor: MiColor,
            //                 fillOpacity: 1,
            //                 radius: MiSize,
            //             });
            //             if(event.etiquetas=='1'){
            //                 marcador.bindPopup(
            //                     "Ejemplar <b>"+ ubica.sig_ejmid + "</b><br><a href='/ejem_inicio/" + ubica.sig_ejmid + "'><i class='bi bi-eye'></i>Ver</a>"
            //                 );
            //             }
            //             marcador.addTo(map);
            //         }
            //     });
            // }

        });

        /* ------------ Cierra Mapa de Leaflet ---------- */
        Livewire.on('CierraMapa', (event) => {
            $("#map").replaceWith(`<div id="map">`)
        });
    </script>
</div>
