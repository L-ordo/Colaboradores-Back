<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colaborador;

class ColaboradorController extends Controller
{
    public function index()
    {
        return Colaborador::with('empresas')->get();
    }

    //Create a new Colaborador
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_completo' => 'required|string|max:150',
                'edad' => 'nullable|integer|min:18|max:99',
                'telefono' => 'nullable|string|max:20',
                'correo' => 'nullable|email|max:100',
                'empresa_ids' => 'nullable|array',
                'empresa_ids.*' => 'exists:empresas,id'
            ]);
    
            $colaborador = Colaborador::create($validated);
    
            if (isset($validated['empresa_ids'])) {
                $colaborador->empresas()->sync($validated['empresa_ids']);
            }
    
            return response()->json([
                'message' => 'Colaborador creado exitosamente.',
                'data' => $colaborador->load('empresas')
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el colaborador.',
                'error' => $e->getMessage()
            ], 500);
        }
    }    
    // Show Colaboradors
    public function show(Colaborador $colaborador)
    {
        return $colaborador->load('empresas');
    }
    
    // Update a Colaborador
    public function update(Request $request, Colaborador $colaborador)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:150',
            'edad' => 'nullable|integer|min:18|max:99',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100',
            'empresa_ids' => 'nullable|array',
            'empresa_ids.*' => 'exists:empresas,id'
        ]);

        $colaborador->update($validated);

        if (isset($validated['empresa_ids'])) {
            $colaborador->empresas()->sync($validated['empresa_ids']);
        }

        return $colaborador->load('empresas');
    }

    // Delete a Colaborador
    public function destroy(Colaborador $colaborador)
    {
        $colaborador->empresas()->detach(); // limpia la relación
        $colaborador->delete();
        return response()->noContent();
    }
}
