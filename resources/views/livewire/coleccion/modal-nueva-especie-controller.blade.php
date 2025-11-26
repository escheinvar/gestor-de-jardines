<div>
    <!-- ------------------------------------------------------------------------------------- -->
    <!---------------------- INICIA MODAL DE NUEVA ESPECIE ------------------------------------- -->
    {{-- ----   requiere en view:
        -----   <livewire:coleccion.ModalNuevaEspecieController>
        -----   <wire:click="AbrirModalNuevaEspecie(autId)">
        -----
        -----   y en controller:
        -----   public function AbrirModalNuevaEspecie($par1){
        -----       $data=['spid'=>$par1];  ### donde $par1 tiene el Id de especie a editar ó 0 para nueva
        -----       $this->dispatch('abreModalNuevaEspecie',$data);
        -----   }
    --}}

    <div wire:ignore.self class="modal fade" id="ModalDeNuevaEspecie" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        @if($spid == '0')
                            Ingresando Nuevo Nombre Científico al catálogo
                        @else
                            Editando datos de Nombre Científico
                        @endif

                    </h5>
                    <button wire:click="borrarTodo()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- -------------------- Reino ------------------------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="modsp_reino" class="form-label">Tipo al que pertenece<red>*</red></label>
                            <select wire:model.live="modsp_reino" wire:change="seleccionaReino()" id="modsp_reino" class="@error('modsp_reino') is-invalid @enderror form-select">
                                <option value="">Indica un reino</option>
                                <option value="an">Animal</option>
                                <option value="pl">Plantas</option>
                                <option value="ho">Hongos</option>
                                <option value="pr">Protistas</option>
                                <option value="ba">Bacteria</option>
                                <option value="ar">Arquea</option>
                            </select>
                            <div class="form-text">Indica el reino al que pertenece la especie.</div>
                            @error('modsp_reino')<error>{{ $message }}@enderror
                        </div>
                        <!-- ---------------- forzar a catálogo -------------------------- -->
                        {{--
                        <div class="col-sm-12 col-md-3 form-check">
                            <input wire:model.live="modsp_forzarcatalogo" class="form-check-input" type="checkbox" value="1" id="modsp_forzarcatalogo">
                            <label class="form-check-label" for="modsp_forzarcatalogo">Forzar a catálogos {{ $modsp_forzarcatalogo }}</label>
                        </div>
                            --}}
                        <!-- ---------------- FAMILIA -------------------------- -->
                        <div class="col-sm-12 col-md-8 form-group">
                            <label for="modsp_familia" class="form-label">Familia</label>
                            <input wire:model="modsp_familia" type="text" id="modsp_familia" class="@error('modsp_familia') is-invalid @enderror form-control"   @if($modsp_forzarcatalogo=='1') disabled @endif >
                            <div class="form-text">Familia biológica a la que pertenece</div>
                            @error('modsp_familia')<error>{{ $message }}</error>@enderror
                        </div>

                    </div>
                    @if($modsp_reino != '')
                        <div class="row">
                            <!-- -------------------- Género de catálogo ------------------------- -->
                            <div class="col-sm-9 col-md-4 form-group">
                                <label for="modsp_generoBusca" class="form-label">Buscar Género<red>*</red></label>
                                <input wire:model="modsp_generoBusca" type="text" id="modsp_generoBusca" class="@error('modsp_generoBusca') is-invalid @enderror form-control" @if($modsp_forzarcatalogo=='0') disabled @endif>
                                <div class="form-text">Escribe el nombre del género y busca</div>
                                @error('modsp_generoBusca')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- ---------------- botón buscar género de catálogo  ---------------- -->
                            <div class="col-sm-3 col-md-2 form-group">
                                <label class="form-label"> &nbsp; </label><br>
                                <button wire:click="BuscarGenero()" wire:loading.attr="disabled" class="btn btn-primary"  @if($modsp_forzarcatalogo=='0') disabled @endif>Buscar</button>
                                <error wire:loading wire:target="BuscarGenero" style="display:none">Buscando...</error>
                            </div>

                            <div class="col-sm-9 col-md-4 form-group" wire:ignore.self>
                                <!-- -------------------- Especie de catálogo ------------------------- -->
                                <label for="modsp_especieSelected" class="form-label">Especie e infraespecie (catálogo)<red>*</red></label>
                                <select  wire:model="modsp_especieSelected" id="modsp_especieSelected" class="@error('modsp_especieSelected') is-invalid @enderror form-select" @if($modsp_forzarcatalogo=='0') disabled @endif>
                                    @if($especies->count() > 0)
                                        <option value="">Selecciona una especie del catálogo</option>
                                        @foreach ($especies as $e)
                                            <option value="{{ $e->id }}">
                                                [{{ $e->familia }}]
                                                {{ $e->genero }}
                                                {{ $e->sp }} @if($e->sp == '') -- género -- @endif
                                                @if($e->ssp != ''), {{ $e->ssp }} @endif
                                            </option>
                                        @endforeach
                                        <option value="NuevaEspecie">No está en este catálogo</option>
                                    @else
                                        <option value="">Busca un género primero</option>
                                    @endif
                                </select>
                                <div class="form-text">Selecciona la especie.</div>
                                @error('modsp_especieSelected')<error>{{ $message }}@enderror
                            </div>
                            <!-- ---------------- botón definir especie de catálogo  ---------------- -->
                            <div class="col-sm-3 col-md-2 form-group">
                                <label class="form-label"> &nbsp; </label><br>
                                <button wire:click="DefineEspecie()" wire:loading.attr="disabled" class="btn btn-primary"  @if($modsp_forzarcatalogo=='0') disabled @endif>Definir</button>
                                <error wire:loading wire:target="DefineEspecie" style="display:none">Leyendo...</error>
                            </div>

                        </div>

                        <div class="row">
                            <!-- -------------------- Género manual ------------------------- -->
                            <div class="col-sm-9 col-md-4 form-group">
                                <label for="modsp_genero" class="form-label">Género<red>*</red></label>
                                <input wire:model="modsp_genero" type="text" id="modsp_genero" class="@error('modsp_genero') is-invalid @enderror form-control" @if($modsp_forzarcatalogo=='1') disabled @endif>
                                <div class="form-text">Escribe el nombre del género</div>
                                @error('modsp_genero')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- -------------------- Especie manual ------------------------- -->
                            <div class="col-sm-9 col-md-4 form-group">
                                <label for="modsp_especie" class="form-label">Especie</label>
                                <input wire:model="modsp_especie" type="text" id="modsp_especie" class="@error('modsp_especie') is-invalid @enderror form-control" @if($modsp_forzarcatalogo=='1') disabled @endif>
                                <div class="form-text">Escribe el nombre de la especie</div>
                                @error('modsp_especie')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- -------------------- Infrasp manual ------------------------- -->
                            <div class="col-sm-9 col-md-4 form-group">
                                <label for="modsp_ssp" class="form-label">Categoría infraespecífica</label>
                                <input wire:model="modsp_ssp" type="text" id="modsp_ssp" class="@error('modsp_ssp') is-invalid @enderror form-control" @if($modsp_forzarcatalogo=='1') disabled @endif>
                                <div class="form-text">Escribe la categoría infraespecífica y su nombre. </div>
                                @error('modsp_ssp')<error>{{ $message }}</error>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- -------------------- Nombre científico ------------------------- -->
                            <div class="col-sm-9 col-md-4 form-group">
                                <label for="modsp_name" class="form-label">Nombre científico <red>*</red></label>
                                <input wire:model="modsp_name" type="text" id="modsp_name" class="@error('modsp_name') is-invalid @enderror form-control" @if($modsp_forzarcatalogo=='1') disabled @endif>
                                <div class="form-text">Escribe el nombre del autor de la especie</div>
                                @error('modsp_name')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- -------------------- Autor ------------------------- -->
                            <div class="col-sm-9 col-md-4 form-group">
                                <label for="modsp_autor" class="form-label">Autor de la especie <red>*</red></label>
                                <input wire:model="modsp_autor" type="text" id="modsp_autor" class="@error('modsp_autor') is-invalid @enderror form-control" @if($modsp_forzarcatalogo=='1') disabled @endif>
                                <div class="form-text">Escribe el nombre del autor de la especie</div>
                                @error('modsp_autor')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- -------------------- Referencia ------------------------- -->
                            <div class="col-sm-9 col-md-4 form-group">
                                <label for="modsp_cita" class="form-label">Cita de referencia <red>*</red></label>
                                <input wire:model="modsp_cita" type="text" id="modsp_cita" class="@error('modsp_cita') is-invalid @enderror form-control" @if($modsp_forzarcatalogo=='1') disabled @endif>
                                <div class="form-text">Escribe la cita del artículo en el que se registró la especi</div>
                                @error('modsp_cita')<error>{{ $message }}</error>@enderror
                            </div>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">

                    <button class="btn btn-primary" wire:click="Guardar()">Guardar</button>

                    <button wire:click="borrarTodo()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


        <script>
            Livewire.on('abreModalDeNuevaEspecie',()=>{
                $('#ModalDeNuevaEspecie').modal('show'); // Abre modal
                // console.log('va1');
                // @this.set('autId',autId, live=true);

            })
            Livewire.on('cierraModalDeNuevaEspecie',()=>{
                $('#ModalDeNuevaEspecie').modal('hide');
                // console.log('va2');
            })
            // Livewire.on('AvisoExitoAutoridades',()=>{
            //     alert(event.detail.msj);
            //     # console.log(event.detail.msj);
            // })

        </script>


    <!---------------------- TERMINA MODAL DE NUEVA ESPECIE --------------------------------------- -->
    <!-- --------------------------------------------------------------------------------------- -->
</div>
