<div>
    <!-- ------------------------------------------------------------------------------------- -->
    <!---------------------- INICIA MODAL DE NUEVA GRIDA ------------------------------------- -->
    {{-- ----   requiere en view:
        -----   <livewire:admin.ModalGridasController>
        -----   <wire:click="AbrirModalGridas()">
        -----
        -----   y en controller:
        -----   public function AbrirModalGridas($id){
                    $data=['gridId'=>$par1];  ### donde $par1 tiene el Id de la grida a editar ó 0 para nuevo<
                    $this->dispatch('abreModalDeGridas');
                }
    --}}

    <div wire:ignore.self class="modal fade" id="ModalDeGridas" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        Ingresar nueva grida
                    </h5>
                    <button wire:click="borrarTodo()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- -------------------- Nombre ------------------------- -->
                        <div class="col-12 form-group">
                            <label for="modsp_reino" class="form-label">Indica el nombre común<red>*</red></label>
                            <input wire:model="nombre" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" wire:click="Guardar()">Guardar</button>
                    <button wire:click="borrarTodo()" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        Livewire.on('abreModalDeGridas',()=>{
            $('#ModalDeGridas').modal('show'); // Abre modal
            // console.log('va1');
            // @this.set('autId',autId, live=true);

        })
        Livewire.on('cierraModalDeGridas',()=>{
            $('#ModalDeGridas').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        })
        // Livewire.on('AvisoExitoNvaEspecie',()=>{
        //     alert(event.detail.msj);
        //     # console.log(event.detail.msj);
        // })

    </script>

</div>
