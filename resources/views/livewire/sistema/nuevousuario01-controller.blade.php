@section('title')  @endsection
@section('meta-description') Meta @endsection
<!-- silenciar cintillo-ubica if required -->
@section('cintillo-ubica') -> Registro de Usuario @endsection
@section('cintillo') &nbsp; @endsection

<div>
    <h2>Crear una nueva cuenta</h2>
    @if($correo->count()=='0')
        <div class="alert alert-warning" role="alert">
            La liga no es correcta o ya caducó.
        </div>
        <a href="/nuevousr">
            <button type="button" class="btn btn-primary">
                Solicitar otra
            </button>
        </a>
         <a href="/ingreso">
            <button type="button" class="btn btn-secondary mx-4">
                Cancelar
            </button>
        </a>
    @else
        <div class="container text-center">
            <div class="row">
                <div class="col-12 form-group my-4">
                    <h3> {{ $correo[0]  }}</h3>
                    <input name="correo" type="hidden" wire:model="correo" class="form-control @error('correo') error @enderror" disabled>
                    @error('correo') <error> {{$message}}</error> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4 form-group py-2">
                    <label for="nombre" class="form-label">Nombre(s) <red>*</red></label>
                    <input name="nombre" type="text" wire:model="nombre" class="form-control @error('nombre') error @enderror">
                    <div class="form-text">Indica todos tus nombres</div>
                    @error('nombre') <error> {{$message}}</error> @enderror
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4 form-group py-2">
                    <label for="apellido" class="form-label">Apellido(s) <red>*</red></label>
                    <input name="apellido" type="text" wire:model="apellido" class="form-control @error('apellido') error @enderror">
                    <div class="form-text">Indica tu(s) apellido(s)</div>
                    @error('apellido') <error> {{$message}}</error> @enderror
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4 form-group py-2">
                    <label for="usrname" class="form-label">Nombre de usuario <red>*</red></label>
                    <input name="usrname" type="text" wire:model="usrname" class="form-control @error('usrname') error @enderror">
                    <div class="form-text">Indica tu nombre público (no debe haber sido elegido por otro usuario)</div>
                    @error('usrname') <error> {{$message}}</error> @enderror
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4 form-group py-2">
                    <label for="nace" class="form-label">Fecha de nacimiento</label>
                    <input name="nace" type="date" wire:model.live="nace" max="{{date('Y-m-d')}}" class="form-control @error('nace') error @enderror">
                    <div class="form-text">Indica la fecha en la que naciste</div>
                    @error('nace') <error> {{$message}}</error> @enderror
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4 form-group py-2">
                    <label for="contrasenia" class="form-label">Contraseña <red>*</red></label>
                    <input name="contrasenia" type="password" wire:model="contrasenia" class="form-control @error('contrasenia') error @enderror">
                    <div class="form-text">Indica la contraseña con la que vas a ingresar al sistema</div>
                    @error('contrasenia') <error> {{$message}}</error> @enderror
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4 form-group py-2">
                    <label for="contrasenia2" class="form-label">Repite contraseña <red>*</red></label>
                    <input name="contrasenia2" type="password" wire:model="contrasenia2" class="form-control @error('contrasenia2') error @enderror">
                    <div class="form-text">Repite la contraseña para confirmar</div>
                    @error('contrasenia2') <error> {{$message}}</error> @enderror
                </div>
            </div>

            <div class="row">
                @if($finalizado =='0')
                    <div class="col-12 my-3">
                        <br>
                        <button wire:click="enviar" wire:loadding.attr="disabled" type="submit" class="btn btn-primary" @if($correo->count()=='0') disabled @endif>Crear cuenta</button>
                        <a href="/ingreso">
                            <button type="button" class="btn btn-secondary mx-4">Cancelar</button>
                        </a>
                        <div wire:loading  style="display:none;">
                            <error>Espera. Estoy realizando el registro</error>
                        </div>
                    </div>
                @elseif($finalizado=='1')
                    <div class="alert alert-success my-4" role="alert">
                        La cuenta fue creada correctamente<br>
                    </div>
                    <a href="/ingreso">
                        <button type="button" class="btn btn-primary mx-4">Ingresar</button>
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>
