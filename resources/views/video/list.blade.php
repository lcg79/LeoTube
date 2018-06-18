            <!-- lista de vídeos (paginada) -->
            <div id="videos-list">
            
                @if ( count($videos) < 1 )
                    <div class="alert alert-warning">No se ha encontrado ningún vídeo</div>
                @else
                    @foreach($videos as $video)
                        <div class="video-item col-md-10 pull-left panel panel-default">
                            <div class="panel-body">

                                <!-- imagen del vídeo -->
                                @if ( Storage::disk('images')->has($video->image) )
                                    <div class="video-image-thumb col-md-3 pull-left">
                                        <div class="video-image-mask">
                                            <img src="{{ url('/miniatura/'.$video->image) }}" class="video-image"/>
                                        </div>
                                    </div>
                                @endif
                                <!-- end imagen del vídeo -->

                                <!-- detalles del vídeo -->
                                <div class="data">
                                    <h4 class="video-title"><a href="{{ route('detailVideo',['video_id'=> $video->id ]) }}">{{ $video->title }}</a></h4>
                                    <p>Subido por <strong><a href="{{ route('channel', [ 'user_id' => $video->user->id ]) }}">{{ $video->user->name . ' ' . $video->user->surname  }}</a>
                                    hace {{ \FormatTime::LongTimeFilter($video->created_at) }}</strong> ({{$video->created_at}})
                    </p>
                                </div>
                                <!-- end detalles del vídeo -->

                                <!-- botones de acción -->
                                <a href="{{ route('detailVideo',['video_id'=> $video->id ]) }}" class="btn btn-success">Ver</a>
                                @if (  Auth::check()  &&  Auth::user()->id == $video->user->id  )
                                    
                                    <!-- Editar vídeo -->
                                    <a href="{{ route('editVideo', [ 'video_id' => $video->id ] )}}" class="btn btn-warning">Editar</a>
                                    <!-- End Editar vídeo -->

                                    <!-- Eliminar vídeo -->
                                    <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                    <a href="#deleteVideo-{{$video->id}}" role="button" class="btn btn-danger btn-primary" data-toggle="modal">Eliminar</a>
                                    <!-- Modal / Ventana / Overlay en HTML -->
                                    <div id="deleteVideo-{{$video->id}}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">¿Estás seguro?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Seguro que quieres borrar este vídeo?</p>
                                                    <p class="text-warning"><small>{{$video->title}}</small></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <a href="{{ url('/delete-video/'.$video->id) }}" type="button" class="btn btn-danger">Eliminar vídeo</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Eliminar vídeo -->

                                @endif
                                <!-- end botones de acción -->
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>