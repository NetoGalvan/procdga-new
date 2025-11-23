<div class="row mb-4 mt-3">
    <div class="col-md-12">
        <div class="text-right">
            <button onclick="location.reload()" type="button" class="btn btn-danger btn-sm"
                id="verTodosLosCandidatos">Ver todos los candidatos</button>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table width="100%" class="table table-bordered table-striped" id="candidatos" data-toggle="table">
        <thead>
            <th width="5%"><label for="" class="titulo-dato">Tipo de prestador</label></th>
            <th width="15%"><label for="" class="titulo-dato">Nombre</label></th>
            <th width="20%"><label for="" class="titulo-dato">Datos académicos</label></th>
            <th width="20%"><label for="" class="titulo-dato">Domicilio</label></th>
            <th width="10%"><label for="" class="titulo-dato">Horario tentativo</label></th>
            <th width="20%"><label for="" class="titulo-dato">Observaciones</label></th>
            <th width="10%"><label for="" class="titulo-dato text-center">Seleccione</label></th>
        </thead>
            @if ($candidatos->isEmpty())
                <tr>
                    <td colspan="7" class="text-center"> No se encontró ninguna coincidencia con la búsqueda. </td>
                </tr>
            @endif
            @foreach ($candidatos as $candidato)
                <input type="hidden" name="prestador_id" id="prestador_id" value="{{ $candidato->prestador_id }}">
                <tr>
                    <td><span class="valor-dato-tabla-td">{{$candidato->tipo_prestador}}</td></span>
                    <td><span class="valor-dato-tabla-td">{{$candidato->primer_apellido}} {{$candidato->segundo_apellido}} {{$candidato->nombre_prestador}}</td></span>
                    <td>
                        <label for="" class="titulo-td normalizar-texto">Institución: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->nombre_institucion)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Escuela: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->nombre_escuela)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Carrera: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->carrera)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Matricula: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->matricula)}}</span>
                    </td>
                    <td>
                        <label for="" class="titulo-td normalizar-texto">Municipio: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->municipio_alcaldia)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Ciudad: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->ciudad)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Colonia: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->colonia)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Calle: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->calle)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Número ext: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->numero_exterior)}}</span>
                        <label for="" class="titulo-td normalizar-texto">C.P: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->cp)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Entidad: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->nombre_entidad)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Télefono: </label><span class="valor-dato-tabla-td">{{mb_strtoupper($candidato->telefono)}}</span>
                        <label for="" class="titulo-td normalizar-texto">Email: </label><span class="valor-dato-tabla-td">{{$candidato->email}}</span>
                    </td>
                    <td><span class="valor-dato-tabla-td">{{$candidato->horario_tentativo}}</td></span>
                    <td><span class="valor-dato-tabla-td">{{$candidato->observaciones}}</td></span>
                    <td class="text-center"><input type="radio" name="seleccion" id="seleccion"></td>
                </tr>
            @endforeach
    </table> <p></p>
    <div id="errorCandidato"></div>
</div>
<div class="row">
    <div class="col-md-12">
        {!! $candidatos->render() !!}
    </div>
</div>
