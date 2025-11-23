    <div class="table-responsive">
        <table id="table" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id">
            <thead>
                <th data-field="id" data-visible="false"></th>
                <th data-field="identificador_escuela" data-visible="false"></th>
                {{-- <th data-field="ruta" data-visible="false"></th> --}}
                <th data-field="nombre_escuela"><label for="" class="titulo-dato">Nombre de la escuela</label></th>
                <th data-field="acronimo_escuela"><label for="" class="titulo-dato">Acronimo de la escuela</label></th>
                <th data-field="direccion_escuela"><label for="" class="titulo-dato">Dirección de la escuela</label></th>
                <th style="width:150px !important;" data-field="programa_registrado"><label for="" class="titulo-dato text-wrap">Programa Registrado</label></th>
                <th data-formatter="eliminarFormatter"><label class="titulo-dato text-center">Acciones</label></th>
            </thead>
            @foreach ($escuelas as $esc)
                <tr>
                    <td>{{$esc->escuela_id }}</td>
                    <td>{{$esc->identificador_escuela }}</td>
                    {{-- <td>{{$escuela->ruta }}</td> --}}
                    <td><span class="valor-dato-tabla-td">{{$esc->nombre_escuela}}</td></span>
                    <td><span class="valor-dato-tabla-td">{{$esc->acronimo_escuela}}</td></span>
                    <td><span class="valor-dato-tabla-td">{{$esc->direccion_escuela}}</td></span>

                    <?php
                        $totalProgramas = 0;
                    ?>
                    <td class="text-center">
                        <button type="button" onclick="abrirModalProgramas({{$esc->identificador_escuela}})" class="btn btn-success btn-sm">
                            <i class="fas fa-list-ul"></i>Programas</button>
                    </td>
                    <td class="text-center"></td>
                </tr>
                @endforeach
        </table>
    </div>
    <div class="row my-5">
        <div class="col-md-12">
            {!! $escuelas->render() !!}
        </div>
    </div>
