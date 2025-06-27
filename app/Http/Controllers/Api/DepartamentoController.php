<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departamento;

class DepartamentoController extends Controller
{
    public function index()
    {
        return Departamento::with('pais')->get();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'pais_id' => 'required|exists:paises,id',
            ]);

            $departamento = Departamento::create($validated);

            return response()->json([
                'message' => 'Departamento creado exitosamente.',
                'data' => $departamento->load('pais'),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el departamento.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $departamento = Departamento::with('pais')->findOrFail($id);
            return $departamento;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Departamento no encontrado.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, $id)
{
    try {
        $departamento = Departamento::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'pais_id' => 'nullable|exists:paises,id',
        ]);

        $departamento->update([
            'nombre' => $validated['nombre'],
        ]);

        return response()->json([
            'message' => 'Departamento actualizado correctamente.',
            'data' => $departamento->load('pais'),
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al actualizar el departamento.',
            'error' => $e->getMessage()
        ], 500);
    }
}




    public function destroy(string $id)
    {
        try {
            $departamento = Departamento::findOrFail($id);
            $departamento->delete();

            return response()->json([
                'message' => 'Departamento eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el departamento.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
