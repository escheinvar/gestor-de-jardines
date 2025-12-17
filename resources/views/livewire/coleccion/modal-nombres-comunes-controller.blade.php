<div>
    <!-- ------------------------------------------------------------------------------------- -->
    <!---------------------- INICIA MODAL DE NUEVO NOMBRE COMÚN ------------------------------------- -->
    {{-- ----   requiere en view:
        -----   <livewire:coleccion.modal-nombres-comunes-controller />
        -----   <wire:click="AbrirModalNombreComun(EjId, conId)">
        -----
        -----   y en controller:
        -----   public function AbrirModalNombreComun($par1, $par2){
        -----       $data=['ejId'=>$par1,'conId'=>$par2];  ### donde $par1 tiene el Id del ejemplar a editar y $par2 tiene el id del nombre ó 0 para nuevo nombre
        -----       $this->dispatch('abreModalDeNombreComun',$data);
        -----   }
    --}}

    <div wire:ignore.self class="modal fade" id="ModalDeNombreComun" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        @if($conId == '0')
                            Ingresando Nuevo Nombre común al ejemplar {{ $ejId }}
                        @else
                            Editando datos de Nombre común {{ $conId }} del ejemplar {{ $ejId }}
                        @endif
                    </h5>
                    <button wire:click="cerrarModal('0')" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Fuente /Biblio -->
                        <div class="col-sm-12 col-md-12 form-group">
                            <span wire:ignore>
                                <label class="form-label" for="modnomcom_buscaBiblio2">Fuente/Bibliografía<red>*</red></label><br>
                                <select wire:model="modnomcom_buscaBiblio" id="modnomcom_buscaBiblio2" class="form-select @error('modnomcom_buscaBiblio') is-invalid @enderror" style="width:100%;">
                                    <option value=""></option>
                                    @foreach ($modnomcom_citas as $b)
                                        <option value="{{ $b->bib_id }}">
                                            @foreach($b->autores as $aut)
                                                <b>{{ $aut->bibaut_ap }} {{ $aut->bibaut_nombre }}, &nbsp; </b>
                                            @endforeach
                                            | {{ $b->bib_anio }} |
                                            {{ $b->bib_titulo }}
                                        </option>
                                    @endforeach
                                    {{-- <option value="nuevo">Nuevo tema</option> --}}
                                </select>
                                <div class="form-text">Buscar por apellido, año o título</div>
                            </span>
                            @error('modnomcom_buscaBiblio')<error>{{ $message }}</error>@enderror
                            @if($modnomcom_buscaBiblio > '0') Fuente seleccionada: {{ $modnomcom_buscaBiblio }} @endif
                        </div>
                    </div>

                    @if($modnomcom_buscaBiblio > '0')
                        <div class="row">
                            <!--  Nombre -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <label class="form-label" for="modnomcom_nombre">Texto del nombre<red>*</red></label>
                                <input wire:model="modnomcom_nombre" id="modnomcom_nombre" class="@error('modnomcom_nombre') is-invalid @enderror form-control" type="text">
                                <div class="form-text"></div>
                                @error('modnomcom_nombre')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- Lengua -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <span wire:ignore>
                                    <label class="form-label" for="modnomcom_lengua2">Lengua<red>*</red></label><br>
                                    <select wire:model="modnomcom_lengua" id="modnomcom_lengua2" class="@error('modnomcom_lengua') is-invalid @enderror form-control">
                                        <option value=""></option>
                                        @foreach ($modnomcom_lenguas as $l)
                                            <option value="{{ $l->clen_code }}">{{ $l->clen_lengua }} ({{ $l->clen_code }})</option>
                                        @endforeach
                                    </select>
                                </span>
                                <div class="form-text"></div>
                                @error('modnomcom_lengua')<error>{{ $message }}</error>@enderror
                                @if($modnomcom_lengua >'0' )Lengua seleccionada {{ $modnomcom_lengua }}@endif
                            </div>

                            <!-- Check de nombre de colecta -->
                            <div class="col-sm-12 col-md-4">
                                <div class="form-check">
                                    <br>
                                    <input wire:model="modnomcom_origen"  @if($modnomcom_origen=='1') checked @endif @if($edit_adcolviva == '0') disabled @endif type="checkbox" class="form-check-input">
                                    <label class="form-check-label" for="modnomcom_origen">
                                        Nombre otorgado en el sitio de colecta de este ejemplar

                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Lista de ubicaciones -->
                            <div class="col-12 form-group">
                                <label class="form-label">Ubicación del nombre:</label><br>
                                @if($modnomcom_ubicaciones != '')
                                    <div class="row">
                                        @foreach ($modnomcom_ubicaciones as $u)
                                            @if($u != '')
                                                <div class="col-3"><input type="text" value="{{ $u }}" class="form-control"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                @error('')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- Estado -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <label class="form-label" for="modnomcom_estado">Estado:</label>
                                <select wire:model="modnomcom_estado" wire:change="CargaMunicipios" id="modnomcom_estado" class="@error('modnomcom_estado') is-invalid @enderror form-select">
                                    <option value="modnomcom_estado">Indica el estado</option>
                                    @foreach ($modnomcom_estados as $e)
                                        <option value="{{ $e->cedo_nombre }}">{{ $e->cedo_nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text"></div>
                                @error('modnomcom_estado')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- Municipio -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <label class="form-label" for="modnomcom_mpio">Municipio</label><br>
                                <select wire:model="modnomcom_mpio" id="modnomcom_mpio" class="@error('modnomcom_mpio') is-invalid @enderror form-select agregar">
                                    @if($modnomcom_estado =='')
                                        <option value="">Selecciona primero un estado</option>
                                    @else
                                        <option value="">Indica un municipio</option>
                                        @foreach ($modnomcom_municipios as $m)
                                            <option value="{{ $m->cmun_mpioname }}">{{ $m->cmun_mpioname }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <!-- Botón Agregar ubicación-->

                                <i wire:click="AgregarMunicipio()" class="bi bi-plus-square agregar"></i>

                                <div class="form-text"></div>
                                @error('modnomcom_mpio')<error>{{ $message }}</error>@enderror
                            </div>


                        </div>

                        <div class="row">
                            <!-- observaciones -->
                            <div class="col-12 form-group">
                                <label class="form-label" for="modnomcom_notas">Notas sobre el nombre:</label>
                                <textarea wire:model="modnomcom_notas" id="modnomcom_notas" class="@error('modnomcom_notas') is-invalid @enderror form-control"></textarea>
                                <div class="form-text"></div>
                                @error('modnomcom_notas')<error>{{ $message }}</error>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                @if($conId > '0')
                                    <label class="form-label"><b>Archivos:</b> </label><br>
                                    <!-- archivo 1-->
                                    @if($modnomcom_file1 != '')
                                        Archivo: <a href="{{ $modnomcom_file1 }}" target="new">{{ $modnomcom_file1 }}</a>
                                        <i wire:click="borraArchivo('1')" wire:confirm="Estás por eliminar definitivamente este archivo. ¿deseas continuar?" class="bi bi-trash PaClick" style="margin-left:5px;"></i> &nbsp; &nbsp;
                                    @endif
                                    <!-- archivo 2-->
                                    @if($modnomcom_file2 != '')
                                        Archivo: <a href="{{ $modnomcom_file2 }}" target="new">{{ $modnomcom_file2 }}</a>
                                        <i wire:click="borraArchivo('2')" wire:confirm="Estás por eliminar definitivamente este archivo. ¿deseas continuar?" class="bi bi-trash PaClick" style="margin-left:5px;"></i> &nbsp; &nbsp;
                                    @endif
                                    <!-- archivo 3-->
                                    @if($modnomcom_file3 != '')
                                        Archivo: <a href="{{ $modnomcom_file3 }}" target="new">{{ $modnomcom_file3 }}</a>
                                        <i wire:click="borraArchivo('3')" wire:confirm="Estás por eliminar definitivamente este archivo. ¿deseas continuar?" class="bi bi-trash PaClick" style="margin-left:5px;"></i> &nbsp; &nbsp;
                                    @endif
                                    <!-- archivo 4-->
                                    @if($modnomcom_file4 != '')
                                        Archivo: <a href="{{ $modnomcom_file4 }}" target="new">{{ $modnomcom_file4 }}</a>
                                        <i wire:click="borraArchivo('4')" wire:confirm="Estás por eliminar definitivamente este archivo. ¿deseas continuar?" class="bi bi-trash PaClick" style="margin-left:5px;"></i> &nbsp; &nbsp;
                                    @endif
                                @endif
                            </div>
                            @if(  ($modnomcom_file1=='' OR $modnomcom_file2=='' OR $modnomcom_file3=='' OR $modnomcom_file4==''))
                                <!-- Agregar nuevo archivo -->
                                <div class="col-9 form-group">
                                    <label for="modnomcom_fileNvo" class="form-label">Agregar archivo</label>
                                    <input wire:model="modnomcom_fileNvo" type="file" class="form-control">
                                    <div class="form-text">Puedes agregar hasta 4 archivos con audio (del nombre), imagen (de la escritura) o video (con la pronunciación) del nombre </div>
                                    @error('modnomcom_fileNvo')<error>{{ $message }}</error>@enderror
                                </div>
                                <div class="col-3">
                                    @if($conId >'0' AND $modnomcom_fileNvo)
                                        {{ round($modnomcom_fileNvo->getSize() / 1000000, 2) }} Mb<br>
                                        <button wire:click="subirArchivo()" class="btn btn-primary btn-sm">Subir</button>
                                    @endif
                                    @if($conId =='0')
                                        <small>Cuando ingresas un nuevo nombre, sólo podrás subir un archivo. Si requieres más, ingrésalos editando el registro ya creado.</small>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            @if($conId > '0')
                                <!-- inactivar nombre -->
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-check">
                                        <br>
                                        <input wire:model.live="modnomcom_activo" @if($modnomcom_activo=='1') checked @endif class="form-check-input" type="checkbox" value="" name="activo" id="checkDefault">
                                        <label class="form-check-label" for="checkDefault">
                                            Nombre @if($modnomcom_activo=='1') activo (si desmarcas esta casilla, el nombre ya no será visible en el sistema) @else inactivo (marca esta casilla para que el nombre esté disponible en el sistema) @endif
                                        </label>
                                    </div>
                                </div>

                                <!-- Eliminar nombre -->
                                <div class="col-sm-6 col-md-3">
                                    <br>
                                    <button wire:click="BorrarNombre()" wire:confirm="Estas por eliminar definitivamente el nombre de este ejemplar. ¿Quieres continuar?" class="btn btn-secondary btn-sm">
                                        <i class="bi bi-trash"></i> Eliminar nombre
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" wire:click="GuardarDatosDeNombre()" wire:loadding.attr="disabled">Guardar</button>
                    <button wire:click="cerrarModal('0')" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <livewire:coleccion.ModalBibliografiaController />



    <script>
        Livewire.on('abreModalDeNombreComun',()=>{
            $('#ModalDeNombreComun').modal('show'); // Abre modal
            // console.log('va1');
        })
        Livewire.on('cierraModalDeNombreComun',()=>{
            // Cierra el modal, pero si recibe variable reload=1, recarga la pág
            $('#ModalDeNombreComun').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
            // console.log(event.detail.reload);
        })

        Livewire.on('AvisoExitoNomCom',()=>{
            alert(event.detail.msj);
            //  console.log(event.detail.msj);
        })

        //-------------------------------------------------
        //----------------------Inicia  select2 bibliografía
        // select2: https://www.youtube.com/watch?v=5ASYIAJ9ldE
        $('#modnomcom_buscaBiblio2').select2({
            dropdownParent: $('#ModalDeNombreComun'), //Para modales
            placeholder: "Busca autor, año o título", //Para ver mensaje predeterminado
            language: {                             // Mensaje cuando no encuentra nada
                noResults: function (params) {      // Mensaje cuando no encuentra nada
                    return $("<span>No hay resultados <a href='#' wire:click=AbrirModalBibliografia('0')>Crear nuevo</a></span>");// Mensaje cuando no encuentra nada
                }                                   // Mensaje cuando no encuentra nada
            },
            escapeMarkup: function (markup){ return markup; } //para renderizar HTML
        });
        $('#modnomcom_buscaBiblio2').on('change', function(){
            // alert(this.value);
            // console.log('a',this.value)
            @this.set('modnomcom_buscaBiblio',this.value)
        })
        //-------------------------------------------------
        //----------------------Inicia  select2 lenguas
        $('#modnomcom_lengua2').select2({
            dropdownParent: $('#ModalDeNombreComun'), //Para modales
            placeholder: "Busca la lengua", //Para ver mensaje predeterminado
        });
        $('#modnomcom_lengua2').on('change', function(){
            @this.set('modnomcom_lengua',this.value)
        })

    </script>
</div>
