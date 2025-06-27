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
                'edad' => 'required|integer|min:18|max:99',
                'telefono' => 'required|string|max:20',
                'correo' => 'required|email|max:100',
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
    public function update(Request $request, $id)
    {
    try {
        // Obtener el colaborador por su ID
        $colaborador = Colaborador::findOrFail($id);

        // Validar los datos del request
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:150',
            'edad' => 'required|integer|min:18|max:99',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:100'
        ]);

        // Actualizar los campos básicos
        $colaborador->update([
            'nombre_completo' => $validated['nombre_completo'],
            'edad' => $validated['edad'],
            'telefono' => $validated['telefono'],
            'correo' => $validated['correo'],
        ]);

        // Retornar colaborador actualizado
        return response()->json($colaborador, 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al actualizar el colaborador.',
            'error' => $e->getMessage()
        ], 500);
    }
}


    // Delete a Colaborador
    public function destroy($id)
    {
        try {
            $colaborador = Colaborador::find($id);
    
            if (!$colaborador) {
                return response()->json([
                    'message' => 'Colaborador no encontrado.'
                ], 404);
            }
    
            // Elimina las relaciones con empresas
            $colaborador->empresas()->detach();
    
            // Elimina el colaborador
            $colaborador->delete();
    
            return response()->json([
                'message' => 'Colaborador eliminado correctamente.'
            ], 204);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el colaborador.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
