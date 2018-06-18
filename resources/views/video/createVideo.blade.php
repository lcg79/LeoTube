<!-- para que herede el aspecto de layout de laravel -->
@extends('layouts.app')

<!-- para crear la sección de contenidos -->
@section('content')

<div class="container">
    <div class="row">

        <h2>Crear un nuevo vídeo</h2>
        <hr>

        <!--  formulario de subida de vídeos  -->
        <!-- con action="{{ route('saveVideo') }}" conseguimos que sea dinámica la url -->
        <form action="{{ route('saveVideo') }}" method="post" enctype="multipart/form-data" class="col-lg-7">

            <!-- Laravel tiene mecanismo automático anti CSRF, hay que poner esta función para que funcione -->
            {!! csrf_field() !!}

            <!-- presentar mensajes de error si los hay, por ejemplo de validación -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Con las opcines {{old('title')}} de los campos del form, en casos de errores, rellenaremos la
            información existente al recargar la página, para no tener que volver a escribirla -->

            <!-- campo de título -->
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}"/>
            </div>

            <!-- campo de descripción -->
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" name="description"/>{{old('description')}}</textarea>
            </div>

            <!-- campo del fichero de imagen -->
            <div class="form-group">
                <label for="image">Miniatura</label>
                <input type="file" class="form-control" id="image" name="image"/>
            </div>

            <!-- campo del fichero del vídeo -->
            <div class="form-group">
                <label for="video">Archivo de vídeo</label>
                <input type="file" class="form-control" id="video" name="video"/>
            </div>

            <!-- botón de envío del form -->
            <button type="submit" class="btn btn-success">Crear vídeo</button>
        
        </form>
        <!--  end formulario de subida de vídeos  -->

    </div>
</div>
@endsection