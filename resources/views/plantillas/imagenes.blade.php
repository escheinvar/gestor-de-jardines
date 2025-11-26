<!-- ------------------------------------------------------------------------------
    Esta plantilla es invocada desde imagen-controller, módulo de imágenes
    que requiere única y exclusivamente una variable denominada $imags
    que contenga el listado de imágenes que se quiere mostrar y que
    fue obtenido desde el controlador con <b>imagenes::get()</b>.<br>
    En el view, donde vas a mostrar imágenes pon:

    < ?php $imags=$objeto; ? >
    @ include('plantillas.imagenes')

    --------------------
    Esta plantilla, además de recibir el listado y mostrar los objetos de $imgags,
    tiene la posiblidad de editar cada una de los objetos, para lo cual, requiere que el
    controlador, incluya la función "AbrirModalObjeto", para lo cual cópiala ypégala
    tal cual en el controlador:

    public function AbreModalObjeto($par1,$par2, $par3, $par4, $par5){
        $data=['ImgId'=>$par1, 'ImgModulo'=>$par2, 'ImgTipo'=>$par3, 'Clase'=>$par4, 'IdClase'=>$par5];
        $this->dispatch('abreModalDeImagen', $data);
        ######   $data[
        ######         'ImgId',      (img_id de tabla imagenes) para editar ó 0 para nuevo
        ######         'ImgModulo',  (cimg_modulo de tabla cat_tipoimgs)
        ######         'ImgTipo',    (cimg_tipo de tabla cat_tipoimgs)
        ######         'Clase',      [ej,es] indica si es para ejemplar o para especie
        ######         'IdClase',    (img_ejmid ó img_spid de tabla imagenes)
    }
------------------------------------------------------------------------------ -->
@if(isset($imags))
    @foreach ($imags as $o)
        <imagen style="max-width:250px;">
            <!-- TITULO -->
            <titulo class="truncarTexto" onclick="Destruncar('titulo','{{ $o->img_id }}')" id="titulo_{{ $o->img_id }}">
                @if($o->img_act=='0') <error><i class="bi bi-eye-slash"></i></error>@endif
                {{ $o->img_titulo }}
            </titulo>
            <div class="imagen">
                <fecha style="">{{ $o->img_fecha }}</fecha>
                <!-- OBJETO IMAGEN -->
                @if($o->img_media=='img')
                    <img style="width:100%" src="{{ $o->img_ruta }}">

                <!-- OBJETO AUDIO -->
                @elseif($o->img_media=='aud')
                    <audio style="width:100%;" controls>
                        <source src="{{ $o->img_ruta }}" type="audio/ogg">
                        <source src="{{ $o->img_ruta }}" type="audio/mpeg">
                        Tu navegador no soporta archivos de audio
                    </audio>
                <!-- OBJETO VIDEO -->
                @elseif($o->img_media=='vid')
                    <video style="width:100%; max-height:200px;" controls>
                        <source src="{{ $o->img_ruta }}" type="video/mp4">
                        <source src="{{ $o->img_ruta }}" type="video/ogg">
                        Tu navegador no soporta el video.
                    </video>
                @endif
                <!-- AUTOR -->
                <autor>
                    {{ $o->img_autor }}
                </autor>
            </div>
            <!-- EXPLICACIÓN -->
            <explica class="truncarTexto" id="explica_{{ $o->img_id }}">
                <span onclick="Destruncar('explica','{{ $o->img_id }}')">
                    {{ $o->img_explica }}
                </span>
                <i onclick="VerNoVer('metadatos','{{ $o->img_id }}')" style="color:#CDC6B9;font-weight:600;" class="bi bi-arrow-down-right-square m-3"></i>
                <!-- METADATOS -->
                <div style="display:none" id="sale_metadatos{{ $o->img_id }}" class="my-2">

                    Id de objeto: <b>{{ $o->img_id }}</b></br>
                    Id de ejemplar: {{ $o->img_ejmid }}<br>
                    Tipo: {{ $o->img_cimgtipo }}<br>
                    Tipo2:{{ $o->img_tipo2 }}<br>
                    Ubicación: {{ $o->img_ubica }}<br>
                    Latitud Y: {{ $o->img_y }}<br>
                    Longitud X: {{ $o->img_x }}<br>
                    Media: {{ $o->img_media }}<br>
                    Url: <a href="{{ $o->img_ruta }}" target="new" class=" mx-2"> {{ $o->img_ruta }}</a><br>
                    <!-- --------------------- BOTÓN PARA EDITAR LA IMAGEN --------------------- -->
                    <!-- --------------------- BOTÓN PARA EDITAR LA IMAGEN --------------------- -->
                    @if(in_array('admin-campus',session('rol')))
                        <div class="my-3 PaClick">
                            <i class="bi bi-pencil-square" wire:click="AbreModalObjeto('{{ $o->img_id }}','','','','')"> Editar</i>
                        </div>
                    @endif
                </div>
            </explica>
        </imagen>
    @endforeach
@else
    <div class="alert alert-danger" role="alert">
        El módulo de imágenes requiere una variable denominada $imags
        que contenga el listado de imágenes <b>imagenes::get()</b><br>
        Puedes enviarla al módulo escribiendo <b>&lt;?php $imags= $MiObjeto; ?&gt;</b>
        antes de invocar este módulo.
    </div>
@endif


<livewire:coleccion.ModalImagenController  />



<script>
    function Destruncar($tipo,$id){
        var obj = document.getElementById($tipo + '_' + $id);
        if (obj.classList.contains('truncarTexto')) {
            // console.log('está truncado');
            obj.classList.remove("truncarTexto");
        }else{
            // console.log('no lo está');
            obj.classList.add("truncarTexto");
        }
    }
</script>

