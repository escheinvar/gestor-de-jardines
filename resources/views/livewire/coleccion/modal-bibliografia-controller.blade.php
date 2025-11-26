<div>
    <!-- ------------------------------------------------------------------------------------- -->
    <!---------------------- INICIA MODAL DE BIBLIOGRAFÍA ------------------------------------- -->
    {{-- ----   requiere en view:
        -----   <livewire:coleccion.ModalBibliografiaControlles>
        -----   <wire:click="AbrirModalBibliografia(bibId)">
        -----
        -----   y en controller:
        -----   public function AbrirModalBibliografia($par1){
        -----       $data=['bibId'=>$par1];  ### donde $par1 tiene el Id del registro bibliográfico a editar ó 0 para nuevo
        -----       $this->dispatch('abreModalDeBibliogfafia',$data);
        -----   }
    --}}

    <div wire:ignore.self class="modal fade" id="ModalDeBibliografia" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        @if($bibId == '0')
                            Ingresando Nuevo Registro Bibliográfico
                        @else
                            Editando Registro Bibliográfico
                        @endif

                    </h5>
                    <button wire:click="borrarTodo()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 form-group">
                            <!-- ------------------ Lista de autores ----------------------- -->
                            <label for="" class="form-label">Autores:</label>
                            @foreach ($autores as $a)
                                {{$a['bibaut_ap'] }} {{  $a['bibaut_nombre'] }},&nbsp; &nbsp;
                            @endforeach
                        </div>

                        <!-- --------- Apellido(s) del autor --------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="bibmodal_ap" class="form-label">Apellido(s):<red>*</red></label>
                            <input wire:model="bibmodal_ap" id="bibmodal_ap" type="text" class="@error('bibmodal_ap') is-invalid @enderror form-control">
                            <div class="form-text">Apellido(s) o apellido combinado del autor.</div>
                            @error('bibmodal_ap')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- --------- Nombre del autor --------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="bibmodal_nombre" class="form-label">Nombre(s):<red>*</red></label>
                            <input wire:model="bibmodal_nombre" id="bibmodal_nombre" type="text" class="@error('bibmodal_nombre') is-invalid @enderror form-control">
                            <div class="form-text">Nombre del autor</div>
                            @error('bibmodal_nombre')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- --------- Orcid del autor --------- -->
                        <div class="col-sm-10 col-md-3 form-group">
                            <label for="bibmodal_orcid" class="form-label">ORCID ID</label>
                            <input wire:model="bibmodal_orcid" id="bibmodal_orcid" type="text" class="@error('bibmodal_orcid') is-invalid @enderror form-control">
                            <div class="form-text">Clave ORCID del autor</div>
                            @error('bibmodal_orcid')<error>{{ $message }}</error>@enderror
                        </div>
                        <div class="col-sm-2 col-md-1 form-group">
                            <button wire:click="AgregarAutor" class="btn my-4">
                                <i class="bi bi-plus-square"></i>
                            </button>
                        </div>

                    </div>
                    <div class="row">
                        <!-- -------------------- Tipo de registro ------------------------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="bibmodal_tipo" class="form-label">Tipo al que pertenece<red>*</red></label>
                            <select wire:model.live="bibmodal_tipo" id="bibmodal_tipo" class="@error('bibmodal_tipo') is-invalid @enderror form-select">
                                <option value="">Tipo de registro</option>
                                @foreach ($tipos as $t)
                                    <option value="{{ $t->con_txt }}"> {{ $t->con_txt }} </option>
                                @endforeach
                            </select>
                            <div class="form-text">Indica el tipo de registro bibliográfico que se va a generar.</div>
                            @error('bibmodal_tipo')<error>{{ $message }}@enderror
                        </div>
                        <!-- --------- Año --------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="" class="form-label">Año</label>
                            <input wire:model="" id="" type="text" class="@error('') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- --------- --------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="" class="form-label"></label>
                            <input wire:model="" id="" type="text" class="@error('') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- --------- --------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="" class="form-label"></label>
                            <input wire:model="" id="" type="text" class="@error('') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- --------- --------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="" class="form-label"></label>
                            <input wire:model="" id="" type="text" class="@error('') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- --------- --------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="" class="form-label"></label>
                            <input wire:model="" id="" type="text" class="@error('') is-invalid @enderror form-control">
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>


                        <!-- ---------------- FAMILIA -------------------------- -->
                        <div class="col-sm-12 col-md-8 form-group">
                            <label for="modsp_familia" class="form-label">Familia</label>
                            <input wire:model="" type="text" id="modsp_familia" class="@error('modsp_familia') is-invalid @enderror form-control"    >
                            <div class="form-text">Familia biológica a la que pertenece</div>
                            @error('modsp_familia')<error>{{ $message }}</error>@enderror
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
            Livewire.on('abreModalDeBibliogfafia',()=>{
                $('#ModalDeBibliografia').modal('show'); // Abre modal
                // console.log('va1');

            })
            Livewire.on('cierraModalDeBibliogfafia',()=>{
                $('#ModalDeBibliografia').modal('hide');
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
