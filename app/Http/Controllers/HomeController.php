<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // consulta de vídeos ordenada descendente y con paginación
        $videos = Video::orderBy('id','desc')->paginate(5);

        // mostraremos los vídeos a través de la vista
        return view('home', array(
            'videos' => $videos
        ));
    }
}
