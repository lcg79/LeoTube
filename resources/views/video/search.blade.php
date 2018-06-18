@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="container">

            <div class="col-md-4">
                <h2>Búsqueda: {{ $search }} </h2>
                <br/>
            </div>

            <!-- opciones de ordenación -->
            <div class="col-md-8">
                <form class="col-md-3 pull-right" action="{{ url('/buscar/'.$search) }}" method="get">
                    <label for="filter">Ordenar</label>
                    <select name="filter" class="form-control">
                        <option value="new">más nuevos primero</option>
                        <option value="old">más antiguos primero</option>
                        <option value="alfa">de la A a la Z</option>
                    </select>
                    <input type="submit" value="Ordenar" class="btn-filter btn btn-sm btn-primary pull-right"/>
                </form>
            </div>
            
            <div class="clearfix"></div>
            
            <!-- lista de vídeos (paginada) -->
            @include ('video.list')

        </div>


        <!-- paginación -->
        {{ $videos->links() }}
        
    </div>
</div>
@endsection
