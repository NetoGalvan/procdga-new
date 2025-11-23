@extends('layouts.main')
@section('contenido')

    <div class="container">
        <div class="card shadow-sm p-5 mb-5 bg-white rounded">
            <h4 class="mb-4">Proceso de directorio</h4>
            <p class="text-justify">
                Sólo puede ejecutarse una carga a la vez. Si no puede iniciar este proceso, revise que en sus tareas no haya una relativa al directorio, o que los otros participantes en este proceso hayan terminado sus actividades.
                ¡Gracias!
            </p>

        </div>

        <div class="text-center">
            <form action="{{ route('directorio.inicializar.proceso') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-sl">Iniciar proceso</button>
                <a href="{{ route('procesos') }}" class="btn btn-danger btn-sl">Regresar a procesos</a>
            </form>
        </div>
    </div>

@endsection
