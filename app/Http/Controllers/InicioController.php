<?php

namespace App\Http\Controllers;

use App\Vacante;
use App\Ubicacion;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //

        //$vacantes = Vacante::all();
        //$vacantes = Vacante::where('activa', 1)->get();
        //$vacantes = Vacante::where('activa', true)->get();
        //$vacantes = Vacante::where('activa', '=', 1)->get();
        $vacantes = Vacante::latest()->where('activa', '=', true)->take(10)->get();
        //dd($vacantes);
        $ubicaciones = Ubicacion::all();

        return view('inicio.index', compact('vacantes', 'ubicaciones'));
    }
}
