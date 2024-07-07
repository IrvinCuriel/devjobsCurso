<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    //

    // se require en la segunda y tercer forma par guardar el contacto en la bd
    protected $fillable = [
      'nombre', 'email', 'cv', 'vacante_id'
    ];
}
