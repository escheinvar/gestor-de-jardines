@extends('plantillas.base')

@section('title')  @endsection
@section('meta-description') Meta @endsection
<!-- silenciar banner if required -->
@section('banner') banner-3lineas @endsection <!-- banner-1linea banner-2lineas banner-3lineas -->
@section('banner-title') Sistema<br>Gestor<br>de Jardines @endsection
@section('banner-img') imagen1 @endsection <!-- imagen1 a imagen10 -->
<!-- silenciar cintillo-ubica if required -->
{{-- @section('cintillo-ubica') -> {{request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection --}}


<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
<div class="row justify-content-around text-center pb-4">
    <div class="col-sm-12 col-md-10 col-lg-7 col-xl-7 pt-5 px-4">
        <div class="center" style="width:50%;">

            <h2 class="subtitulo">Ingreso al sistema</h2>
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="correo">Correo eletrónico</label>
                    <input name="correo" type="email" value="{{ old('correo') }}" class="form-control" id="correo" placeholder="Ingresa tu correo">
                    @error('correo')<error>{{$message}}</error>@enderror

                </div>

                <div class="form-group form-con-icono">
                    <label for="contrasenia">Contraseña</label>
                    <input name="contrasenia" type="password" class="form-control" id="passfield" placeholder="Ingresa tu contraseña">
                    <i class="bi bi-eye-slash form-icon" id='passicon' onclick="VerNoVerPass('passfield','passicon','bi bi-eye form-icon', 'bi bi-eye-slash form-icon')" style="padding:10px; cursor:pointer;"></i>
                    @error('contrasenia')<error>{{$message}}</error>@enderror
                </div>

                {{-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="sesionActiva" name="dejarActiva" value=TRUE>
                    <label class="form-check-label" for="sesionActiva" style="float: left;"> &nbsp; Dejar sesión activa</label>
                </div> --}}

                <br>
                <div>
                    <error>{!! $mensaje !!}  </error>
                </div>
                <div class="col-sm-12 col-md-auto pb-3">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>


                <div class="my-3">
                    <a class="nolink" href="/recuperaAcceso">Recuperar o cambiar contraseña</a>
                </div>
                <div>
                    <a class="nolink" href="/nuevousr">Crear una cuenta</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
<div>

</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts') @endsection
