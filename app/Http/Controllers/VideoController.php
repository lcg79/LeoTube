<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comment;

class VideoController extends Controller
{
     
    public function createVideo () {

        //  ejecutamos la vista con el formulario de subida de vídeo
        return view ('video.createVideo');

    }


    public function saveVideo (Request $request) {

        //validación del formulario
        $validatedData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required',
            // 'video' => 'mimes:mp4,mov'
        ]);

        // creamos objeto usuario
        $user = \Auth::user();
        
        // creamos objeto video y lo rellenamos con información que llega por request
        $video= new Video();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        // recogemos la miniatura y guardamos en disco
        $image = $request->file('image');
        if ($image) {
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path ;
        }

        // recogemos el vídeo y guardamos en disco
        $video_file = $request->file('video');
        if ($video_file) {
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path ;
        }

        // guardamos el objeto en bd
        $video->save();

        // ejecutamos vista con un mensaje de sesión flash
        return redirect()->route('home')->with(array(
            "message" => 'El vídeo se ha subido correctamente.'
        ));
    }


    public function getImage($filename){

        // obtenemos el fichero del disco y lo devolvemos como una respuesta http
        $file = \Storage::disk('images')->get($filename);
        return new Response($file,200);
    }


    public function getVideo($filename){

        // obtenemos el fichero del disco y lo devolvemos como una respuesta http
        $file = Storage::disk('videos')->get($filename);
        return new Response($file,200);
    }
    

    public function getVideoDetail($video_id){

        // con Eloquent ORM buscamos el vídeo y lo devolvemos a través de la vista
        $video = Video::find($video_id);
        return view('video.detail',array(
            'video' => $video
        ));
    }


    public function delete($video_id){

        // creamos objeto usuario
        $user = \Auth::user();

        // con Eloquent ORM buscamos el vídeo y lo devolvemos a través de la vista
        $video = Video::find($video_id);

        //  buscar comentarios para eliminarlos también
        $comments = Comment::where('video_id', $video_id)->get();

        if ( $user && $video->user_id == $user->id ) {
            
            // elim comentarios. como puede haber varios hay que ir uno a uno
            if ( $comments && count($comments) >= 1 ) {
                foreach ($comments as $comment )
                    $comment->delete();
            }

            // elim ficheros
            \Storage::disk('images')->delete($video->image);
            \Storage::disk('videos')->delete($video->video_path);

            // elim reg bd
            $video->delete();
        
            // todo ha ido bien
            $message="Vídeo eliminado.";

        } else {
            // si no había permisos...
            $message="El vídeo no ha podido eliminarse.";
        }    

        // al final una redirección con el mensaje en sesión flash
        return redirect()->route('home')->with($message);
    }


    public function edit($video_id){

        $user = \Auth::user();
        $video = Video::findOrFail($video_id);

        if ( $user && $video->user_id == $user->id ) {
            return view('video.edit', array('video' => $video));
        } else {
            return redirect()->route('home');
        }
    }


    public function update($video_id, Request $request){
        
        $validatedData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required',
            // 'video' => 'mimes:mp4,mov'
        ]);
        
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        $video->user_id=$user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        // recogemos la miniatura y guardamos en disco
        $image = $request->file('image');
        if ($image) {
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path ;
        }

        // recogemos el vídeo y guardamos en disco
        $video_file = $request->file('video');
        if ($video_file) {
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path ;
        }

        $video->update();

        return redirect()->route('home')->with(array("Vídeo actualizado."));
    }

    public function search ( $search=null , $filter = null ) {

        if ( is_null ($search) ){
            $search = \Request::get('search');

            if ( is_null ($search) ) {
                return redirect()->route('home') ;
            } else {
                return redirect()->route('searchVideo', ['search' => $search ]);   
            }   
        }

        if ( is_null($filter) && \Request::get('filter') && !is_null($search)){
            $filter = \Request::get('filter');

            return redirect()->route('searchVideo', [
                'search' => $search,
                'filter' => $filter
            ]); 
        }

        $col='id';
        $ord='desc';
        if ( !is_null($filter) ) {
            if ($filter == 'new')   { $col="id";     $ord="desc"; }
            if ($filter == 'old')   { $col="id";     $ord="asc";  }
            if ($filter == 'alfa')  { $col="title";  $ord="asc";  } 
        }

        $videos = Video::where('title', 'LIKE', '%'.$search.'%')->orderBy($col,$ord)->paginate(5);

        return view('video.search',array(
            'videos' => $videos,
            'search' => $search
        ));

    }
}
