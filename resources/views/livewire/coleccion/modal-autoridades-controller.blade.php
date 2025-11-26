<div>
    <!-- ------------------------------------------------------------------------------------- -->
    <!---------------------- INICIA MODAL DE AUTORIDADES ------------------------------------- -->
    {{-- ----   requiere en view:
        -----   <livewire:coleccion.autoridades-controller>
        -----   <wire:click="AbrirModalAutoridades(autId)">
        -----
        -----   y en controller:
        -----   public function AbrirModalAutoridades($par1){
        -----       $data=['autId'=>$par1];
        -----       $this->dispatch('abreModalDeAutoridades',$data);
        -----   }
    --}}

    <div wire:ignore.self class="modal fade" id="ModalDeAutoridades" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        @if($autId=='0')
                            Ingresando nueva autoridad
                        @else
                            Editando datos de autoridad {{ $autId }}
                        @endif
                    </h5>
                    <button wire:click="borrarTodo()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="ap1" class="form-label">Primer Apellido <red>*</red></label>
                            <input wire:model.live="ap1" type="text" id="ap1" class="@error('ap1') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('ap1')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="ap2" class="form-label">Segundo Apellido</label>
                            <input wire:model.live="ap2" type="text" id="ap2" class="@error('ap2') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('ap2')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="nombre" class="form-label">Nombre <red>*</red></label>
                            <input wire:model.live="nombre" type="text" id="nombre" class="@error('nombre') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('nombre')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="institu" class="form-label">Institución</label>
                            <input wire:model.live="institu" type="text" id="institu" class="@error('institu') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('institu')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="mail" class="form-label">Correo</label>
                            <input wire:model.live="mail" type="" id="mail" class="@error('mail') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('mail')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="tel" class="form-label">Teléfono</label>
                            <input wire:model.live="tel" type="text" id="tel" class="@error('tel') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('tel')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="tipo" class="form-label">Tipo de autoridad <red>*</red></label>
                            <select wire:model.live="tipo" id="tipo" class="@error('tipo') is-invalid @enderror form-select">
                                <option value="">Indicar un tipo</option>
                                @foreach ($tipos as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('tipo')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-sm-12 col-md-8 form-group">
                            <label for="tema" class="form-label">Temas</label>
                            <input wire:model.live="tema" type="text" id="tema" class="@error('tema')error @enderror form-control">
                            <div class="form-text">Indicar los temas, separados por punto y coma.</div>
                            @error('tema')<error>{{ $message }}</error>@enderror
                        </div>

                    </div>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-primary" wire:click="Guardar()">Guardar</button>

                    <button wire:click="borrarTodo()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        Livewire.on('abreModalDeAutoridades',()=>{
            $('#ModalDeAutoridades').modal('show'); // Abre modal
            // console.log('va1');
            // @this.set('autId',autId, live=true);

        })
        Livewire.on('cierraModalDeAutoridades',()=>{
            $('#ModalDeAutoridades').modal('hide');
            // console.log('va2');
        })
        Livewire.on('AvisoExitoAutoridades',()=>{
            alert(event.detail.msj);
            // console.log(event.detail.msj);
        })
    </script>


    <!---------------------- TERMINA MODAL DE AUTORIDADES --------------------------------------- -->
    <!-- --------------------------------------------------------------------------------------- -->
</div>
