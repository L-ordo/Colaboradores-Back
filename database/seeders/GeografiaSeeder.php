<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;

class GeografiaSeeder extends Seeder
{
    public function run(): void
    {
        $pais = Pais::create(['nombre' => 'Guatemala']);

        $departamento = Departamento::create([
            'nombre' => 'Guatemala',
            'pais_id' => $pais->id,
        ]);

        Municipio::create([
            'nombre' => 'Mixco',
            'departamento_id' => $departamento->id,
        ]);
    }
}
