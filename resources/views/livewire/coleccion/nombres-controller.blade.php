@section('title')  @endsection
@section('meta-description') Datos de la bitácora de colecta de los ejemplares @endsection
@section('cintillo-ubica') -> <a href="/ejemplares" class="nolink">Ejemplares</a> @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>
    @include('plantillas.MenuDeEjemplar')
    <!-- -------------------- TERMINA DATOS GENERALES DEL EJEMPLAR ------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- aviso de privilegios -->
    <div style="font-size: 80%;color:grey;">
        Nombres: Sección administrada por <b>curador-cientifico</b>
        @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif
        @if($edit_curcient=='0') <error style="font-size: 90%;"> (No autorizado)</error> @else <span style="font-size:90%;color:green;"> (Autorizado) </span>@endif <br>
        <b>admin-colviva</b> puede administrar nombres de campo, pero desde bitácora
    </div>


    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- SECCIÓN DE NOMBRE CIENTÍFICO -------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <div>
        <hr class="titulo">
        <a name="nombre científico">
            <H3>Nombre científico</H3>
        </a>
        <!-- aviso de privilegios -->
        <div style="font-size: 80%;color:grey;">
            Nombres: Sección administrada por <b>curador-cientifico</b>
            @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif
            @if($edit_curcient=='0') <error style="font-size: 90%;"> (No autorizado)</error> @else <span style="font-size:90%;color:green;"> (Autorizado) </span>@endif <br>
            <b>admin-colviva</b> puede administrar nombres de campo, pero desde bitácora
        </div>

        <!-- ----------- Cuando sí hay nombre científico, lo muestra ------------------------ -->
        @if($HayNomCien =='1')
            <div class="row">
                <div class="col-12">
                    <!--  reino -->
                    <span style="font-size: 150%;font-weight:bold;">
                        @if($nomcien->scn_reino=='pl') Plantae,
                        @elseif( $nomcien->sch_reino=='an') Animalia,
                        @elseif( $nomcien->sch_reino=='ho') Fungi,
                        @elseif( $nomcien->sch_reino=='pr') Protista,
                        @elseif( $nomcien->sch_reino=='ar') Archaea,
                        @elseif( $nomcien->sch_reino=='ba') Bacteria,
                        @endif

                        <!-- familia -->
                        {{ $nomcien->scn_familia }}:
                        <!-- género, especie y subespecífica -->
                        <i><u> {{ $nomcien->scn_genero }}</u> &nbsp; <u>{{ $nomcien->scn_sp }}</u> &nbsp; <u>{{ $nomcien->scn_ssp }}</i></u>
                    </span>
                </div>
                <div class="col-sm-12 col-md-9 my-4">
                    <!-- Estado de madurez del nombre -->
                    @if($nomcien->scn_edo=='0') <i class="bi bi-0-circle" style="color:red;"> Sin validar</i>
                    @elseif($nomcien->scn_edo=='1')<i class="bi bi-1-circle" style="color:orange;">Validado por Técnico</i>
                    @elseif($nomcien->scn_edo=='2')<i class="bi bi-2-circle" style="color:green;">Validado por Autoridad Taxonómica</i>
                    @endif
                    <br>

                    <!-- nombre de quien valida -->
                    Determinado por {{ $nomcien->aut_nombre }} {{ $nomcien->aut_ap1 }} {{ $nomcien->aut_ap2 }}
                    (id {{ $nomcien->scn_colid }}, {{ $nomcien->aut_tipo }})<br>
                    {{ $nomcien->aut_inst }}<br>
                    {{ $nomcien->aut_tema}}<br>
                    <!-- fecha en la que valida -->
                    Fecha de determinación: {{ $nomcien->scn_fecha_determina }}
                </div>
                <!-- borrar nombre: solo admin-cientifico ó admin-colviva(pero cuando edo=0) -->
                <div class="col-sm-12 col-md-3">
                    @if($edit_curcient=='1')
                        <button wire:click="BorraNombre('{{ $nomcien->scn_id }}')" wire:confirm="Esto eliminará definitivamente el nombre científico y lo podrás remplazar por uno nuevo ¿deseas continuar? " class="btn btn-primary btn-sm" style="float: right;">
                            <i class="bi bi-trash"></i>Eliminar nombre
                        </button>
                    @endif
                </div>
            </div>
        <!-- ----------- Cuando NO hay nombre científico, lo muestra ------------------------ -->
        @elseif($HayNomCien=='0')
            <div class="row" style="clear:both;">
                <div class="col-12 my-3">
                    -- Este ejemplar aún no ha sido identificado -->
                </div>
                @if($edit_curcient=='1')
                    <div class="col-sm-12 col-md-12 form-group">
                        <button wire:click="abreModalDeNombreCientifico()" class="btn btn-primary btn-sm" style="float: right;">
                            <i class="bi bi-plus-circle"></i> Asignar nombre científico
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>




    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- SECCIÓN DE NOMBRES COMUNES -------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <div>
        <hr class="titulo">
        <a name="nombres_comunes">
            <H3>Nombres comunes</H3>
            <!-- aviso de privilegios -->
            <div style="font-size: 80%;color:grey;">
                Nombres comunes: Sección administrada por <b>curador-cientifico</b>
                @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif
                @if($edit_curcient=='0') <error style="font-size: 90%;"> (No autorizado)</error> @else <span style="font-size:90%;color:green;"> (Autorizado) </span>@endif
                <br>y por <b>admin-colviva</b>
                @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif
                @if($edit_adcolviva=='0') <error style="font-size: 90%;"> (No autorizado; </error> @else <span style="font-size:90%;color:green;"> (Autorizado; </span>@endif
                solo nombres sin cita o nombres de origen)
            </div>

            @if($nomcoms->count() > 0)
                <div class="table-responsive my-3" style="clear:both;">
                    <table class="table table-striped">
                        <thead>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Lengua</th>
                            <th>Regiones</th>
                            <th>Citas</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($nomcoms as $n)
                                <tr>
                                    <!-- nombre de origen o no -->
                                    <td>
                                        @if($n->con_origen=='1')
                                            <i class="bi bi-2-circle-fill" style="color:#CD7B34;"></i>
                                        @elseif($n->con_origen=='0' and $n->con_bibid > '0')
                                            <i class="bi bi-1-circle-fill" style="color:#919C1B;"></i>
                                        @elseif($n->con_origen=='0' and $n->con_bibid == '' )
                                            <i class="bi bi-0-circle-fill" style="color:#87796d;"></i>
                                        @endif
                                        <small><sub>{{ $n->con_id }}</sub></small>
                                        @if($n->con_act=='0')
                                            <error><i class="bi bi-eye-slash"></i></error>
                                        @endif
                                    </td>

                                    <!-- Texto del nombre -->
                                    <td>
                                        @if($n->con_act=='0')<error> @endif
                                        {{ $n->con_nombre }}</error>
                                    </td>

                                    <!-- lengua -->
                                    <td>
                                        @if($n->con_act=='0')<error> @endif
                                        {{ $n->clen_lengua }}
                                        ({{ $n->con_clencode }})</error>
                                    </td>

                                    <!-- región -->
                                    <td>
                                        <small>
                                            @if($n->con_act=='0')<error> @endif
                                            {{ preg_replace('/;/',";  ",$n->con_ubica) }}</error>
                                        </small>
                                    </td>

                                    <!-- bibliografía -->
                                    <td>
                                        @if($n->con_bibid > '0')
                                            <span wire:click="AbrirModalBibliografia('{{ $n->bib_id }}')" class="PaClick">
                                                @if($n->bib_tipo == 'comunicación personal')
                                                    <i>Com. pers.</i>
                                                @else
                                                    {{ $n->bib_autores }},
                                                    {{ $n->bib_anio }}
                                                @endif
                                            </span>
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>
                                        <!-- archivos: file1-->
                                        @if($n->con_file1 != '')
                                            <a href="{{ $n->con_file1 }}" target="new" class="nolink">
                                                <!-- audio -->
                                                @if(preg_match('/mp3$|ogg$|acc$|wma$|wav$|flac$|pcm$/i', $n->con_file1)) <i class="bi bi-volume-up-fill"></i>
                                                <!-- video -->
                                                @elseif(preg_match('/mp4$|mov$|avi$|wmv$|webm$|mkv$|mpeg$/i', $n->con_file1)) <i class="bi bi-camera-reels-fill"></i>
                                                <!-- imágen -->
                                                @elseif(preg_match('/jpeg$|jpg$|jfif$|png$|pict$|pct$/i', $n->con_file1)) <i class="bi bi-file-image-fill"></i>
                                                <!-- pdf -->
                                                @elseif(preg_match('/pdf$/i', $n->con_file1))<i class="bi bi-file-earmark-pdf"></i>
                                                <!-- archivo -->
                                                @else <i class="bi bi-file-earmark"></i>
                                                @endif
                                            </a>
                                        @endif
                                        <!-- archivos: file2-->
                                        @if($n->con_file2 != '')
                                            <a href="{{ $n->con_file2 }}" target="new" class="nolink">
                                                <!-- audio -->
                                                @if(preg_match('/mp3$|ogg$|acc$|wma$|wav$|flac$|pcm$/i', $n->con_file2)) <i class="bi bi-volume-up-fill"></i>
                                                <!-- video -->
                                                @elseif(preg_match('/mp4$|mov$|avi$|wmv$|webm$|mkv$|mpeg$/i', $n->con_file2)) <i class="bi bi-camera-reels-fill"></i>
                                                <!-- imágen -->
                                                @elseif(preg_match('/jpeg$|jpg$|jfif$|png$|pict$|pct$/i', $n->con_file2)) <i class="bi bi-file-image-fill"></i>
                                                <!-- pdf -->
                                                @elseif(preg_match('/pdf$/i', $n->con_file2))<i class="bi bi-file-earmark-pdf"></i>
                                                <!-- archivo -->
                                                @else <i class="bi bi-file-earmark"></i>
                                                @endif
                                            </a>
                                        @endif
                                        <!-- archivos: file3-->
                                        @if($n->con_file3 != '')
                                            <a href="{{ $n->con_file3 }}" target="new" class="nolink">
                                                <!-- audio -->
                                                @if(preg_match('/mp3$|ogg$|acc$|wma$|wav$|flac$|pcm$/i', $n->con_file3)) <i class="bi bi-volume-up-fill"></i>
                                                <!-- video -->
                                                @elseif(preg_match('/mp4$|mov$|avi$|wmv$|webm$|mkv$|mpeg$/i', $n->con_file3)) <i class="bi bi-camera-reels-fill"></i>
                                                <!-- imágen -->
                                                @elseif(preg_match('/jpeg$|jpg$|jfif$|png$|pict$|pct$/i', $n->con_file3)) <i class="bi bi-file-image-fill"></i>
                                                <!-- pdf -->
                                                @elseif(preg_match('/pdf$/i', $n->con_file3))<i class="bi bi-file-earmark-pdf"></i>
                                                <!-- archivo -->
                                                @else <i class="bi bi-file-earmark"></i>
                                                @endif
                                            </a>
                                        @endif

                                        <!-- archivos: file4-->
                                        @if($n->con_file4 != '')
                                            <a href="{{ $n->con_file4 }}" target="new" class="nolink">
                                                <!-- audio -->
                                                @if(preg_match('/mp3$|ogg$|acc$|wma$|wav$|flac$|pcm$/i', $n->con_file4)) <i class="bi bi-volume-up-fill"></i>
                                                <!-- video -->
                                                @elseif(preg_match('/mp4$|mov$|avi$|wmv$|webm$|mkv$|mpeg$/i', $n->con_file4)) <i class="bi bi-camera-reels-fill"></i>
                                                <!-- imágen -->
                                                @elseif(preg_match('/jpeg$|jpg$|jfif$|png$|pict$|pct$/i', $n->con_file4)) <i class="bi bi-file-image-fill"></i>
                                                <!-- pdf -->
                                                @elseif(preg_match('/pdf$/i', $n->con_file4))<i class="bi bi-file-earmark-pdf"></i>
                                                <!-- archivo -->
                                                @else <i class="bi bi-file-earmark"></i>
                                                @endif
                                            </a>
                                        @endif
                                    </td>

                                    <td>
                                        <!-- botón para editar -->
                                        @if($edit_curcient=='1' OR ($edit_adcolviva=='1' AND ($n->con_bibid == '' OR $n->con_origen=='1') ))
                                            <i wire:click="AbrirModalNombreComun('{{ $idEjem }}','{{ $n->con_id }}')" class="bi bi-pencil-square PaClick"></i>
                                        @endif
                                        <!-- AVISO DE INACTIVIDAD -->
                                        @if($n->con_act=='0')
                                            <error><i class="bi bi-eye-slash"></i></error>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div style="font-size: 70%;">
                        <i class="bi bi-2-circle-fill mx-2" style="color:#CD7B34;"> Nombre de localidad origen</i>
                        <i class="bi bi-1-circle-fill mx-2" style="color:#919C1B;"> Respaldado por bibliografía</i>
                        <i class="bi bi-0-circle-fill mx-2" style="color:#87796d;"> Sin respaldo bibliográfico</i>
                    </div>
                </div>
            @else
                -- aún no se registra nombre común --
            @endif
        </a>
        <div class="py-3">
            @if($edit_curcient=='1' OR $edit_adcolviva=='1')
                <button wire:click="AbrirModalNombreComun('{{ $idEjem }}','0')" class="btn btn-primary btn-sm" style="float: right;">
                    <i class="bi bi-plus-square"></i> Agregar nombre</button><br>
            @endif
        </div>
    </div>



    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- SECCIÓN DE ALIAS -------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <div>
        <hr class="titulo">
        <a name="alias">
            <H3>Otros nombres del ejemplar</H3>
        </a>
        <div class="row">
            <div class="col-12">
                @if($alias->count() =='0')
                    -- No se ha registrado ningún alias para este ejemplar --
                @else
                    <ul>
                        @foreach ($alias as $a)
                            <li>{{ $a->alias_nombre }}
                                <button wire:click="BorrarAlias({{ $a->alias_id }})" wire:confirm="Vas a eliminar este alias permanentemente. ¿deseas continuar?" class="btn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-4 form-group">
                <label for="nuevoAlias" class="form-label">Nuevo alias del ejemplar:</label>
                <input wire:model="nuevoAlias" type="text" id="nuevoAlias" class="@error('nuevoAlias') is-invalid @enderror form-control">
                <div class="form-text">Indica todas las etiquetas, clavos y nombres que ha tenido este ejemplar</div>
                @error('nuevoAlias')<error>{{ $message }}</error>@enderror
            </div>
            <div class="col-sm-12 col-md-4 form-group">
                <label class="form-label"> &nbsp; </label><br>
                <button wire:click="AgregaAlias()" class="btn btn-primary btn-sm"> <i class="bi bi-plus-square"></i> Agregar alias</button>
            </div>
        </div>
    </div>


    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- SECCIÓN DE HERBARIO -------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <div>
        <hr class="titulo">
        <a name="herbario">
            <H3>Herbario</H3>
        </a>
        <?php $imags=$herbario; ?>


        <div>
            <button wire:click="AbreModalObjeto('0','herbario','','ej','{{ $idEjem }}')" class="btn btn-primary btn-sm" style="float: right;"><i class="bi bi-plus-square"></i> Agregar imagen de herbario</button>
        </div>
        <div style="clear: both;">
            @include('plantillas.imagenes')
        </div>
    </div>


    <livewire:coleccion.modal-asigna-especie-controller />
    <livewire:coleccion.modal-bibliografia-controller />
    <livewire:coleccion.modal-nombres-comunes-controller />
</div>



