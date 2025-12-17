<div>
    <!-- -------------------------------------------------------------------- -->
    <!---------------------- INICIA MODAL DE SUBCOLECCIONES -------------------------- -->
    {{-- ----   requiere en view:
        -----   <livewire:coleccion.ModalSubcoleccionesController>
        -----   <wire:click="abreModalSubcolecciones()">
        -----
        -----   y en controller:
        -----   public function abreModalSubcolecciones($par1){
                    $data=['ejmId'=>$par1];
                   $this->dispatch('abreModalDeSubcolecciones',$data);
                }
    --}}

    <div wire:ignore.self class="modal fade" id="ModalDeSubcolecciones" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        Asignando ejemplar {{ $modsubcol_ejmid }} a una sub colección
                    </h5>
                    <button wire:click="borrarTodoModal()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <!-- seleccina colección -->
                        <div class="col-12 form-group">
                            <label for="modsubcol_coleccion" class="form-label">Subcolección</label>
                            <select wire:model.live="modsubcol_coleccion" id="modsubcol_coleccion" class="@error('modsubcol_coleccion') is-invalid @enderror form-select">
                                <option value="">Indica la subcolección</option>
                                @foreach ($colecciones as $c)
                                    <option value="{{ $c->ccol_coleccion }}">{{ $c->ccol_coleccion }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('modsubcol_coleccion')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- explicación -->
                        <div class="col-12 my-4">
                            @if($modsubcol_coleccion != '')
                                @if($colecciones->where('ccol_coleccion',$modsubcol_coleccion)->value('ccol_icono') != '')
                                    <center>
                                        <img src="{{ $colecciones->where('ccol_coleccion',$modsubcol_coleccion)->value('ccol_icono') }}" style="width:150px;">
                                    </center>
                                @endif
                                {{ $colecciones->where('ccol_coleccion',$modsubcol_coleccion)->value('ccol_explica') }}
                            @endif
                            <div class="form-text my-4">Selecciona la colección a la que pertenece el ejemplar.<br>
                                Recuerda que un ejemplar puede pertenecer a más de una colección
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button wire:click="borrarTodoModal()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button wire:click="AsignarAcoleccion('')" wire:loading.attr="disabled" class="btn btn-primary"> Asignar a colección</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        Livewire.on('abreModalDeSubcolecciones',()=>{
            $('#ModalDeSubcolecciones').modal('show'); // Abre modal
            // console.log('va1');

        })
        Livewire.on('cierraModalDeSubcolecciones',()=>{
            $('#ModalDeSubcolecciones').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        })
        Livewire.on('AvisoExitoSubcolecciones',()=>{
            alert(event.detail.msj);
            // console.log(event.detail.msj);
        })

    </script>

</div>
