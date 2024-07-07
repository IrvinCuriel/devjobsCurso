<?php

namespace App\Http\Controllers;

use App\Vacante;
use App\Categoria;
use App\Experiencia;
use App\Ubicacion;
use App\Salario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VacanteController extends Controller
{

    /* SE ELIMINA POR QUE SE HACEN RUTAS PROTEGIDAS EN WEB.PHP CAP 176 */
    /*
    public function __construct()
    {
        //Revisar que el usuario este autenticado y verificado
        $this->middleware(['auth', 'verified']);
    }
    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return "desde VacanteController@index";

        //$vacantes = auth()->user()->vacantes;
        //$vacantes = Vacante::where('user_id', auth()->user()->id )->take(3)->get();
        //$vacantes = Vacante::where('user_id', auth()->user()->id )->paginate(3); //ESTE ES PARA LAS CLASES DE BOOTSTRP
        $vacantes = Vacante::where('user_id', auth()->user()->id )->latest()->simplePaginate(6);
        //dd($vacantes);

        return view('vacantes.index', compact('vacantes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        //Consultas
        $categorias = Categoria::all(); //se conculta el modelo de Categoria all
        $experiencias = Experiencia::all(); //se conculta el modelo de Experiencia all
        $ubicaciones = Ubicacion::all(); //se conculta el modelo de Ubicacion all
        $salarios = Salario::all(); //se conculta el modelo de Salario all

        //return "desde create";
        return view('vacantes.create')
                      ->with('categorias', $categorias)
                      ->with('experiencias', $experiencias)
                      ->with('ubicaciones', $ubicaciones)
                      ->with('salarios', $salarios);
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
        // Validación
        $data = $request->validate([
            'titulo' => 'required|min:8',
            'categoria' => 'required',
            'experiencia' => 'required',
            'ubicacion' => 'required',
            'salario' => 'required',
            'descripcion' => 'required|min:50',
            'imagen' => 'required',
            'skills' => 'required'
        ]);

        //Almacenar en la BD
        auth()->user()->vacantes()->create([
          'titulo' => $data['titulo'],
          'imagen' => $data['imagen'],
          'descripcion' => $data['descripcion'],
          'skills' => $data['skills'],
          'categoria_id' => $data['categoria'],
          'experiencia_id' => $data['experiencia'],
          'ubicacion_id' => $data['ubicacion'],
          'salario_id' => $data['salario'],
        ]);
        //return "desde store";
        return redirect()->action('VacanteController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function show(Vacante $vacante)
    {
        //
        //if($vacante->activa === 0) return abort(404);

        return view('vacantes.show')->with('vacante', $vacante);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacante $vacante)
    {
        //
        //return view('vacantes.edit', compact('vacante'));

        //policy
        $this-> authorize('view', $vacante);

        //Consultas
        $categorias = Categoria::all(); //se conculta el modelo de Categoria all
        $experiencias = Experiencia::all(); //se conculta el modelo de Experiencia all
        $ubicaciones = Ubicacion::all(); //se conculta el modelo de Ubicacion all
        $salarios = Salario::all(); //se conculta el modelo de Salario all

        //return "desde create";
        return view('vacantes.edit')
                      ->with('categorias', $categorias)
                      ->with('experiencias', $experiencias)
                      ->with('ubicaciones', $ubicaciones)
                      ->with('salarios', $salarios)
                      ->with('vacante', $vacante);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacante $vacante)
    {
        //
        //policy
        $this-> authorize('update', $vacante);

        //dd($request->all());

        // Validación
        $data = $request->validate([
            'titulo' => 'required|min:8',
            'categoria' => 'required',
            'experiencia' => 'required',
            'ubicacion' => 'required',
            'salario' => 'required',
            'descripcion' => 'required|min:50',
            'imagen' => 'required',
            'skills' => 'required'
        ]);

        //dd($vacante); //para ver toda la info de la BD
        //dd($vacante->titulo);

        $vacante->titulo = $data['titulo'];
        $vacante->skills = $data['skills'];
        $vacante->imagen = $data['imagen'];
        $vacante->descripcion = $data['descripcion'];
        $vacante->categoria_id = $data['categoria'];
        $vacante->experiencia_id = $data['experiencia'];
        $vacante->ubicacion_id = $data['ubicacion'];
        $vacante->salario_id = $data['salario'];

        $vacante->save();

        // redireccionar
        return redirect()->action('VacanteController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacante $vacante, Request $request)
    {
        //
        //policy
        $this-> authorize('delete', $vacante);

        //return response()->json($vacante); //Se usa para ver data:
        //return response()->json($requests); // Si se require saber lo que se le esta mandando al servidor: data:

        $vacante->delete();
        return response()->json(['mensaje' => 'Se eliminó la vacante' . $vacante->titulo]);
    }

    // Campos extras
    public function imagen(Request $request)
    {
      //return "subiendo imagen";
      //return $request->all();
      //return $request->file('file');

      $imagen = $request->file('file');
      //return $imagen->extension();
      //return $imagen;
      $nombreImagen = time() . '.' . $imagen->extension();
      $imagen->move(public_path('storage/vacantes'), $nombreImagen);
      //return $nombreImagen;
      return response()->json(['correcto' => $nombreImagen]);
    }

    // Borrar imagen via Ajax
    public function borrarimagen(Request $request)
    {
      if($request->ajax()){
        //return $request->get('imagen');
        $imagen = $request->get('imagen');

        if( File::exists( 'storage/vacantes/' . $imagen ) ) {
            File::delete( 'storage/vacantes/' . $imagen );
        }

        return response('Imagen Eliminada', 200);
      }
    }

    //Cambia el estado de una vacantes
    public function estado(Request $request, Vacante $vacante)
    {
      //

      // Leer nuevo estado y asignarlo
      $vacante->activa = $request->estado;

      // guardar en la bd
      $vacante->save();

      //return response()->json($request);
      //return response()->json($vacante);
      return response()->json(['respuesta' => 'Correcto']);

    }


    //RESULTADOS
    public function buscar(Request $request)
    {
      //dd($request->all());
      //return "buscando...";

      //Validar
      $data = $request->validate([
        'categoria' => 'required',
        'ubicacion' => 'required'
      ]);

      // Asignar valores
      $categoria = $data['categoria'];
      $ubicacion = $data['ubicacion'];

      // PRIMERA FORMA PARA BURCAR CON WHERE
      $vacantes = Vacante::latest()
          ->where('categoria_id', $categoria)
          ->where('ubicacion_id', $ubicacion)
          ->get();

      //SEGUNDA FORMA PARA BUSCAR CON WHERE
      /*
      $vacantes = Vacante::where([
        'categoria_id' => $categoria,
        'ubicacion_id' => $ubicacion
      ])->get();
      */

      //  FORMA OR CON WHERE
      /*
      $vacantes = Vacante::latest()
          ->where('categoria_id', $categoria)
          ->orwhere('ubicacion_id', $ubicacion)
          ->get();
      */

      //dd($vacantes);

      return view('buscar.index', compact('vacantes'));

    }

    public function resultados(Request $request, Vacante $vacante)
    {
      return "mostrando resultados";
    }

}
