<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'pais_id'];

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function municipios()
    {
        return $this->hasMany(Municipio::class);
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }
}

