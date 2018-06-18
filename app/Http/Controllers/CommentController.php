<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// importamos nuestro modelo de comentario
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request) {

        $validate = $this->validate($request, [
                'body' => 'required'
        ]);

        $user = \Auth::user();

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->video_id = $request->input('video_id');
        $comment->body = $request->input('body');

        $comment->save();

        return redirect()->route('detailVideo', ['video_id' => $comment->video_id] )->with (array(
           'message' => 'Comentario añadido correctamente.'
        ));
    }

    public function delete($comment_id) {

        $user = \Auth::user();
        $comment = Comment::find($comment_id);

        // var_dump($comment); die();
        
        if ( $user && ( $comment->user_id == $user->id  ||  $comment->video->user_id == $user->id ) ) {
            $comment->delete();
        }

        return redirect()->route('detailVideo', ['video_id' => $comment->video_id] )->with (array(
            'message' => 'Comentario eliminado.'
         ));
    }
}
