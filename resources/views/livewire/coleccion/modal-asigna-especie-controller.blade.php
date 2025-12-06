<div>
    <!-- ------------------------------------------------------------------------------------- -->
    <!---------------------- INICIA MODAL DE ASIGNACIÓN DE NOMBRE CIENTÍFICO ----------------- -->
    {{-- ----   requiere en view:
        -----   <livewire:coleccion.ModalNuevaEspecieController>
        -----   <wire:click="abreModalDeNombreCientifico(autId)">
        -----
        -----   y en controller:
        -----   public function abreModalDeNombreCientifico(){
        -----       $this->dispatch('abreModalNuevaEspecie',$data);
        -----   }
    --}}

    <div wire:ignore.self class="modal fade" id="ModalDeAsignaNombreCientifico" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        Asignando nuevo Nombre Científico al catálogo {{ $edit_adcolviva }}
                    </h5>
                    <button wire:click="borrarTodo()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- -------------------- Id de Ejemplar ------------------------- -->
                        <div class="col-sm-12 col-md-2 form-group">
                            <label for="idEjem" class="form-label">Id de ejemplar:<red>*</red></label>
                            <input wire:model="idEjem" type="text" id="idEjem" class="@error('idEjem') is-invalid @enderror form-control" readonly>
                            <div class="form-text"></div>
                            @error('idEjem')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- -------------------- Reino ------------------------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="modcient_reino" class="form-label">Reino al que pertenece<red>*</red></label>
                            <select wire:model="modcient_reino" wire:change="borrarTodo()" id="modcient_reino" class="@error('modcient_reino') is-invalid @enderror form-select">
                                <option value="">Indica un reino</option>
                                <option value="pl">Plantas</option>
                                <option value="an">Animal</option>
                                <option value="ho">Hongos</option>
                                <option value="pr">Protistas</option>
                                <option value="ba">Bacteria</option>
                                <option value="ar">Arquea</option>
                            </select>
                            <div class="form-text">Indica el reino al que pertenece el ejemplarla especie.</div>
                            @error('modcient_reino')<error>{{ $message }}@enderror
                        </div>

                        <!-- -------------------- Género de catálogo ------------------------- -->
                        <div class="col-sm-9 col-md-4 form-group">
                            <label for="modcient_generoBusca" class="form-label">Buscar Género<red>*</red></label>
                            <input wire:model="modcient_generoBusca" type="text" id="modcient_generoBusca" class="@error('modcient_generoBusca') is-invalid @enderror form-control" >
                            <div class="form-text">Escribe el nombre del género y busca</div>
                            @error('modcient_generoBusca')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- ---------------- botón buscar género de catálogo  ---------------- -->
                        <div class="col-sm-3 col-md-2 form-group">
                            <label class="form-label"> &nbsp; </label><br>
                            <button wire:click="BuscarGenero()" wire:loading.attr="disabled" class="btn btn-primary"  >Buscar</button>
                            <error wire:loading wire:target="BuscarGenero" style="display:none">Buscando...</error>
                        </div>
                    </div>

                    <div class="row">
                        @if($modcient_generoBusca != '' AND $modcient_especies->count()=='0')

                        @else
                            <div class="col-12 form-group">
                                <!-- -------------------- Selector Especie de catálogo ------------------------- -->
                                <label for="modcient_especieSelected" class="form-label">Especie e infraespecie (catálogo)<red>*</red></label><br>
                                <select  wire:model.live="modcient_especieSelected" id="modcient_especieSelected" class="@error('modcient_especieSelected') is-invalid @enderror form-select">
                                    @if($modcient_especies->count() > 0)
                                        <option value="">Selecciona una especie del catálogo</option>
                                        @foreach ($modcient_especies as $e)
                                            <option value="{{ $e->sp_id }}">
                                                [{{ $e->sp_familia }}]
                                                {{ $e->sp_name }}
                                            </option>
                                        @endforeach
                                        <option value="NuevaEspecieAcatalogo">No está en este catálogo</option>
                                    @else
                                        <option value="">Busca un género primero</option>
                                    @endif
                                </select>
                                <div class="form-text">Selecciona la especie.</div>
                                @error('modcient_especieSelected')<error>{{ $message }}@enderror
                            </div>

                            <!-- ---------------- Autoridad que define  ---------------- -->
                            <div class="col-6 form-group">
                                <label for="modcient_autoridad" class="form-label">Nombre de quien determina:<red>*</red></label><br>
                                <select wire:model="modcient_autoridad" id="modcient_autoridad" class="@error('modcient_autoridad') is-invalid @enderror form-select @if(in_array('curador-cientifico',session('rol'))) agregar @endif">
                                    <option value="">Indica la autoridad que determina</option>
                                    @if($modcient_autoridades AND $modcient_autoridades->count() > 0)
                                        @foreach ($modcient_autoridades as $a)
                                            <option value="{{ $a->aut_id }}"> {{ $a->aut_nombre }} {{ $a->aut_ap1 }} {{ $a->aut_ap2 }}
                                        @endforeach
                                    @endif
                                </select>
                                @if(in_array('curador-cientifico',session('rol')))
                                    <i wire:click="AbrirModalAutoridades('0')" class="bi bi-plus-square-fill @if(in_array('curador-cientifico',session('rol'))) agregar @endif"></i>
                                @endif
                                <div class="form-text"></div>
                                @error('modcient_autoridad')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- ---------------- Fecha en que define  ---------------- -->
                            <div class="col-6 form-group">
                                <label for="modcient_fecha" class="form-label">Fecha en la que determina:<red>*</red></label>
                                <input wire:model="modcient_fecha" id="modcient_fecha" type="date" class="@error('modcient_fecha') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('modcient_fecha')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif
                        <div class="col-12 form-group">
                            @if(($modcient_generoBusca != '' AND $modcient_especies->count()=='0')  OR ($modcient_especieSelected =='NuevaEspecieAcatalogo'))
                                <label class="form-label">No existe ese nombre científico en el catálogo de especies</label><br>
                                Solo el rol curador-cientifico puede incluir una especie al catálogo.
                                <div class="form-text">Envíale un mensaje desde tu <a href="/buzon">buzón</a> indicando tu solicitud</div>
                                @if($edit_curcient=='1')
                                    <button wire:click="abreModalParaNuevaEspecie()" type="button" class="btn btn-primary"> + Agregar a catálogo</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button wire:click="borrarTodo()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                    @if($modcient_especieSelected != '' AND $modcient_especieSelected !='NuevaEspecieAcatalogo')
                        <label class="form-label"> &nbsp; </label><br>
                        <button wire:click="DefineEspecie()" wire:loading.attr="disabled" class="btn btn-primary"> Asignar nombre científico</button>
                        <error wire:loading wire:target="DefineEspecie" style="display:none">Leyendo...</error>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <livewire:coleccion.modal-nueva-especie-controller />
    <livewire:coleccion.modal-autoridades-controller />



    <script>
        Livewire.on('abreModalDeNombreCientifico',()=>{
            $('#ModalDeAsignaNombreCientifico').modal('show'); // Abre modal
            // console.log('va1');

        })
        Livewire.on('cierraModalDeNombreCientifico',()=>{
            $('#ModalDeAsignaNombreCientifico').modal('hide');
            // console.log('va2');
        })
        Livewire.on('AvisoExitoAsignaSp',()=>{
            alert(event.detail.msj);
            // console.log(event.detail.msj);
        })

    </script>


    <!---------------------- TERMINA MODAL DE ASIGNACIÓN DE NOMBRE CIENTÍFICO  --------------------------------------- -->
    <!-- --------------------------------------------------------------------------------------- -->
</div>

