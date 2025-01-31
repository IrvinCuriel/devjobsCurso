<?php

namespace App\Http\Controllers;

use App\Vacante;
use App\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //
    public function show(Categoria $categoria)
    {

      //return "desde categoria";

      //dd($categoria);
      //dd($categoria->nombre);
      //dd($categoria->id);

      $vacantes = Vacante::where('categoria_id', $categoria->id)->where('activa', true)->paginate(10);
      //dd($vacantes);

      return view('categorias.show', compact('vacantes', 'categoria'));

    }
}
