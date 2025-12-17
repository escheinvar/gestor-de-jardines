@section('title')  @endsection
@section('meta-description') Datos de expediente de los ejemplares @endsection
@section('cintillo-ubica') -> <a href="/ejem_ejemplares" class="nolink">Expediente</a> @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>
    @include('plantillas.MenuDeEjemplar')
    <!-- aviso de privilegios -->
    <div style="font-size: 80%;color:grey;">
        Expediente: Sección administrada por....
        {{-- <b>admin-colviva</b>
        @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif
        @if($edit_adcolviva=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif <br> --}}
    </div>
    <!-- -------------------- TERMINA DATOS GENERALES DEL EJEMPLAR ------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <h2>Expediente</h2>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expedientes as $e)
                        <tr>
                            <td>{{ $e->exp_fecha }}</td>
                            <td>{{ $e->exp_cexpname }}</td>
                            <td>{{ $e->exp_txt }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
