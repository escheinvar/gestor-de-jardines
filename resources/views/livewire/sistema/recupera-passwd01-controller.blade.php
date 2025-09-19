@section('title') Recupera contraseña @endsection
@section('meta-description') Recuperar contraseña de Sistema Gestor de Jardines @endsection
@section('cintillo-ubica') -> Recuperar contraseña @endsection
@section('cintillo') &nbsp; @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
<div>

    @if($caso=='0')
        <div class="alert alert-warning" role="alert">
            Este vínculo no existe o ya venció.
        </div>
        <div>
            <a href="/ingreso"><button type="button" class="btn btn-secondary mx-4">Cancelar</button></a>
            <a href="/recuperaAcceso"><button type="button" class="btn btn-primary">Solicitar nuevo vínculo</button></a>
        </div>
    @else
        <div class="center" style="width:50%;">
            <H2>Cambiar contraseña</h2>
            <div class="form-group">
                <label>Ingresa tu nueva contraseña:</label>
                <input wire:model="contrasenia" type="password" class="@error('contrasenia') error @enderror form-control" placeholder="Ingresa la nueva contraseña">
                @error('contrasenia')<error>{{$message}}</error> @enderror
            </div>

            <div class="form-group">
                <label>Repite tu nueva contraseña:</label>
                <input wire:model="contraseniaConfirmacion"type="password" class="@error('contraseniaConfirmacion') error @enderror form-control" placeholder="Repetir contraseña">
                @error('contraseniaConfirmacion')<error>{{$message}}</error> @enderror
            </div>

            <div class="form-group">
                @if($mensaje=='')
                    <br>
                    <button wire:click="Cambiar()" wire:loading.attr="disabled" type="submit" class="btn btn-primary">Cambiar</button>
                    <a href="/ingreso"><button type="button" class="btn btn-secondary mx-4">Cancelar</button></a>
                    <br>
                @elseif($mensaje=='1')

                    <div class="alert alert-success m-4" role="alert">
                        La contraseña fue cambiada
                    </div>
                    <div>
                        <a href="/ingreso">
                            <button type="button" class="btn btn-primary">
                                Finalizar
                            </button>
                        </a>
                    </div>
                @elseif($mensaje=='2')
                    <div class="alert alert-danger" role="alert">
                        El vínculo venció antes de poder cambiar la contraseña. <br>
                        Intenta nuevamente. <a href="/recuperaAcceso"><button type="button" class="btn btn-secondary">Solicitar uno nuevo</button></a>
                    </div>
                @else
                @endif
            </div>

        </div>
    @endif

</div>
