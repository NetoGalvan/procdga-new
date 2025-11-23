<div class="table-responsive">
    <table id="table" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id">
        <thead>
            <th data-field="id" data-visible="false">Id</th>
            <th width="5%"><label for="" class="titulo-dato">Tipo</label></th>
            <th width="15%"><label for="" class="titulo-dato">Nombre</label></th>
            <th width="20%"><label for="" class="titulo-dato">Datos académicos</label></th>
            <th width="20%"><label for="" class="titulo-dato">Domicilio</label></th>
            <th width="10%"><label for="" class="titulo-dato">Horario tentativo</label></th>
            <th width="20%"><label for="" class="titulo-dato">Observaciones</label></th>
            <th data-formatter="eliminarFormatter"><label class="titulo-dato text-center">Acciones</label></th>
        </thead>
        <tbody id="tabla1">
            @foreach ($prestadores as $prestador)
                <tr>
                    <td>{{$prestador->prestador_id }}</td>
                    <td><span class="valor-dato-tabla-td">{{$prestador->tipo_prestador}}</td></span>
                    <td><span class="valor-dato-tabla-td">{{$prestador->primer_apellido}} {{$prestador->segundo_apellido}} {{$prestador->nombre_prestador}}</td></span>
                    <td>
                        <label for="" class="titulo-td normalizar-texto">Institución: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->nombre_institucion)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Escuela: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->nombre_escuela)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Carrera: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->carrera)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Matrícula: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->matricula)}}</span>
                    </td>
                    <td>
                        <label for="" class="titulo-td normalizar-texto">Municipio: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->municipio_alcaldia)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Ciudad: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->ciudad)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Colonia: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->colonia)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Calle: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->calle)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Número ext: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->numero_exterior)}}</span>
                        <label for="" class="titulo-td normalizar-texto">C.P: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->cp)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Entidad: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->nombre_entidad)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Télefono: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($prestador->telefono)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Email: </label><span class="valor-dato-tabla-td">{{$prestador->email}}</span>
                    </td>
                    <td><span class="valor-dato-tabla-td">{{$prestador->horario_tentativo}}</td></span>
                    <td><span class="valor-dato-tabla-td">{{$prestador->observaciones}}</td></span>
                    <td class="text-center"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row my-5">
    <div class="col-md-12">
        {!! $prestadores->render() !!}
    </div>
</div>
