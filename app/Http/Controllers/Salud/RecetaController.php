<?php

namespace App\Http\Controllers\Salud;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RecetaController extends Controller
{
    public function getRecipes()
    {
        $results = DB::table('salud.receta as r')
            ->select(
                'r.recetaid',
                'r.medicamento',
                'r.indicaciones',
                'r.via_administracion',
                'r.dosis',
                'r.frecuencia',
                'r.tiempo',
                'r.cantidad'
            )
            ->get();

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $results
        ]);
    }
}
