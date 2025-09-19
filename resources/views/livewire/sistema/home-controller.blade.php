
@section('title') Gestor de Jardines @endsection
@section('meta-description') Home del Sistema Gestor de Jardines @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection
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
                    <div>
                        <div style="display:inline-block; width:70px; font-weight:bold">Usuario:</div>
                        <div style="display:inline-block;"> {{ Auth::user()->usrname }} ({{ Auth::user()->id }})</span></div>
                        <a href="/config" class="nolink" style="padding:5px;">
                            <i class="bi bi-gear-fill" style="font-size:120%;"></i>
                        </a>
                    </div>
                    <div>
                        <div style="display:inline-block; width:70px; font-weight:bold">Correo:</div>
                        <div style="display:inline-block;">  {{ Auth::user()->email  }}</div>
                    </div>
                    <div>
                        <div style="display:inline-block; width:70px; font-weight:bold">Rol(es):</div>
                        <div style="display:inline-block;">  {{ implode(', ',session('jarrol'))  }}</div>
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
</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts')
@endsection
