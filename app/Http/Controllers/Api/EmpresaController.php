<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
    {
        return Empresa::with(['pais', 'departamento', 'municipio'])->get();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nit' => 'required|string|max:50|unique:empresas',
                'razon_social' => 'required|string|max:150',
                'nombre_comercial' => 'nullable|string|max:150',
                'telefono' => 'nullable|string|max:20',
                'correo' => 'nullable|email|max:100',
                'pais_id' => 'required|exists:paises,id',
                'departamento_id' => 'required|exists:departamentos,id',
                'municipio_id' => 'required|exists:municipios,id',
            ]);

            $empresa = Empresa::create($validated);

            return response()->json([
                'message' => 'Empresa creada exitosamente.',
                'data' => $empresa->load(['pais', 'departamento', 'municipio']),
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        }
        // catch (\Exception $e) {
        //     return response()->json([
        //         'message' => 'Error al crear la empresa.',
        //         'error' => $e->getMessage(),
        //     ], 500);
        // }
    }

     public function show(string $id)
    {
        try {
            $empresa = Empresa::with(['pais', 'departamento', 'municipio'])->findOrFail($id);
            return $empresa;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Empresa no encontrada.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $empresa = Empresa::findOrFail($id);

            $validated = $request->validate([
                'nit' => 'required|string|max:50|unique:empresas,nit,' . $empresa->id,
                'razon_social' => 'required|string|max:150',
                'nombre_comercial' => 'nullable|string|max:150',
                'telefono' => 'nullable|string|max:20',
                'correo' => 'nullable|email|max:100',
                'pais_id' => 'required|exists:paises,id',
                'departamento_id' => 'required|exists:departamentos,id',
                'municipio_id' => 'required|exists:municipios,id',
            ]);

            $empresa->update($validated);

            return response()->json([
                'message' => 'Empresa actualizada correctamente.',
                'data' => $empresa->load(['pais', 'departamento', 'municipio']),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la empresa.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $empresa = Empresa::findOrFail($id);
            $empresa->delete();

            return response()->json([
                'message' => 'Empresa eliminada correctamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la empresa.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
