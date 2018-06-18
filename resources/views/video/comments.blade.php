<hr/>
<h4>Comentarios</h4>
<hr/>

<!--  presentación del mensaje de la sesión flash, si existe-->
@if(session('message'))
    <div class="alert alert-success">
        {{ session ('message') }}
    </div>
@endif

<!-- Para usuarios autenticados, presentaremos el cuadro de crear comentario -->
@if ( Auth::check() ) 
    <form class="col-md-4" method="POST" action=" {{ url('/comment') }}">
        {!! csrf_field() !!}
        <input type="hidden" name="video_id" value="{{$video->id}}" required />
        <p><textarea class="form-control" name="body" required></textarea></p>
        <input type="submit" value="Comentar" class="btn btn-success" />
    </form>
    <div class="clearfix"></div> <hr/>
@endif

<!-- de forma pública mostramos todos los comentarios -->
@if ( isset ($video->comments) )
    <div id="comments-list">
        @foreach ($video->comments as $comment)
            <div class="comment-item col-md-12 pull-left">
                <div class="panel panel-default video-data">
                    <div class="panel-heading">
                        Por <strong>{{ $comment->user->name . ' ' . $comment->user->surname }}
                        hace {{ \FormatTime::LongTimeFilter($comment->created_at) }}</strong> ({{$comment->created_at}})

                        <!-- Ventana modal para eliminar los comentarios si el usuario es autor del vídeo o del comentario -->
                        @if ( Auth::check() && ( Auth::user()->id == $comment->user_id || Auth::user()->id == $video->user_id ) )
                            <div class="pull-right">
                                <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                <a href="#deleteComment-{{$comment->id}}" role="button" class="btn btn-sm btn-primary" data-toggle="modal">Eliminar</a>
                                <!-- Modal / Ventana / Overlay en HTML -->
                                <div id="deleteComment-{{$comment->id}}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">¿Estás seguro?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Seguro que quieres borrar este comentario?</p>
                                                <p class="text-warning"><small>{{$comment->body}}</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                <a href="{{ url('/delete-comment/'.$comment->id) }}" type="button" class="btn btn-danger">Eliminar comentario</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>


                    <div class="panel-body">
                        {{ $comment->body }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif