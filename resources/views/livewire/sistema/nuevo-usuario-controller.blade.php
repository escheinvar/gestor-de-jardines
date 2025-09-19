
@section('title')  @endsection
@section('meta-description') Meta @endsection
<!-- silenciar cintillo-ubica if required -->
@section('cintillo-ubica') -> Registro de Usuario @endsection
@section('cintillo') &nbsp; @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
<div class="center" style="width:50%;">
    <h2>Crear una nueva cuenta</h2>

    <div class="form-group">
        <label for="correo">Indica tu correo eletrónico:</label>
        <input name="correo" wire:model="correo" type="email" class="form-control" id="correo" placeholder="Ingresa tu correo">
        @error('correo')<error>{{$message}}</error>@enderror
    </div>

    <div class="form-group">
        @if($mensaje=='0')
            <br>
            <div class="alert alert-danger" role="alert">
                Este correo ya se encuentra registrado en esta plataforma
            </div>
        @elseif($mensaje=='1')
            <br>
            <div class="alert alert-success" role="alert">
                Para continuar, revisa la bendeja de tu correo electrónico y sigue las instrucciones.<br><br>
                Verifica el correo no desado ó spam<br><br>
                El correo tiene una vigencia máxima de 20 minutos, pasado este tiempo, deberás solicitar otro correo.
            </div>
            <a href="/ingreso">
                <button type="button" class="btn btn-secondary">Entendido</button>
            </a>

        @elseif($mensaje=='2')
            <br>
            <div class="alert alert-danger" role="alert">
                Este correo ya se encuentra registrado en esta plataforma,
                pero por alguna razón está temporalmente suspendido.
                Comunícate con el administrador del sistema.
            </div>
        @endif
        <br>
        <div class="my-3">
            @if($ver=='1')
                <a href="/ingreso">
                    <button type="button" class="btn btn-secondary">Cancelar</button>
                </a>
                <button wire:click="validador()" wire:loading.attr="disabled" type="submit" class="btn btn-primary mx-3">
                    Registrar
                </button>
                <span wire:loading  style="display:none;color:#CD7B34; ">
                    Espera. Estoy procesando tu solicitud ....
                </span>
            @endif
        </div>
    </div>
</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts') @endsection




