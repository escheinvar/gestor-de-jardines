@section('title')  @endsection
@section('meta-description') Catálogo bibliográfico del jardín  @endsection
@section('cintillo-ubica') Bibliografía @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>

    <h2>Catálogo bibliográfico</h2>
    <div>
        @if($edit=='1')
            <button wire:click="AbrirModalBibliografia('0')" class="btn btn-primary btn-sm my-4" style="float: right;">
                <i class="bi bi-plus-square"></i> Nuevo registro
            </button>
        @endif
    </div>


    <div class="table-responsive" style="clear: both;">
        @if($biblio->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Autores</th>
                        <th>Año</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($biblio as $b)
                        <tr>
                            <td>{{ $b->bib_id }}</td>

                            <td>
                                <!-- Autores -->
                                {{ $b->bib_autores }}
                            </td>

                            <td>
                                {{ $b->bib_anio }}
                            </td>
                            <td>
                                {{ $b->bib_titulo }}
                            </td>
                            <td>
                                {{ $b->bib_tipo }}
                            </td>
                            <td>
                                <i wire:click="AbrirModalBibliografia('{{ $b->bib_id }}')" class="bi bi-pencil-square PaClick mx-2" ></i>
                                @if($b->bib_pdf != '')
                                    <a href="{{ $b->bib_pdf }}" class="nolink" target="new">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            --- Aún no hay registros bibliográficos en este jardín ---
        @endif
    </div>


    <livewire:coleccion.modal-bibliografia-controller />

</div>
