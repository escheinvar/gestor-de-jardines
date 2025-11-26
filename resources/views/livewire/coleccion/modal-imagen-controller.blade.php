<div>
    <!-- ---------------------- MODAL PARA IMÁGENES ---------------------- -->
    <!-- recibe variables idImg (id de img ó 0) e modImg (módulo a cargar) -->
    <div wire:ignore.self class="modal fade" id="ModalDeImagen" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    @if($ImgId=='0')
                        <h5 class="modal-title">Cargando nuevo video, audio o imagen</h5>
                    @else
                        <h5 class="modal-title">Editando video, audio o imagen </h5>
                    @endif
                    <button wire:click="borrarTodo()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Nuevo Archivo -->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="NvoArch" class="form-label">Archivo @if($ImgId=='0')<red>*</red> @endif </label>
                            <input wire:model="NvoArch" id="NvoArch" class="@error('NvoArch') is-invalid @enderror form-control" type="file">
                            <div class="form-text">Selecciona el archivo a subir (imagen, audio o video)</div>
                            @error('NvoArch')<error>{{ $message }}@enderror
                        </div>

                        <!-- Ejemplar ó Especie -->
                        <div class="col-sm-6 col-md-3 form-group">
                            <label for="catego" class="form-label">Categoria</label>
                            <select wire:model.live="catego" id="catego" class="@error('catego') is-invalid @enderror form-select">
                                <option value=''>Indicar alguna</option>
                                <option value="ej">Ejemplar</option>
                                <option value="es">Especie</option>
                            </select>
                            <div class="form-text">Pertenencia del objeto.</div>
                            @error('catego')<error>{{ $message }}@enderror
                        </div>

                        <!-- ID de Ejemplar ó de Especie -->
                        <div class="col-sm-6 col-md-3  form-group">
                            <label for="categoID" class="form-label">ID de {{ $catego }}</label>
                            <input wire:model="categoID" id="categoID" class="@error('categoID') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Id de ejemplar o especie.</div>
                            @error('categoID')<error>{{ $message }}@enderror
                        </div>
                    </div>
                    <div class="row">
                        <!-- visualización de imagen -->
                        <div class="col-sm-12 col-md-9 form-group my-3 center">
                            <center>
                            <div>
                                @if($del=='1') <red><h1>Objeto Borrado</h1></red>@endif
                                @if($inact==true) <red>Objeto inactivo </red> @endif
                            </div>
                            <!-- ----------- Ver Imagen -------------- -->
                            @if($media=='img' AND $FileSize != 'No')
                                @if($ImgId != '0' AND $NvoArch == '')
                                    <img src="{{ $ruta }}" style="max-height:250px; max-width:100%;">
                                @elseif($NvoArch != '')
                                    <img src="{{ $NvoArch->temporaryUrl() }}" style="max-height:250px; max-width:100%;">
                                @endif
                            <!-- ----------- Ver Video -------------- -->
                            @elseif($media=='vid' AND $FileSize != 'No')
                                @if($ImgId != '0' AND $NvoArch == '')
                                    <video style=" max-height:250px;" controls>
                                        <source src="{{ $ruta }}" type="video/mp4">
                                        <source src="{{ $ruta }}" type="video/ogg">
                                        Tu navegador no soporta el video.
                                    </video>
                                @elseif($NvoArch != '')
                                    <video style=" max-height:250px;"  controls>
                                        <source src="{{ $NvoArch->temporaryUrl() }}" type="video/mp4">
                                        <source src="{{ $NvoArch->temporaryUrl() }}" type="video/ogg">
                                        Tu navegador no soporta el video.
                                    </video>
                                @endif

                            <!-- ----------- Escuchar Audio -------------- -->
                            @elseif($media=='aud' AND $FileSize != 'No')
                                @if($ImgId != '0' AND $NvoArch == '')
                                    <audio controls>
                                        <source src="{{ $ruta }}" type="audio/ogg">
                                        <source src="{{ $ruta }}" type="audio/mpeg">
                                        Tu navegador no soporta archivos de audio
                                    </audio>
                                @elseif($NvoArch != '')
                                    <audio controls>
                                        <source src="{{ $NvoArch->temporaryUrl() }}" type="audio/{{ $NvoArch->getClientOriginalExtension() }}">
                                        Tu navegador no soporta archivos de audio
                                    </audio>
                                @endif
                            @elseif($FileSize == 'No')
                                <center><red>-- No existe el archivo en el servidor --</red></center>
                            @endif
                            </center>
                        </div>
                        <!-- Datos del objeto -->
                        <div class="col-sm-12 col-md-3" style="font-size: 80%; vertical-align:bottom; color:rgb(88, 88, 88)">
                            @if($ImgId > '0' OR $NvoArch != '')
                                <div>
                                    <b>ImgId:</b> {{ $ImgId }}<br>
                                    <b>Objeto:</b> @if($media=='aud') Audio @elseif($media=='vid') Video @elseif($media=='img')Imagen @else Desconocido {{ $media }}@endif  <br>
                                    <b>Nombre:</b> {{ $ruta }}<br>
                                    @if($FileSize =='No')
                                        <red style="font-size:130%;">
                                            ¡ No existe el archivo en sistema !
                                        </red>
                                    @else
                                        <b>Tamaño:</b> {{ $FileSize }} MB <br>
                                    @endif
                                </div>

                                <div class="form-check">
                                    <input wire:model.live="inact" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Objeto inactivo
                                    </label>
                                </div>
                                <br><br>
                                <button wire:click="BorrarObjeto()" class="btn btn-secondary btn-sm my-1" wire:confirm="Estás por eliminar el objeto y todos sus datos. ¿Quieres continuar?"> <i class="bi bi-trash"> Eliminar objeto</i></button>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <!-- módulo de la imagen -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="modulo" class="form-label">Módulo al que pertenece<red>*</red></label>
                            <select wire:model.live="modulo" id="modulo" class="@error('modulo') is-invalid @enderror form-select">
                                <option value="">Indicar módulo</option>
                                @foreach($modulos as $m)
                                    <option value="{{ $m->cimg_modulo }}">{{ $m->cimg_modulo }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Indica el área a la que pertenece.</div>
                            @error('modulo')<error>{{ $message }}@enderror
                        </div>

                        <!-- tipo de imagen -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="tipo1" class="form-label">Tipo al que pertenece<red>*</red></label>
                            <select wire:model.live="tipo1" id="tipo1" class="@error('tipo1') is-invalid @enderror form-select">
                                @if($modulo == '')
                                    <option value=''>Selecciona un módulo primero</option>
                                @else
                                    <option value=''>Indica el tipo al que pertenece</option>
                                    @foreach($tipos as $t)
                                        <option value='{{ $t->cimg_tipo }}'>{{ $t->cimg_tipo }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="form-text">Define donde aparece el objeto. {{ $tipo1 }}</div>
                            @error('tipo1')<error>{{ $message }}@enderror
                        </div>

                        <!-- tipo2 de imagen -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="tipo2" class="form-label">Sub tipo al que pertenece</label>
                            <input wire:model.live="tipo2" id="tipo2" class="@error('tipo2') is-invalid @enderror form-control" type="text">
                            <div class="form-text">En caso de requerirse.</div>
                            @error('tipo2')<error>{{ $message }}@enderror
                        </div>

                        <!-- titulo -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="titulo" class="form-label">Título del objeto</label>
                            <input wire:model.live="titulo" id="titulo" class="@error('titulo') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Nombre del objeto.</div>
                            @error('titulo')<error>{{ $message }}@enderror
                        </div>

                        <!-- autor -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="autor" class="form-label">Autor del objeto</label>
                            <input wire:model.live="autor" id="autor" class="@error('autor') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Nombre y apellidos del autor</div>
                            @error('autor')<error>{{ $message }}@enderror
                        </div>

                        <!-- fecha -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input wire:model.live="fecha" id="fecha" class="@error('fecha') is-invalid @enderror form-control" type="date">
                            <div class="form-text">En que se generó el objeto.</div>
                            @error('fecha')<error>{{ $message }}@enderror
                        </div>

                        <!-- explicación -->
                        <div class="col-12 form-group">
                            <label for="explica" class="form-label">Explicación</label>
                            <textarea wire:model.live="explica" id="explica" class="@error('explica') is-invalid @enderror form-control" ></textarea>
                            <div class="form-text">Breve texto explicativo de lo que muestra el objeto</div>
                            @error('explica')<error>{{ $message }}@enderror
                        </div>

                        <!-- ubicación -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="ubica" class="form-label">Ubicación del objeto</label>
                            <input wire:model.live="ubica" id="ubica" class="@error('ubica') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Lugar en el que se generó el objeto.</div>
                            @error('ubica')<error>{{ $message }}@enderror
                        </div>

                        <!-- longitud y -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="lat" class="form-label">Longitud (X)</label>
                            <input wire:model.live="lat" id="lat" class="@error('lat') is-invalid @enderror form-control" type="number">
                            <div class="form-text">Latitud en sistema decimal del lugar en que se generó.</div>
                            @error('lat')<error>{{ $message }}@enderror
                        </div>

                        <!-- latitud x -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="lon" class="form-label">Latitud (Y)</label>
                            <input wire:model.live="lon" id="lon" class="@error('lon') is-invalid @enderror form-control" type="number">
                            <div class="form-text">Longitud en sistema decimal del lugar en que se generó.</div>
                            @error('lon')<error>{{ $message }}@enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    @if($ImgId=='0')
                        <button class="btn btn-primary" wire:click="CrearObjeto()">Crear</button>
                    @else
                        <button class="btn btn-primary" wire:click="GuardarObjeto()">Guardar</button>
                    @endif
                    <button wire:click="borrarTodo()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        Livewire.on('abreModalDeImagen',()=>{
            $('#ModalDeImagen').modal('show'); // Abre modal
            const ImgId = event.detail.ImgId; // Envía variable ImgId
            @this.set('ImgId',ImgId, live=true);
            // @this.set('tipo1',ImgTipo, live=true);
            // console.log('va1');
        })
        Livewire.on('cierraModalDeImagen',()=>{
            // console.log('va2');
            $('#ModalDeImagen').modal('hide');
        })

        Livewire.on('alertaBorrado',()=>{
            // console.log('va3');
            alert('Se eliminó el objeto correctamente')
        })

    </script>

</div>
