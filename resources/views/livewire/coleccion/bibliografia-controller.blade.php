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

    <button wire:click="AbrirModalBibliografia('0')" class="btn my-4" >
        <i class="bi bi-plus-square"></i> Nuevo registro
    </button>

    <div class="table-responsive">
        @if($biblio->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><Id/th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($biblio as $b)
                        <tr>
                            <td>{{ $b->$bib_id }}</td>
                            <td></td>
                            <td></td>
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
