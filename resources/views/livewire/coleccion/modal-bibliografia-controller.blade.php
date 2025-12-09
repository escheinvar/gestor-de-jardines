<div>
    <!-- ------------------------------------------------------------------------------------- -->
    <!---------------------- INICIA MODAL DE BIBLIOGRAFÍA ------------------------------------- -->
    {{-- ----   requiere en view:
        -----   <livewire:coleccion.ModalBibliografiaControlles>
        -----   <wire:click="AbrirModalBibliografia(bibId)">
        -----
        -----   y en controller:
        -----   public function AbrirModalBibliografia($par1){
        -----       $data=['bibId'=>$par1];  ### donde $par1 tiene el Id del registro bibliográfico a editar ó 0 para nuevo
        -----       $this->dispatch('abreModalDeBibliogfafia',$data);
        -----   }
    --}}

    <div wire:ignore.self class="modal fade" id="ModalDeBibliografia" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    <h5 class="modal-title">
                        @if($bibId == '0')
                            Ingresando Nuevo Registro Bibliográfico
                        @else
                            Editando Registro Bibliográfico {{ $bibId }}
                        @endif
                    </h5>
                    <button wire:click="cerrarModal()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- -------------------- Jardin ------------------------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="bibmodal_campus" class="form-label">Jardín propietario del registro<red>*</red></label>
                            <select wire:model.live="bibmodal_campus" id="bibmodal_campus" class="@error('bibmodal_campus') is-invalid @enderror form-select" @if($bimodal_edit=='0') disabled @endif>
                                <option value="">Indica un campus</option>
                                @foreach ($bimodal_campuses as $t)
                                    <option value="{{ $t->campus }}"> {{ $t->campus }} </option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('bibmodal_campus')<error>{{ $message }}@enderror
                        </div>

                        <!-- -------------------- Tipo de registro ------------------------- -->
                        <div class="col-sm-12 col-md-4 form-group">
                            <label for="bibmodal_tipo" class="form-label">Tipo de registro bibliográfico<red>*</red></label>
                            <select wire:model.live="bibmodal_tipo" id="bibmodal_tipo" class="@error('bibmodal_tipo') is-invalid @enderror form-select" @if($bimodal_edit=='0') disabled @endif>
                                <option value="">Indica un tipo de registro</option>
                                @foreach ($bibmodal_tipos as $t)
                                    <option value="{{ $t->con_txt }}"> {{ $t->con_txt }} </option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('bibmodal_tipo')<error>{{ $message }}@enderror
                        </div>
                    </div>
                    @if($bimodal_edit=='1')
                        <div class="row">
                            <div class="col-sm-0 col-md-1"></div>
                            <!-- --------- Orcid del autor --------- -->
                            <div class="col-sm-10 col-md-4  form-group">
                                <label for="bibmodal_orcid" class="form-label">ORCID ID del nuevo autor</label>
                                <input wire:model="bibmodal_orcid" id="bibmodal_orcid" type="text" class="@error('bibmodal_orcid') is-invalid @enderror form-control">
                                <div class="form-text">Clave ORCID del autor</div>
                                @error('bibmodal_orcid')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- --------- ISNI del autor --------- -->
                            <div class="col-sm-10 col-md-4  form-group">
                                <label for="bibmodal_isni" class="form-label">ISNI del nuevo autor</label>
                                <input wire:model="bibmodal_isni" id="bibmodal_isni" type="text" class="@error('bibmodal_isni') is-invalid @enderror form-control">
                                <div class="form-text">Clave ORCID del autor</div>
                                @error('bibmodal_isni')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- -------------------- Tipo de autor/editor ------------------------- -->
                            <div class="col-sm-10 col-md-3 form-group">
                                <label for="bibmodal_tipoAutor" class="form-label">Tipo </label>
                                <select wire:model="bibmodal_tipoAutor" id="bibmodal_tipoAutor" class="@error('bibmodal_tipoAutor') is-invalid @enderror form-select" @if($bibmodal_tipo!='capítulo de libro') disabled @endif>
                                    <option value="autor">Autor</option>
                                    <option value="editor">Editor</option>
                                </select>
                                <div class="form-text"></div>
                                @error('bibmodal_tipoAutor')<error>{{ $message }}@enderror
                            </div>
                        </div>
                        <div class="row">
                            <!-- --------- Nombre del autor --------- -->
                            <div class="col-sm-0 col-md-1"></div>
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_nombre" class="form-label">Nombre(s) del nuevo autor:<red>*</red></label>
                                <input wire:model="bibmodal_nombre" id="bibmodal_nombre" type="text" class="@error('bibmodal_nombre') is-invalid @enderror form-control">
                                <div class="form-text">Nombre del autor</div>
                                @error('bibmodal_nombre')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- --------- Apellido(s) del autor --------- -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_ap" class="form-label">Apellido(s) del nuevo autor:<red>*</red></label>
                                <input wire:model="bibmodal_ap" id="bibmodal_ap" type="text" class="@error('bibmodal_ap') is-invalid @enderror form-control">
                                <div class="form-text">Apellido(s) o apellido combinado del autor.</div>
                                @error('bibmodal_ap')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- -------------------- Botón agregar ------------------------- -->
                            <div class="col-sm-1 col-md-2 form-group">
                                <button wire:click="AgregarAutor" class="btn btn-primary my-4">
                                    <i class="bi bi-plus-square"></i> Agregar
                                </button>
                            </div>
                            {{-- <div class="col-sm-0 col-md-1"></div> --}}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12 form-group">
                            <!-- ------------------ Lista de autores ----------------------- -->
                            <label class="form-label">Autores<red>*</red>:</label>
                            @if(count($bibmodal_autores)>'0')
                                <div class="row">
                                    @foreach ($bibmodal_autores as $a)
                                        <div class="col-sm-6 col-md-3">
                                            <input type="text" value="{{$a['bibaut_ap'] }} {{  $a['bibaut_nombre'] }}" readonly class="form-control @if($bibId > '0')agregar @endif">
                                            @if($bibId > '0' and $bimodal_edit=='1')
                                                <i wire:click="BorrarAutor('{{ $a['bibaut_id'] }}')" class="bi bi-trash agregar" wire:confirm="Vas a eliminar a este autor de esta cita. ¿Seguro que quieres continuar?"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <!-- ------------------ Lista de editores ----------------------- -->
                            @if($bibmodal_tipo=='capítulo de libro')
                                <br>
                                <label class="form-label">Editor(es) del libro<red>*</red>:</label>
                                <div class="row">
                                    @foreach ($bibmodal_editores as $a)
                                        <div class="col-sm-6 col-md-3">
                                            <input type="text" value="{{$a['bibaut_ap'] }} {{  $a['bibaut_nombre'] }}" readonly class="form-control">
                                            @if($bibId > '0' and $bimodal_edit=='1')
                                                <i wire:click="BorrarAutor('{{ $a['bibaut_id'] }}')" class="bi bi-trash agregar" wire:confirm="Vas a eliminar a este autor de esta cita. ¿Seguro que quieres continuar?"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <!-- --------- Año --------- -->
                        @if($bibmodal_tipo != '')
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_anio" class="form-label">Año<red>*</red></label>
                                <input wire:model="bibmodal_anio" id="bibmodal_anio" type="number" class="@error('bibmodal_anio') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_anio')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- Titulo de Artículo/Capitulo/Tesis--------- -->
                        @if(in_array($bibmodal_tipo,['artículo','capítulo de libro','tesis']))
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_titulo" class="form-label">Título de {{ $bibmodal_tipo }} <red>*</red> </label>
                                <input wire:model="bibmodal_titulo" id="bibmodal_titulo" type="text" class="@error('bibmodal_titulo') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_titulo')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- Nombre de Revista/Libro/ --------- -->
                        @if(in_array($bibmodal_tipo,['artículo','libro','capítulo de libro']))
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_nombrePub" class="form-label">Nombre
                                    @if($bibmodal_tipo=='artículo') de la revista
                                    @else del libro
                                    @endif<red>*</red>
                                </label>
                                <input wire:model="bibmodal_nombrePub" id="bibmodal_nombrePub" type="text" class="@error('bibmodal_nombrePub') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_nombrePub')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif
                        <!-- --------- Número de la revista--------- -->
                        @if(in_array($bibmodal_tipo,['artículo']))
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_RevNum" class="form-label">Número de la revista<red>*</red></label>
                                <input wire:model="bibmodal_RevNum" id="bibmodal_RevNum" type="text" class="@error('bibmodal_RevNum') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_RevNum')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- --------- Volumen de la revista --------- -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_RevVol" class="form-label">Volumen de la revista</label>
                                <input wire:model="bibmodal_RevVol" id="bibmodal_RevVol" type="text" class="@error('bibmodal_RevVol') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_RevVol')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- Tipo de tesis --------- -->
                        @if($bibmodal_tipo == 'tesis')
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_tipoTesis" class="form-label">Tipo de tesis (nivel y área)<red>*</red></label>
                                <input wire:model="bibmodal_tipoTesis" id="bibmodal_tipoTesis" type="text" class="@error('bibmodal_tipoTesis') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_tipoTesis')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- Página(s) de la publicación --------- -->
                        @if($bibmodal_tipo != '' AND $bibmodal_tipo != 'comunicación personal')
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_pags" class="form-label">Página(s)<red>*</red></label>
                                <input wire:model="bibmodal_pags" id="bibmodal_pags" type="text" class="@error('bibmodal_pags') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_pags')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- Editorial/Institución --------- -->
                        @if(in_array($bibmodal_tipo,['libro','capítulo de libro','tesis']))
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_editorial" class="form-label">@if($bibmodal_tipo=='tesis')Institución @else Editorial @endif<red>*</red></label>
                                <input wire:model="bibmodal_editorial" id="bibmodal_editorial" type="text" class="@error('bibmodal_editorial') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_editorial')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- Idioma --------- -->
                        @if($bibmodal_tipo != '')
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_lengua" class="form-label">Idioma<red>*</red></label>
                                <select wire:model="bibmodal_lengua" id="bibmodal_lengua" type="text" class="@error('bibmodal_lengua') is-invalid @enderror form-select">
                                    <option value="">Indica la lengua</option>
                                    <option value="spa">Español</option>
                                    <option value="eng">Inglés</option>
                                    @foreach ($bibmodal_lenguas as $l)
                                        <option value="{{ $l->clen_code }}">{{ $l->clen_lengua }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text"></div>
                                @error('bibmodal_lengua')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- DOI --------- -->
                        @if($bibmodal_tipo != '' AND $bibmodal_tipo != 'comunicación personal')
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_doi" class="form-label">DOI</label>
                                <input wire:model="bibmodal_doi" id="bibmodal_doi" type="text" class="@error('bibmodal_doi') is-invalid @enderror form-control">
                                <div class="form-text">Registro único de publicación en web</div>
                                @error('bibmodal_doi')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- ISBN --------- -->
                        @if(in_array($bibmodal_tipo,['libro','capítulo de libro','tesis']))
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_isbn" class="form-label">ISBN</label>
                                <input wire:model="bibmodal_isbn" id="bibmodal_isbn" type="text" class="@error('bibmodal_isbn') is-invalid @enderror form-control">
                                <div class="form-text">Registro ISBN de la publicación </div>
                                @error('bibmodal_isbn')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- ISSN --------- -->
                        @if(in_array($bibmodal_tipo,['artículo']))
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_issn" class="form-label">ISSN</label>
                                <input wire:model="bibmodal_issn" id="bibmodal_issn" type="text" class="@error('bibmodal_issn') is-invalid @enderror form-control">
                                <div class="form-text">Registro ISSN de la publicación periódica</div>
                                @error('bibmodal_issn')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- Ocupación --------- -->
                        @if($bibmodal_tipo == 'comunicación personal')
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_ocupa" class="form-label">Ocupación</label>
                                <input wire:model="bibmodal_ocupa" id="bibmodal_ocupa" type="text" class="@error('bibmodal_ocupa') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_ocupa')<error>{{ $message }}</error>@enderror
                            </div>


                            <!-- --------- Edad --------- -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_edad" class="form-label">Edad</label>
                                <input wire:model="bibmodal_edad" id="bibmodal_edad" type="number" class="@error('bibmodal_edad') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_edad')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- --------- Estado --------- -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_Edo" class="form-label">Estado</label>
                                <select wire:model.live="bibmodal_Edo" id="bibmodal_Edo" type="text" class="@error('bibmodal_Edo') is-invalid @enderror form-select">
                                    <option value="">Indica el Estado </option>
                                    @foreach($bimodal_estados as $e)
                                        <option value="{{ $e->cedo_nombre }}">{{ $e->cedo_nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text"></div>
                                @error('bibmodal_Edo')<error>{{ $message }}</error>@enderror
                            </div>


                            <!-- --------- Municipio --------- -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_mpio" class="form-label">Municipio</label>
                                 <select wire:model.live="bibmodal_mpio" id="bibmodal_mpio" type="text" class="@error('bibmodal_mpio') is-invalid @enderror form-select">
                                    @if($bimodal_municipios->count() > 0)
                                        <option value="">Indica el Municipio </option>
                                        @foreach($bimodal_municipios as $e)
                                            <option value="{{ $e->cmun_mpioname }}">{{ $e->cmun_mpioname }}</option>
                                        @endforeach
                                    @else
                                        <option value="">Indica primero un Estado</option>
                                    @endif
                                </select>
                                <div class="form-text"></div>
                                @error('')<error>{{ $message }}</error>@enderror
                            </div>


                            <!-- --------- Localidad --------- -->
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_localidad" class="form-label">Localidad</label>
                                <input wire:model="bibmodal_localidad" id="bibmodal_localidad" type="text" class="@error('bibmodal_localidad') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_localidad')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- URL --------- -->
                        @if($bibmodal_tipo != '')
                            <div class="col-sm-12 col-md-4 form-group">
                                <label for="bibmodal_url" class="form-label">URL</label>
                                <input wire:model="bibmodal_url" id="bibmodal_url" type="text" class="@error('bibmodal_url') is-invalid @enderror form-control">
                                <div class="form-text">Dirección de ubicación en internet</div>
                                @error('bibmodal_url')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- Palabras clave --------- -->
                        {{-- <hr class="my-2"> --}}
                        @if($bibmodal_tipo != '')
                            <div class="col-12 form-group">
                                <label for="bibmodal_tags" class="form-label">Palabras clave</label>
                                <input wire:model="bibmodal_tags" id="bibmodal_tags" type="text" class="@error('bibmodal_tags') is-invalid @enderror form-control">
                                <div class="form-text">Indica las palabras clave o tags separados por punto y coma</div>
                                @error('bibmodal_tags')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- Notas sobre la publicación /informante--------- -->
                        @if($bibmodal_tipo != '')
                            <div class="col-6 form-group">
                                <label for="bibmodal_notasPub" class="form-label">@if($bibmodal_tipo=='comunicación personal') Notas sobre el informante y el informado @else Notas de la publicación @endif</label>
                                <textarea wire:model="bibmodal_notasPub" id="bibmodal_notasPub" type="text" class="@error('bibmodal_notasPub') is-invalid @enderror form-control"></textarea>
                                <div class="form-text"></div>
                                @error('bibmodal_notasPub')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif


                        <!-- --------- Notas sobre la ubicación --------- -->
                        @if($bibmodal_tipo != '')
                            <div class="col-6 form-group">
                                <label for="bibmodal_notasUbica" class="form-label">@if($bibmodal_tipo=='comunicación personal') Notas sobre la ubicación del informante @else Notas de la ubicación de la publicación @endif</label>
                                <textarea wire:model="bibmodal_notasUbica" id="bibmodal_notasUbica" type="file" class="@error('bibmodal_notasUbica') is-invalid @enderror form-control"></textarea>
                                <div class="form-text"></div>
                                @error('bibmodal_notasUbica')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        <!-- --------- subir Archivo --------- -->
                        @if($bibmodal_tipo != '' and $bibmodal_pdf == '')
                            <div class="col-8 form-group">
                                <label for="bibmodal_archivo" class="form-label">Archivo</label>
                                <input wire:model="bibmodal_archivo" id="bibmodal_archivo" type="file" class="@error('bibmodal_archivo') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('bibmodal_archivo')<error>{{ $message }}</error>@enderror
                            </div>
                        @elseif($bibmodal_tipo != '' and $bibmodal_pdf != '')
                        <div class="col-8 form-group">
                            <label for="bibmodal_archivo" class="form-label">Archivo</label><br>
                            <a href="{{ $bibmodal_pdf }}" target="new">
                                {{ $bibmodal_pdf }}
                            </a>
                            @if($bimodal_edit=='1')
                                <i wire:click="BorrarArchivo()" class="bi bi-trash PaClick" wire:confirm="Vas a eliminar permanentemente el archivo. ¿Deseas continuar?"></i>
                            @endif
                        </div>
                        @endif

                        <!-- --------- Privacidad --------- -->
                        @if($bibmodal_tipo != '')
                            <div class="col-2 form-group">
                                <label for="bibmodal_priv" class="form-label">Privacidad</label>
                                <select wire:model="bibmodal_priv" id="bibmodal_priv" type="text" class="@error('bibmodal_priv') is-invalid @enderror form-select">
                                    <option value="0">Público</option>
                                    <option value="1">Restringido</option>
                                </select>
                                <div class="form-text"></div>
                                @error('bibmodal_priv')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif
                    </div>

                </div>

                <div class="modal-footer">
                    @if($bimodal_edit=='1')
                        @if($bibId=='0')
                            <button class="btn btn-primary" wire:click="CrearRegistro('crear')" >Crear registros</button>
                        @else
                            <button class="btn btn-primary" wire:click="CrearRegistro('editar')">Guardar cambios</button>
                        @endif
                    @endif
                        <button wire:click="cerrarModal()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


        <script>
            Livewire.on('abreModalDeBibliogfafia',()=>{
                $('#ModalDeBibliografia').modal('show'); // Abre modal
                // console.log('va1');

            })
            Livewire.on('cierraModalDeBibliogfafia',()=>{
                $('#ModalDeBibliografia').modal('hide');
                if(event.detail.reload == '1'){
                    window.location.reload();
                }
            })
            Livewire.on('AvisoExitoBiblio',()=>{
                alert(event.detail.msj);
                // console.log(event.detail.msj);
            })

        </script>


    <!---------------------- TERMINA MODAL DE NUEVA ESPECIE --------------------------------------- -->
    <!-- --------------------------------------------------------------------------------------- -->
</div>
