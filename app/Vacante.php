<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    //
    protected $fillable = [
        'titulo', 'imagen', 'descripcion', 'skills', 'categoria_id', 'experiencia_id', 'ubicacion_id', 'salario_id'
    ];

    //Relacion 1:1 categoria y Vacante
    public function categoria()
    {
      return $this->belongsTo(Categoria::class);
    }

    //Relacion 1:1 salario y Vacante
    public function salario()
    {
      return $this->belongsTo(Salario::class);
    }

    //Relacion 1:1 ubicacion y Vacante
    public function ubicacion()
    {
      return $this->belongsTo(Ubicacion::class);
    }

    //Relacion 1:1 experiencia y Vacante
    public function experiencia()
    {
      return $this->belongsTo(Experiencia::class);
    }

    //Relacion 1:1 reclutador y Vacante
    public function reclutador()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    //Relacion 1:1 vacante y candidatos Para cuarta forma de guardar contacto en bd
    public function candidatos()
    {
      return $this->hasMany(Candidato::class);
    }

}
