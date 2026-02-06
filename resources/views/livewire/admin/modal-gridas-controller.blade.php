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
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        Ingresar nueva grida
                    </h5>
                    <button wire:click="Cerrar()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- -------------------- Nombre ------------------------- -->
                        <div class="col-12 form-group">
                            <label for="gri_nombre" class="form-label">Indica el nombre de la grida<red>*</red></label>
                            <input wire:model="gri_nombre" class="form-control @error('gri_nombre') is-invalid @enderror" type="text">
                            <div class="form-text">Indica un nombre corto que defina la grida</div>
                            @error('gri_nombre')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- -------------------- Resolución X -------------------------- -->
                        <div class="col-6 form-group">
                            <label for="gri_x" class="form-label">Resolución X en metros<red>*</red></label>
                            <input wire:model="gri_x" class="form-control @error('gri_x') is-invalid @enderror" type="number">
                            <div class="form-text">Metros entre líneas este-oeste</div>
                            @error('gri_x')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- -------------------- Resolución Y -------------------------- -->
                        <div class="col-6 form-group">
                            <label for="gri_y" class="form-label">Resolución Y en metros<red>*</red></label>
                            <input wire:model="gri_y" class="form-control @error('gri_y') is-invalid @enderror" type="number">
                            <div class="form-text">Metros entre líneas norte-sur</div>
                            @error('gri_y')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- -------------------- Explica -------------------------- -->
                        <div class="col-12 form-group">
                            <label for="gri_exp" class="form-label">Explicación:</label>
                            <textarea wire:model="gri_exp" class="form-control @error('gri_exp') is-invalid @enderror"></textarea>
                            <div class="form-text">Si lo requieres, ingresa una breve explicación de la grida</div>
                            @error('gri_exp')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- -------------------- GeoJson X -------------------------- -->
                        <div class="col-12 form-group">
                            <label for="gri_file" class="form-label">Archivo GeoJson<red>*</red></label>
                            <input wire:model="gri_file" class="form-control @error('gri_file') is-invalid @enderror" type="file">
                            <div class="form-text">Ingresa el archivo GeoJson con la grida</div>
                            @error('gri_file')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" wire:click="Guardar()">Guardar</button>
                    <button wire:click="Cerrar()" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
        Livewire.on('AvisoExitoGrida',()=>{
            alert(event.detail.msj);
        })

    </script>

</div>
