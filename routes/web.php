<?php

use Illuminate\Support\Facades\Route;

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes(['verify' => true]);

//Route::get('/home', 'HomeController@index')->name('home');


/* anterior cap 176
// Rutas de vacantes
Route::get('/vacantes', 'VacanteController@index')->name('vacantes.index');
Route::get('/vacantes/create', 'VacanteController@create')->name('vacantes.create');
Route::post('/vacantes', 'VacanteController@store')->name('vacantes.store');
Route::get('/vacantes/{vacante}', 'VacanteController@show')->name('vacantes.show');

// Subir Imagenes
Route::post('/vacantes/imagen', 'VacanteController@imagen')->name('vacantes.imagen');
// Eliminar Imagenes
Route::post('/vacantes/borrarimagen', 'VacanteController@borrarimagen')->name('vacantes.borrar');
*/

 // RUTAS PROTEGIDAS
 Route::group(['middleware' => ['auth', 'verified']], function() {
   // Rutas de vacantes
   Route::get('/vacantes', 'VacanteController@index')->name('vacantes.index');
   Route::get('/vacantes/create', 'VacanteController@create')->name('vacantes.create');
   Route::post('/vacantes', 'VacanteController@store')->name('vacantes.store');
   Route::delete('/vacantes/{vacante}', 'VacanteController@destroy')->name('vacantes.destroy');
   Route::get('/vacantes/{vacante}/edit', 'VacanteController@edit')->name('vacantes.edit');
   Route::put('/vacantes/{vacante}', 'VacanteController@update')->name('vacantes.update');
   // Subir Imagenes
   Route::post('/vacantes/imagen', 'VacanteController@imagen')->name('vacantes.imagen');
   // Eliminar Imagenes
   Route::post('/vacantes/borrarimagen', 'VacanteController@borrarimagen')->name('vacantes.borrar');
   //CAMBIAR ESTADO DE LA VACANTE
   Route::post('/vacantes/{vacante}', 'VacanteController@estado')->name('vacantes.estado');
   //NOTIFICACIONES
   Route::get('/notificaciones', 'NotificacionesController')->name('notificaciones');
 });

 // Página de Inicio
 Route::get('/', 'InicioController')->name('inicio');

 // Categorias
 Route::get('/categorias/{categoria}', 'CategoriaController@show')->name('categorias.show');

 // EENVIAR DATOS PARA UNA VACANTE
 Route::get('/candidatos/{id}', 'CandidatoController@index')->name('candidatos.index');
 Route::post('/candidatos/store', 'CandidatoController@store')->name('candidatos.store');

 // MUESTRA LOS TRABAJOS EN EL FRONT END SIN AUTETICACIÓN & buscador
 Route::get('/busqueda/buscar', 'VacanteController@resultados')->name('vacantes.resultados');
 Route::post('/busqueda/buscar', 'VacanteController@buscar')->name('vacantes.buscar');
 Route::get('/vacantes/{vacante}', 'VacanteController@show')->name('vacantes.show');
