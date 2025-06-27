<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index()
    {
        return Pais::all();
    }

    //create pais
    public function store(Request $request)
    {
        try{

            $request->validate([
                'nombre' => 'required|string|max:100',
            ]);
    
            return Pais::create($request->all());
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error al crear el país.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Pais $pai)
    {
        return $pai;
    }


    //update pais
    public function update(Request $request, $id)
    {
        try {
            $pais = Pais::findOrFail($id);
    
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
            ]);
    
            $pais->update([
                'nombre' => $validated['nombre'],
            ]);
    
            return response()->json($pais, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el país.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    

    public function destroy($id){
        try{
            $pais = Pais::find($id);

            if (!$pais) {
                return response()->json([
                    'message' => 'País no encontrado.'
                ], 404);
            }
        
            $pais->delete();
        
            return response()->json([
                'message' => 'País eliminado correctamente.'
            ], 204);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error al eliminar el país.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
