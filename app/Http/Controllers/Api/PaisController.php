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

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        return Pais::create($request->all());
    }

    public function show(Pais $pai)
    {
        return $pai;
    }

    public function update(Request $request, Pais $pai)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $pai->update($request->all());
        return $pai;
    }

    public function destroy(Pais $pai)
    {
        $pai->delete();
        return response()->noContent();
    }
}
