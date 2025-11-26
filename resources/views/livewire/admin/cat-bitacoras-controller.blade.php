{{-- @extends('plantillas.base') --}}

@section('title') Bitácoras  @endsection
@section('meta-description') Catálogo de bitácoras del Sistema Gestor de Jardines @endsection
<!-- silenciar cintillo-ubica if required -->
@section('cintillo-ubica') -> Catálogo de Bitácoras @endsection
@section('cintillo') &nbsp; @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
{{-- @section('main-Nolivewire')@endsection --}}
<div>
    <h2>Catálogo de Bitácoras</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol <b>curador-cientifico</b> (y al campus sobre el que tenga privilegio)
        <br>OJO: falta ver si es necesario incorporar a admin-jardin, admin-colviva y curador-colviva (y a los campus sobre los que tengan privilegio)
        {{-- @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif --}}
    </div>

    <div class="row py-3">
        <div class="col-sm-12 col-md-4">
            Buscar
        </div>
        <div class="col-sm-12 col-md-4">
            <a href="/bitacora/0">
                <button class="btn btn-primary">Agregar</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">

                @if($bitacoras->count() > 0)
                    <table class="table table-striped table-sm">
                        <thead>
                            <th> ID bitacora</th>
                            <th> ID ejem. propietario</th>
                            <th> Nombre</th>
                            <th> Fecha colecta</th>
                            <th> Tipo de origen</th>
                            <th> Etiqueta de origen</th>
                            <th> Ubicación </th>
                            <th> &nbsp; </th>
                        </thead>
                        <tbody>
                            @foreach ($bitacoras as $b)
                                <tr>
                                    <td>{{ $b->bit_id }}</td>
                                    <td><a href="/bitacora/{{ $b->bit_ejmid_prop }}">{{ $b->bit_ejmid_prop }}</a></td>
                                    <td> - </td>
                                    <td>{{ $b->bit_colectadate }}</td>
                                    <td>{{ $b->bit_origen }}</td>
                                    <td>{{ $b->bit_etiqueta_colecta }}</td>
                                    <td> {{ $b->bit_edo }}, {{ $b->bit_mpio }} ({{ $b->bit_localidad }})</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    -- aún no hay especies registradas --
                @endif
            </div>
        </div>
    </div>
</div>
