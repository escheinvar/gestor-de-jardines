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
    <div style="font-size: 80%;color:grey;">
        Bitácora: Sección administrada por <b>curador-cientifico</b>
        @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif
        @if($edit_curcient=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif <br>
        <b>admin-colviva</b> puede administrar nombres de campo, pero desde bitácora

    </div>

    <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------- INICIA DATOS GENERALES DEL EJEMPLAR ------------------------------- -->
    {{-- usa variables $idEjem con id del ejemplar desde URL y $ejemplar --}}
    <div class="row my-3" style="">
        <div class="col-sm-5 col-md-4" style="vertical-align: top;">
            <div style="font-size: 150%;">
                @if($idEjem=='0')
                    <b>Nuevo ejemplar</b> @else <b>ID de ejemplar</b>: {{ $idEjem }}
                @endif
                @if($idEjem >'0')
                    <div class="@if($ejemplar->ejm_bitid =='0') error2 @endif">
                            @if($ejemplar->ejm_bitid=='0') Bitácora pendiente
                            @else <b>ID de bitácora</b>:  {{ $ejemplar->ejm_bitid }}
                            @endif
                    </div>
                @endif
            </div>
        </div>
        @if($idEjem >'0')
            <div class="col-sm-5 col-md-4">
                <b>Nombre científico</b>:
                    @if(is_null($ejemplar_ScName))<span class="error2"> --Sin definir--</span>
                    @else {{ $ejemplar_ScName->scn_name }} ({{ $ejemplar_ScName->scn_edo }})
                    @endif<br>
                <b>Nombre común</b>: -- ({{ $ejemplar->ejm_edo_name }})<br>
                <b>Campus</b>:  {{ $ejemplar->ejm_ccamsiglas}}
                <b>Ubicación</b>: -- ({{ $ejemplar->ejm_edo_ubica }})<br>
            </div>
            <div class="col-sm-5 col-md-4">
                <b>Dueño de bitacora</b>:
                    @if($ejemplar->bit_ejmid_prop == $idEjem )  Este ejemplar
                    @else  @if($ejemplar->bit_ejmid_prop > '0') <a href="/ejem_bitacora/{{ $ejemplar->bit_ejmid_prop }}">Ejm. ID {{ $ejemplar->bit_ejmid_prop }}</a> @else -- @endif
                    @endif <br>
                <b>ID de Madre</b>: @if($ejemplar->ejm_madreid != '') <a href="/ejem_bitacora/{{ $ejemplar->ejm_madreid }}"> Ejm. {{ $ejemplar->ejm_madreid }} </a> @endif <br>
                <b>ID de Padre</b>: @if($ejemplar->ejm_padreid != '') <a href="/ejem_bitacora/{{ $ejemplar->ejm_padreid }}">Ejm. {{ $ejemplar->ejm_padreid }} </a> @endif <br>
                <b>ID de Lote</b>: @if($ejemplar->ejm_loteid != '') <a href="/lote/{{ $ejemplar->ejem_loteid }}">Ejm. {{ $ejemplar->ejm_loteid }} </a> @endif <br>
            </div>
        @endif
    </div>
    <!-- -------------------- TERMINA DATOS GENERALES DEL EJEMPLAR ------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->




    <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- SECCIÓN DE NOMBRE CIENTÍFICO -------------------------------- -->
    <div>
        <hr class="titulo">
        <a name="nombre científico">
            <H3>Nombre científico</H3>
        </a>
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
                <div class="col-12 my-4">
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
                <div class="col-12 my-4">
                    @if($edit_curcient==TRUE)
                        <button wire:click="BorraNombre('{{ $nomcien->scn_id }}')" wire:confirm="Esto eliminará definitivamente el nombre científico y lo podrás remplazar por uno nuevo ¿deseas continuar? " class="btn btn-primary">
                            <i class="bi bi-trash"></i> Borrar/cambiar nombre
                        </button>
                    @endif
                </div>
            </div>
        <!-- ----------- Cuando NO hay nombre científico, lo muestra ------------------------ -->
        @elseif($HayNomCien=='0')
            <div class="row">
                <div class="col-12 my-3">
                    -- Este ejemplar aún no ha sido identificado -->
                </div>
                @if($edit_curcient=='1')
                    <div class="col-sm-12 col-md-4 form-group">
                        <button wire:click="abreModalDeNombreCientifico()" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Asignar nombre científico
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>



     <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- SECCIÓN DE NOMBRE CIENTÍFICO -------------------------------- -->
    <div>
        <hr class="titulo">
        <a name="nombres comunes">
            <H3>Nombres comunes</H3>
        </a>
    </div>




    <livewire:coleccion.modal-asigna-especie-controller />
</div>
