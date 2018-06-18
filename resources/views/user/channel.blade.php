@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="container">

            
            <h2>Canal de {{ $user->name . ' ' . $user->surname}} </h2>
           

  
            
            <div class="clearfix"></div>
            
            <!-- lista de vídeos (paginada) -->
            @include ('video.list')

        </div>


        <!-- paginación -->
        {{ $videos->links() }}
        
    </div>
</div>
@endsection
