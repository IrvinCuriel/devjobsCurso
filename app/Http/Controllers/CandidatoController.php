<?php

namespace App\Http\Controllers;

use App\Candidato;
use App\Vacante;
use Illuminate\Http\Request;
use App\Notifications\NuevoCandidato;

class CandidatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        // Obtener el id actual
        //dd( $request->route('id') );
        $id_vacante = $request->route('id');

        // Obtener los candidatos y la VacanteController
        $vacante = Vacante::findOrFail( $id_vacante );
        //dd($vacante);
        //dd($vacante->candidatos);

        //policy
        $this-> authorize('view', $vacante);

        return view('candidatos.index', compact('vacante'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //validacion
        $data = $request->validate([
          'nombre' => 'required',
          'email' => 'required|email',
          'cv' => 'required|mimes:pdf|max:1000',
          'vacante_id' => 'required'
        ]);

        //Almacenar archivo pdf
        if($request->file('cv'))
        {
          $archivo = $request->file('cv');
          $nombreArchivo = time() . "." . $request->file('cv')->extension();
          $ubicacion = public_path('/storage/cv');
          $archivo->move($ubicacion, $nombreArchivo);

          //return $nombreArchivo;
        }

        // primera forma
        /*
        $candidato = new Candidato();
        $candidato->nombre = $data['nombre'];
        $candidato->email = $data['email'];
        $candidato->vacante_id = $data['vacante_id'];
        $candidato->cv = "123.pdf";
        $candidato-> save();
        */

        //Segunda forma
        /*
        $candidato = new Candidato($data);
        $candidato->cv = "123.pdf";
        $candidato-> save();
        */

        //Tercer forma
        /*
        $candidato = new Candidato();
        $candidato->fill($data);
        $candidato->cv = "123.pdf";
        $candidato-> save();
        */

        //Cuarta forma  Relación en Modelo
        $vacante = Vacante::find($data['vacante_id']);
        //dd($vacante);
        $vacante->candidatos()->create([
          'nombre' => $data['nombre'],
          'email' => $data['email'],
          //'cv' => '1234.pdf'
          'cv' => $nombreArchivo
        ]);


        $reclutador = $vacante->reclutador;
        //$reclutador->notify( new \App\Notifications\NuevoCandidato() );
        $reclutador->notify( new NuevoCandidato( $vacante->titulo, $vacante->id ) );


        //return "desde store";
        return back()->with('estado', 'Tus datos se enviaron Correctamente! Suerte');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function show(Candidato $candidato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidato $candidato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidato $candidato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidato $candidato)
    {
        //
    }
}
