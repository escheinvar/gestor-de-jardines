@section('title') Recupera contraseña @endsection
@section('meta-description') Recuperar contraseña de Sistema Gestor de Jardines @endsection
@section('cintillo-ubica') -> Recuperar contraseña @endsection
@section('cintillo') &nbsp; @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
<div>

    <div class="center" style="width:50%;">
        <h2>Recuperar o cambiar contraseña</h2>
        <div class="form-group">
            <label for="correo">Indica tu correo eletrónico:</label>
            <input name="correo" wire:model="correo" type="email" class="form-control" id="correo" placeholder="Ingresa tu correo">
            @error('correo')<error>{{$message}}</error>@enderror
        </div>

        <div class="form-group">

            @if($mensaje=='0')
                <br>
                <div class="alert alert-danger" role="alert">
                    Este correo no está registrado en esta plataforma
                </div>
            @elseif($mensaje=='1')
                <br>
                <div class="alert alert-success" role="alert">
                    Las instrucciones para continuar se enviaron al correo electrónico que indicaste.<br>
                    El correo tiene una vigencia máxima de 20 minutos.
                </div>
            @elseif($mensaje=='2')
                <br>
                <div class="alert alert-danger" role="alert">
                    Este correo se encuentra temporalmente suspendido, por favor comunícate con el administrador.
                </div>
            @endif
            <br>
            @if($ver=='1')
                <a href="/ingreso"><button type="submit" class="btn btn-secondary">Cancelar</button></a>
                <button wire:click="validador" wire:loading.attr="disabled" type="submit" class="btn btn-primary mx-3">Enviar</button>
                <span wire:loading style="display: none; color:#CD7B34;" > Procesando solicitud, favor de esperar ....</span>
            @else
                <a href="/ingreso"><button type="submit" class="btn btn-secondary">Terminar</button></a>
            @endif
        </div>
    </div>
    <br>
</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts') @endsection



