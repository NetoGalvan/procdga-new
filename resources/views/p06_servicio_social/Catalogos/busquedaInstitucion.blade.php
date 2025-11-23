    {{-- <div class="row mb-4 mt-3">
        <div class="col-md-12">
            <div class="text-right">
                <button onclick="location.reload()" type="button" class="btn btn-danger btn-sm"
                    id="verTodosLosCandidatos">Ver todas las instituciones</button>
            </div>
        </div>
    </div> --}}
    <div class="table-responsive">
            <table id="table" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id">
                <thead>
                    <tr>
                        @if (!$instituciones->isEmpty())
                        <th data-field="id" data-visible="false">Id</th>
                        @endif
                        <th data-field="ruta" data-visible="false">Id</th>
                        <th data-field="nombre_institucion" class="text-uppercase"><label class="titulo-dato">Nombre de la institución</label></th>
                        <th data-field="acronimo_institucion"><label class="titulo-dato">Acronimo de la institución</label></th>
                        <th data-field="clave_institucion"><label class="titulo-dato">Clave de la institución</label></th>
                        <th data-formatter="eliminarFormatter"><label class="titulo-dato text-center">Acciones</label></th>
                    </tr>
                </thead>
                <tbody id="tabla1">
                    @if ($instituciones->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center"> No se encontró ninguna coincidencia con la búsqueda. </td>
                        </tr>
                    @endif
                    @foreach ($instituciones as $ins)
                        <tr>

                            @if (!$instituciones->isEmpty())
                            <td>{{$ins->institucion_id }}</td>
                            @endif
                            <td>{{$ins->ruta }}</td>
                            <td>{{$ins->nombre_institucion}}</td>
                            <td>{{$ins->acronimo_institucion}}</td>
                            <td>{{$ins->clave_institucion}}</td>
                            <td class="text-center"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row my-5">
            <div class="col-md-12">
                {!! $instituciones->render() !!}
            </div>
        </div>
