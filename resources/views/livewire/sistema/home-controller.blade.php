
@section('title') Gestor de Jardines @endsection
@section('meta-description') Home del Sistema Gestor de Jardines @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection
{{-- @section('MenuEjemplar') &nbsp; @endsection --}}
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
<div>
    <!-- ------------------------------------------- -->
    <!--  ----- Inicia Caja de usuario y roles ----- -->
    <div class="row">
        <div class="col-sm-12 col-md-2 col-lg-4">
            <h2>Home</h2>
        </div>
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div style="background-color:#CDC6B9;padding:10px; color:#64383E">
                <div style="width:86%;display:inline-block;">
                    <!-- muestra usuario -->
                    <div>
                        <div style="display:inline-block; width:70px; font-weight:bold">Usuario:</div>
                        <div style="display:inline-block;"> {{ Auth::user()->usrname }} ({{ Auth::user()->id }})</span></div>
                        <a href="/config" class="nolink" style="padding:5px;">
                            <i class="bi bi-gear-fill" style="font-size:120%;"></i>
                        </a>
                    </div>
                    <!-- muestra correo -->
                    <div>
                        <div style="display:inline-block; width:70px; font-weight:bold">Correo:</div>
                        <div style="display:inline-block;">  {{ Auth::user()->email  }}</div>
                    </div>
                    <!-- muestra roles -->
                    <div>
                        <div style="display:inline-block; width:70px; font-weight:bold">Rol(es):</div>
                        @foreach (session('jarrol') as $i)
                            {{ $i }}, &nbsp; &nbsp; &nbsp;
                        @endforeach


                    </div>
                </div>
                <div style="width:13%; display:inline-block; vertical-align:top; text-align:right;padding:5px;" class="d-none d-sm-inline-block">
                    @if(Auth::user()->avatar == '')
                        <a href="/config" class="nolink" style="">
                            <img src="/avatar/usr.png" class="avatar" style="display: inline;">

                        </a>
                    @else
                        <a href="/config" class="nolink" style="">
                            <img src="/avatar/{{ Auth::user()->avatar }}" class="avatar">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--  ----- Termina Caja de usuario y roles ----- -->
    <!-- ------------------------------------------- -->


        <div class="my-4" wire:ignore>
            <div wire:model.live="textin" id="summernote">Texto a editar</div>
        </div>
<button id="botoncito" wire:click="cachador()">ver</button>
        va: {{ $textin }}
        <!-- ------------------------------------------------------------------ -->
        <!-- -------------------- Inicia modulo de bitacoras ------------------- -->
        <div class="my-4">
            <input type="text" wire:model.live="MyId" value="0" style="width:200px;">
            <button wire:click="lanzador('{{ $MyId }}','','','','')" class="btn btn-primary">Bitacora</button>
        </div>
        <!-- -------------------- Termina modulo de bitacoras ------------------- -->
        <!-- ------------------------------------------------------------------ -->



        {{-- <!-- ------------------------------------------------------------------ -->
        <!-- ----------------- Inicia modulo de Autoridades ------------------- -->
        <div class="my-4">
            <button wire:click="AbreModalAutoridades('{{ $ID }}')" class="btn btn-primary">Autoridades</button>
            <livewire:coleccion.AutoridadesController />
        </div>
        <!-- ---------------- Termina modulo de Autoridades ------------------- -->
        <!-- ------------------------------------------------------------------ --> --}}


{{--
        <!-- ------------------------------------------------------------------ -->
        <!-- -------------------- Inicia modulo de Imágenes ------------------- -->
        <div class="my-4">
            <input type="number" wire:model.live="ja" value="0" style="width:200px;">
            <button wire:click="prueba('{{ $ImgId }}','','','','')" class="btn btn-primary">@if($ja != '') editar @else crear @endif objeto</button>
            <_?php $imags=$objetos; ?>
            @include('plantillas.imagenes')
        </div>
        <!-- -------------------- Termina modulo de Imágenes ------------------- -->
        <!-- ------------------------------------------------------------------ --> --}}


<span class="error2">blaa</span> a
<script>
    /* --------------- Summernote --------------------------- */
    /* --------------- Summernote --------------------------- */
    /* --------------- Summernote --------------------------- */
    // $(document).ready(function() {
    //     $('#summernote').summernote();
    // });



    /* ----------- Botón linea arriba ---------- */
    var BotonLineaArriba = function (context) {
        var ui = $.summernote.ui;
        // create button
        var button = ui.button({
            contents: '<i class="ar"/> a',
            tooltip: 'Barra arriba',
            click: function () {
            // context.invoke('editor.insertText', 'hello');
            // context.invoke('editor.formatPara'); // Example: formats the current block to a <p>
            // context.invoke('editor.addClass', 'error2');
            var range = context.invoke('editor.createRange');
                if (range.toString()) {
                var highlightedText = '<span class="ar">' + range.toString() + '</span>';
                context.invoke('editor.pasteHTML', highlightedText);
                }
            }
        });
        return button.render(); // return button as jquery object
    }

    /* ----------- Botón linea abajo ---------- */
    var BotonLineaAbajo = function (context) {
        var ui = $.summernote.ui;
        // create button
        var button = ui.button({
            contents: '<i class="ab"/> a',
            tooltip: 'Barra abajo',
            click: function () {
            // context.invoke('editor.insertText', 'hello');
            // context.invoke('editor.formatPara'); // Example: formats the current block to a <p>
            // context.invoke('editor.addClass', 'error2');
            var range = context.invoke('editor.createRange');
                if (range.toString()) {
                var highlightedText = '<span class="ab">' + range.toString() + '</span>';
                context.invoke('editor.pasteHTML', highlightedText);
                }
            }
        });
        return button.render(); // return button as jquery object
    }

    /* ----------- Texto con diagonal ---------- */
    var BotonLineaDiagonal = function (context) {
        var ui = $.summernote.ui;
        // create button
        var button = ui.button({
            contents: '<i class="diag"/> e',
            tooltip: 'Barra diagonal',
            click: function () {
            // context.invoke('editor.insertText', 'hello');
            // context.invoke('editor.formatPara'); // Example: formats the current block to a <p>
            // context.invoke('editor.addClass', 'error2');
            var range = context.invoke('editor.createRange');
                if (range.toString()) {
                var highlightedText = '<span class="diag">' + range.toString() + '</span>';
                context.invoke('editor.pasteHTML', highlightedText);
                }
            }
        });
        return button.render(); // return button as jquery object
    }
    /* ----------- Circulo arriba ---------- */
    var BotonCirculoArriba = function (context) {
        var ui = $.summernote.ui;
        // create button
        var button = ui.button({
            contents: '<i class="diag"/> e',
            tooltip: 'Barra diagonal',
            click: function () {
            // context.invoke('editor.insertText', 'hello');
            // context.invoke('editor.formatPara'); // Example: formats the current block to a <p>
            // context.invoke('editor.addClass', 'error2');
            var range = context.invoke('editor.createRange');
                if (range.toString()) {
                var highlightedText = '<span class="circ">' + range.toString() + '</span>';
                context.invoke('editor.pasteHTML', highlightedText);
                }
            }
        });
        return button.render(); // return button as jquery object
    }

    // $(document).ready(function(){
    document.addEventListener('livewire:init', function () {
        $('#summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                // ['fontsize', ['fontsize']],
                // ['color', ['color']],
                // ['para', ['ul', 'ol', 'paragraph']],
                ['para', ['ul', 'ol']],
                // ['height', ['height']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['group', [ 'specialChar' ]],
                ['mybutton', ['LineaArriba','LineaAbajo','LineaDiagonal','CirculoArriba']]
            ],

            buttons: {
                LineaArriba: BotonLineaArriba,
                LineaAbajo: BotonLineaAbajo,
                LineaDiagonal: BotonLineaDiagonal,
                CirculoArriba: BotonCirculoArriba
            }
        });
    });
</script>

<script>
    $('#botoncito').click(function(){
        var codigo = $('#summernote').summernote('code');
        @this.set('textin',codigo,live=true)
        console.log('va',codigo)
    })

</script>

</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts')
@endsection
