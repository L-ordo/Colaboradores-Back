<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nit', 'razon_social', 'nombre_comercial',
        'telefono', 'correo',
        'pais_id', 'departamento_id', 'municipio_id'
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function colaboradores()
    {
        return $this->belongsToMany(Colaborador::class, 'colaborador_empresa');
    }
}

