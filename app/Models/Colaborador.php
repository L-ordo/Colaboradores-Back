<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Colaborador extends Model
{
    use HasFactory;
    protected $table = 'colaboradores';
    protected $fillable = ['nombre_completo', 'edad', 'telefono', 'correo'];

    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'colaborador_empresa');
    }
}

