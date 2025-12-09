<div>
    <!-- -------------------------------------------------------------------- -->
    <!---------------------- INICIA MODAL DE ALIAS -------------------------- -->
    {{-- ----   requiere en view:
        -----   <livewire:coleccion.ModalAliasController>
        -----   <wire:click="abreModalAlias()">
        -----
        -----   y en controller:
        -----   public function abreModalAlias(){
        -----       $data=['ejmId'=>IdDelEjemplar, 'tipo'=>TipoDeAlias]; ##### ejmId=número Id del ejemplar; tipo=['ejemplar','bitácora','ubicación','otro']
        -----       $this->dispatch('abreModalDeAlias',$data);
        -----   }
    --}}

    <div wire:ignore.self class="modal fade" id="ModalDeAlias" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        Asignando alias del ejemplar {{ $modalias_ejmId }}
                    </h5>
                    <button wire:click="borrarTodoModal()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <!-- tipo de alias -->
                        <div class="col-12 form-group">
                            <label for="modalias_tipoAlias" class="form-label">Alias de</label>
                            <select wire:model.live="modalias_tipoAlias" id="modalias_tipoAlias" class="@error('modalias_tipoAlias') is-invalid @enderror form-select" @if($modalias_tipoPredef=='1') disabled @endif>
                                <option value="ejemplar">Ejemplar</option>
                                <option value="bitácora">Bitácora</option>
                                <option value="ubicación">Ubicación</option>
                                <option value="otro">Otro</option>
                            </select>
                            <div class="form-text"></div>
                            @error('modalias_tipoAlias')<error>{{ $mesagge }}</error>@enderror
                        </div>

                        <!-- if tipo=otro -->
                        @if($modalias_tipoAlias=='otro')
                            <div class="col-12 form-group">
                                <label for="modalias_otroTipo" class="form-label">Indica el otro tipo<red>*</red></label>
                                <input wire:model="modalias_otroTipo" type="text" id="modalias_otroTipo" class="@error('modalias_otroTipo') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('modalias_otroTipo')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- Texto -->
                        <div class="col-12 form-group">
                            <label for="modalias_nuevoAlias" class="form-label">Indica el nuevo alias de {{ $modalias_tipoAlias }}<red>*</red></label>
                            <input wire:model="modalias_nuevoAlias" type="text" id="modalias_nuevoAlias" class="@error('modalias_nuevoAlias') is-invalid @enderror form-control">
                            <div class="form-text">Indica todas las etiquetas, clavos y nombres que ha tenido este ejemplar</div>
                            @error('modalias_nuevoAlias')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- explicación -->
                        <div class="col-12 form-group">
                            <label for="modalias_explica" class="form-label">Explicación:</label>
                            <textarea wire:model="modalias_explica" id="modalias_explica" class="@error('modalias_explica') is-invalid @enderror form-control"></textarea>
                            <div class="form-text">En caso de requerirse, explica la razón del nombre</div>
                            @error('modalias_explica')<error>{{ $message }}</error>@enderror
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button wire:click="borrarTodoModal()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button wire:click="GuardarAlias()" wire:loading.attr="disabled" class="btn btn-primary"> Asignar alias</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        Livewire.on('abreModalDeAlias',()=>{
            $('#ModalDeAlias').modal('show'); // Abre modal
            // console.log('va1');

        })
        Livewire.on('cierraModalDeAlias',()=>{
            $('#ModalDeAlias').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        })
        Livewire.on('AvisoExitoAlias',()=>{
            alert(event.detail.msj);
            // console.log(event.detail.msj);
        })

    </script>

</div>
