@extends('layouts.app')

@section('content')

<div class="col-md-11 col-md-offset-1">

    <h2>{{$video->title}}</h2>
    <hr/>

    <div class="col-md-8">

        <!-- vídeo -->
        <video controls width=100% height=100% id="video-player">
            <source src="{{ route('fileVideo', [ 'filename' => $video->video_path ] ) }}">
                Tu navegador no es compatible con HTML 5.
            </source>
        </video>

        <!-- descripción -->
        <div id="video-info">
            <div class="panel panel-default video-data">
                <div class="panel-heading">
                    Subido por <strong>{{ $video->user->name . ' ' . $video->user->surname }}
                    hace {{ \FormatTime::LongTimeFilter($video->created_at) }}</strong> ({{$video->created_at}})
                </div>
                <div class="panel-body">
                    {{ $video->description }}
                </div>
            </div>
        </div>

        <!-- comentarios -->
        @include('video.comments')

    </div>

</div>

@endsection
