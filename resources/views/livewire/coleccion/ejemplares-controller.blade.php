@section('title')  @endsection
@section('meta-description') Datos de la bitácora de colecta de los ejemplares @endsection
@section('cintillo-ubica') -> <a href="/ejem_ejemplares" class="nolink">Ejemplares</a> @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>
    <h2>Ejemplares</h2>
    <!-- ------------------------------------------------------------------------- -->
    <!-- ----------------------- CAMPOS DE BÚSQUEDA------------------------------- -->
    <div class="row py-3">

        <!-- Campus -->
        <div class="col-sm-12 col-md-4 form-group">
            <label for="" class="form-label">Campus</label>
            <select wire:model="" id="" class="@error('') is-invalid @enderror form-select" type="text">
                <option value="">Indica un campus   </option>
            </select>
            <div class="form-text"></div>
            @error('')<error>{{ $message }}</error>@enderror
        </div>
        <!-- -->
        <div class="col-sm-12 col-md-4 form-group">
            <label for="" class="form-label">Camellón</label>
            <select wire:model="" id="" class="@error('') is-invalid @enderror form-select">
                <option value=""></option>
            </select>
            <div class="form-text"></div>
            @error('')<error>{{ $message }}</error>@enderror
        </div>

        {{--
        <!-- -->
        <div class="col-sm-12 col-md-4 form-group">
            <label for="" class="form-label"></label>
            <input wire:model="" id="" class="@error('') is-invalid @enderror form-control" type="text">
            <div class="form-text"></div>
            @error('')<error>{{ $message }}</error>@enderror
        </div>
        <!-- -->
        <div class="col-sm-12 col-md-4 form-group">
            <label for="" class="form-label"></label>
            <select wire:model="" id="" class="@error('') is-invalid @enderror form-select">
                <option value=""></option>
            </select>
            <div class="form-text"></div>
            @error('')<error>{{ $message }}</error>@enderror
        </div>
        --}}

        <div class="col-2">
            @if($edit=='1')
                <a href="/ejem_bitacora/0">
                    <label class="form-lagel">&nbsp;</label><br>
                    <button type="buton" class="btn btn ">
                        @if($edit=='1')
                            <i class="bi bi-plus-square-fill agregar" style=""> Nuevo ejemplar</i>
                        @endif
                    </button>
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- ------------------------------------------------------------------------- -->
        <!-- ----------------------- BÚSQUEDA EN MAPA -------------------------------- -->
        <div class="col-sm-12 col-md-6">
        </div>

        <!-- ------------------------------------------------------------------------- -->
        <!-- --------------------------- TABLA --------------------------------------- -->
        <div class="col-sm-12 col-md-6">
            @if(count($ejemplares) == 0)
                -- No hay ejemplares -->
            @endif
            <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead>
                </thead>
                <tbody>
                    @foreach ($ejemplares as $e)
                        <tr>
                            <td>
                                {{ $e->ejm_ccamsiglas }}
                            </td>
                            <td>
                                <a href="/ejem_bitacora/{{ $e->ejm_id }}">
                                    ID {{ $e->ejm_id }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

        </div>
    </div>

</div>
