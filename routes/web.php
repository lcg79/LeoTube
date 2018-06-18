<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Use App\Video;

// página de bienvenida, para usuarios no logados
Route::get('/', function () {
    return view('welcome');
});

// rutas de la autenticación, las añade automáticamente
Auth::routes();

// controlador home de los usuarios logados
Route::get('/', array(
    'as' => 'home',
    // 'middleware' => 'auth',
    'uses' => 'HomeController@index'
));

// Rutas del controlador de vídeos, form de creación
Route::get('/crear-video',array(
    'as' => 'createVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@createVideo'
));

// Rutas del controlador de vídeos, eliminación
Route::get('/delete-video/{video_id}',array(
    'as' => 'deleteVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@delete'
));

// Rutas del controlador de vídeos, guardado
Route::post('/guardar-video',array(
    'as' => 'saveVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@saveVideo'
));

// Rutas del controlador de vídeos, editar
Route::get('/editar-video/{video_id}',array(
    'as' => 'editVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@edit'
));

// Rutas del controlador de vídeos, actualizar
Route::post('/update-video/{video_id}',array(
    'as' => 'updateVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@update'
));





Route::get('/miniatura/{filename}',array(
    'as' => 'imageVideo',
    // 'middleware' => 'auth',
    'uses' => 'VideoController@getImage'
));

Route::get('/video-file/{filename}',array(
    'as' => 'fileVideo',
    // 'middleware' => 'auth',
    'uses' => 'VideoController@getVideo'
));

Route::get('/video/{video_id}',array(
    'as' => 'detailVideo',
    // 'middleware' => 'auth',
    'uses' => 'VideoController@getVideoDetail'
));

// Routas comentarios
Route::post('/comment', array(
    'as' => 'comment',
    'middleware' => 'auth',
    'uses' => 'CommentController@store'
));

Route::get('/delete-comment/{comment_id}', array(
    'as' => 'commentDelete',
    'middleware' => 'auth',
    'uses' => 'CommentController@delete'
));


// Búsqueda
Route::get('/buscar/{search?}/{filter?}', [
    'as' => 'searchVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@search'
]);


// Canal de usuario
Route::get('/canal/{user_id}', [
    'as' => 'channel',
    'uses' => 'UserController@channel'
]);



// Borrado de caché
Route::get('/clear-cache', function(){
    $code = Artisan::call('cache:clear');
});
