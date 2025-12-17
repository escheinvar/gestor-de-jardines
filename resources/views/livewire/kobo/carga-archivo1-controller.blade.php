@section('title') Importa Kobo @endsection
@section('meta-description') Carga de archivo de KoboCollect @endsection
@section('cintillo-ubica') Kobo -> Carga @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>
    <h2>Carga de archivo de KoboCollect</h2>

    <div class="row">
        <div class="col-12">
            <li><a href="#" target="new">Descargar</a> plantilla para Kobo</li>
            <li>Manual para cargar plantilla en Kobo</li>
            <li>Manual para capturar datos de campo</li>
            <li>Manual para generar archivo xls desde Kobo</li>
            <li>Manual para descargar las imágenes desde Kobo</li>
        </div>
    </div>

    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <div class="row">

        <!-- Xls de koboCollect -->
        <div class="col-12 col-md-4 form-group">
            <label for="excel" class="form-label">Cargar nuevo archivo xls de Kobo</label>
            <input wire:model="excel" id="excel" class="@error('excel') is-invalid @enderror form-control" type="file" accept=".xlsx">
            <div class="form-text">Carga el archivo excel de salida de kobo</div>
            @error('excel')<error>{{ $message }}</error>@enderror
        </div>
        @if($excel != '')
            <!-- Campus -->
            <div class="col-12 col-md-3 form-group">
                <label for="campus" class="form-label">Campus propietario de ejemplares:</label>
                <select wire:model.live="campus" id="campus" class="@error('campus') is-invalid @enderror form-select"  type="text">
                    <option value="">Indica el Campus propietario </option>
                    @foreach ($campuses as $c)
                        <option value="{{ $c->ccam_siglas }}">[{{ $c->ccam_siglas }}] {{ $c->ccam_name }}</option>
                    @endforeach
                </select>
                <div class="form-text">Indica el campus al que pertenecen los ejemplares</div>
                @error('campus')<error>{{ $message }}</error>@enderror
            </div>

            <div class="col-12 col-md-3 form-group">
                <label for="token" class="form-label">Token de Kobo</label>
                <input wire:model="token" id="token" class="@error('token') is-invalid @enderror form-control" type="password">
                <div class="form-text">Escribe el token secreto de Kobo-Collect</div>
                @error('token')<error>{{ $message }}</error>@enderror
            </div>

            <div class="col-12 col-md-2 form-group">
                <label class="form-label"></label><br>
                @if($excel != '' and $campus != '')
                    <button wire:click="Cargarfile()" wire:loading.attr="disabled" class="btn btn-primary">Cargar</button>
                    <span wire:model="ErrorCarga"></span>
                    @error('ErrorCarga')<error>{{ $message }}</error>@enderror
                @endif
            </div>
        @endif
    </div>

    @if($ejemplares->count() > 0)
        <div class="table-responsive">
            <div>
                {{ $ejemplares->count() }} registros | &nbsp;
                <i class="bi bi-exclamation-octagon-fill" style="color:red;"><sub></sub> Sin dato o con error</i>
                <div style="width:20px;background-color:black;display:inline-block;"> &nbsp; </div> Sin dato
                <div style="width:20px;background-color:gray;display:inline-block;"> &nbsp; </div> Con dato

            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id<br>Campus</th>
                        <th>Autor<br>Fecha</th>
                        <th>Camellón<red>*</red></th>
                        <th>Ubicación<red>*</red></th>
                        <th>Conteos</th>
                        <th>Ejemplar<red>*</red></th>
                        <th>Nombres</th>
                        <th>Fotos</th>
                        <th></th>
                </thead>
                <tbody>
                    @foreach ($ejemplares as $e)
                        <?php $errores='0'; ?>
                        <tr>
                            <!-- Id y campus -->
                            <td style="font-size:80%;">
                                <a href="/koboView/{{ $e->kobo2_id }}">
                                    {{ $e->kobo2_id }}<br>
                                    {{ $e->kobo2_ccamsiglas }}
                                </a>
                            </td>

                            <!-- autor y fecha -->
                            <td style="font-size:80%;">
                                {{ $e->kobo2_username }}<br>
                                {{ $e->kobo2_date }}
                            </td>

                            <!-- camellón -->
                            <td>
                                {{ $e->kobo2_camellon }}
                                @if($camellones->where('ccam_siglas',$e->kobo2_ccamsiglas)->where('cam_camellon',$e->kobo2_camellon)->count() =='1')
                                    <i class="bi bi-check-lg" style="color:gray;"></i>
                                @else
                                    <?php $errores++; ?>
                                    <i class="bi bi-exclamation-octagon-fill" style="color:red;"></i>
                                @endif
                            </td>

                            <!-- ubicación: foto, x, y -->
                            <td>
                                <!-- foto de ubicación -->
                                <div style="display:inline-block;">
                                    @if($e->kobo2_fotoubica != '')
                                        <a href="{{ $e->kobo2_fotoubica}}" class="nolink" target="new">
                                            <i class="bi bi-file-earmark-image-fill" style="color:gray;"><sub>img</sub></i>
                                        </a>
                                    @else
                                        <?php $errores++; ?>
                                        <i class="bi bi-exclamation-octagon-fill" style="color:red;"><sub>img</sub></i>
                                    @endif
                                    <br>

                                    <!-- Valida coordenadas dentro de México -->
                                    @if( $e->kobo2_y >= '14.540833'   AND   $e->kobo2_y <= '32.718333'  AND $e->kobo2_x >= '-118.456667' AND $e->kobo2x <='-86.71')
                                        <i class="bi bi-check-lg" style="color:gray;"><sub>x,y</sub></i>
                                    @else
                                        <?php $errores++; ?>
                                        <i class="bi bi-exclamation-octagon-fill" style="color:red;"><sub>x,y</sub></i>
                                    @endif
                                </div>

                                <!-- nombre y notas de ubicación-->
                                <div style="display:inline-block;">
                                    <!-- nombre de cuadrante -->
                                    <i class="bi bi-tag-fill" style="@if($e->kobo2_nombrecuadr != '')color:gray; @else color:black; @endif">
                                        <sub>@if($e->kobo2_nombrecuadr != '') {{ $e->kobo2_nombrecuadr }}@else Nombre @endif</sub>
                                    </i>

                                    <br>
                                    <!-- notas de ubiacación-->
                                    <i class="bi bi-journal-text" style="@if($e->kobo2_notasubica != '')color:gray; @else color:black; @endif">
                                        <sub>Notas</sub>
                                    </i>
                                </div>
                            </td>


                            <!-- conteos -->
                            <td>
                                @if($e->kobo2_numinds >= '0')
                                    <i class="bi bi-check-lg" style="color:gray;"><sub>Inds</sub></i>
                                @else
                                    <?php $errores++; ?>
                                    <i class="bi bi-exclamation-octagon-fill" style="color:red;"><sub>Inds</sub></i>
                                @endif
                                <br>

                                @if($e->kobo2_numext >='0')
                                    <i class="bi bi-check-lg" style="color:gray;"><sub>Ext</sub></i>
                                @else
                                    <?php $errores++; ?>
                                    <i class="bi bi-exclamation-octagon-fill" style="color:red;"><sub>Ext.</sub></i>
                                @endif
                            </td>

                            <!-- nombre ejemplar y clavo, img de ejemplar e img extra-->
                            <td>
                                <!-- Etiqueta nombre -->
                                <div style="display:block;">
                                    <i class="bi bi-tag-fill" style="@if($e->kobo2_nombreejemplar != '')color:gray; @else color:black; @endif">
                                    </i>
                                    @if( $e->kobo2_nombreejemplar != '' )<span style="color:gray";>{{ $e->kobo2_nombreejemplar }} </span>@endif
                                </div>


                                <div>
                                    <!-- foto de ejemplar -->
                                    @if($e->kobo2_fotoejemplar != '')
                                        <a href="{{ $e->kobo2_fotoejemplar}}" class="nolink" target="new">
                                            <i class="bi bi-file-earmark-image-fill" style="color:gray;"><sub>img</sub></i>
                                        </a>
                                    @else
                                        <?php $errores++; ?>
                                        <i class="bi bi-exclamation-octagon-fill" style="color:red;"><sub>img</sub></i>
                                    @endif

                                    <!-- foto 2 de ejemplar -->
                                    @if($e->kobo2_fotoejemplar2 != '')
                                        <a href="{{ $e->kobo2_fotoejemplar2}}" class="nolink" target="new">
                                            <i class="bi bi-file-earmark-image-fill" style="color:gray;"><sub>img2</sub></i>
                                        </a>
                                    @else
                                        <i class="bi bi-file-earmark-image-fill" style="color:black;"><sub>img2</sub></i>
                                    @endif
                                </div>

                                <div>
                                    <i class="bi bi-tag-fill" style="@if($e->kobo2_clavo != '')color:gray; @else color:black; @endif">
                                        <sub>Clavo {{ $e->kobo2_clavo }}</sub>
                                    </i>
                                </div>
                            </td>



                            <td>
                                <!-- nombre científico-->
                                <div>
                                    @if($e->kobo2_nombrecient != '')
                                        <i class="bi bi-tag-fill" style="color:gray;"><sub><i>{{ $e->kobo2_nombrecient }}</i></sub></i>
                                    @else
                                        <i class="bi bi-tag-fill" style="color:black;"><sub>Nom. cient.</sub></i>
                                    @endif
                                </div>
                                <br>

                                <!-- nombre común -->
                                <div>
                                    @if($e->kobo2_nombrecom != '')
                                        <i class="bi bi-tag-fill" style="color:gray;"><sub>{{ $e->kobo2_nombrecom }}</sub></i>
                                    @else
                                        <i class="bi bi-tag-fill" style="color:black;"><sub>Nom. cient.</sub></i>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <!-- imagen -->
                                <a href="{{ $e->kobo2_fotoflor }}" target="new">
                                    <i class="bi bi-file-earmark-image-fill" style="@if($e->kobo2_fotoflor != '')color:gray; @else color:black; @endif"><sub>Repro</sub></i>
                                </a>

                                <!-- imagen -->
                                <a href="{{ $e->kobo2_fotohoja }}" target="new">
                                    <i class="bi bi-file-earmark-image-fill" style="@if($e->kobo2_fotohoja != '')color:gray; @else color:black; @endif"><sub>Hoja</sub></i>
                                </a>

                                <!-- imagen -->
                                <a href="{{ $e->kobo2_fotofrutos }}" target="new">
                                    <i class="bi bi-file-earmark-image-fill" style="@if($e->kobo2_fotofrutos != '')color:gray; @else color:black; @endif"><sub>Fruto</sub></i>
                                </a>
                            </td>
                            <td>
                                @if($errores > '0')
                                    <i class="bi bi-exclamation-octagon-fill" style="color:red;"><sub>{{ $errores }}</sub></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
    @endif



    <div class="row">
        @if($ejemplares->count() > '0')
            <div class="col-2">
                <button wire:click="BorrarTabla()" wire:confirm="Estás por borrar completamente esta tabla y perder todos los datos ¿Seguro quieres continuar?" class="btn btn-secondary btn-sm">Eliminar toda la tabla</button>
            </div>
        @endif
    </div>


    <script>
        Livewire.on('AvisoExitoKobo',()=>{
            alert(event.detail.msj);
            //  console.log(event.detail.msj);
        })
    </script>
</div>
