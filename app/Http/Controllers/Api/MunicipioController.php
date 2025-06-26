<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipio;

class MunicipioController extends Controller
{
    public function index()
    {
        return Municipio::with('departamento')->get();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'departamento_id' => 'required|exists:departamentos,id',
            ]);

            $municipio = Municipio::create($validated);

            return response()->json([
                'message' => 'Municipio creado exitosamente.',
                'data' => $municipio->load('departamento'),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el municipio.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $municipio = Municipio::with('departamento')->findOrFail($id);
            return $municipio;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Municipio no encontrado.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $municipio = Municipio::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'departamento_id' => 'required|exists:departamentos,id',
            ]);

            $municipio->update($validated);

            return response()->json([
                'message' => 'Municipio actualizado correctamente.',
                'data' => $municipio->load('departamento'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el municipio.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $municipio = Municipio::findOrFail($id);
            $municipio->delete();

            return response()->json([
                'message' => 'Municipio eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el municipio.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
