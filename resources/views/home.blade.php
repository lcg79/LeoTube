@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <!-- desactivamos el código que viene por defecto de bienvenida -->

        <!-- <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div> -->

        <div class="container">

            <!--  presentación del mensaje de la sesión flash, si existe-->
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session ('message')}}
                </div>
            @endif

            <!-- lista de vídeos (paginada) -->
            @include ('video.list')

        </div>

        <div class="clearfix"></div>

        <!-- paginación -->
        {{ $videos->links() }}

    </div>
</div>
@endsection
