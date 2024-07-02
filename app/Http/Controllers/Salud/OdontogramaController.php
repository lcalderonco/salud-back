<?php

namespace App\Http\Controllers\Salud;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OdontogramaController extends Controller
{
    public function getTeeth($tipoodontogramaid)
    {
        $results = DB::table('salud.odontograma as a')
            ->select('d.piezaid', 'b.tipoodontogramaid', 'b.abreviatura', 'nombre', 'd.fila', 'c.numero', 'd.imagen')
            ->join('salud.tipo_odontograma as b', 'a.tipoodontogramaid', '=', 'b.tipoodontogramaid')
            ->join('salud.odontograma_numero as c', 'a.odontogramaid', '=', 'c.odontogramaid')
            ->join('salud.odontograma_numero_pieza as d', 'c.numero', '=', 'd.numero')
            ->where('b.tipoodontogramaid', $tipoodontogramaid)
            ->orderBy('d.fila')
            ->orderBy('c.orden')
            ->get();

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $results
        ]);
    }

    public function getPiezas($tipoodontogramaid)
    {
        $results = DB::table('salud.odontograma as a')
            ->select('d.piezaid', 'd.fila', 'c.numero')
            ->join('salud.tipo_odontograma as b', 'a.tipoodontogramaid', '=', 'b.tipoodontogramaid')
            ->join('salud.odontograma_numero as c', 'a.odontogramaid', '=', 'c.odontogramaid')
            ->join('salud.odontograma_numero_pieza as d', 'c.numero', '=', 'd.numero')
            ->where('b.tipoodontogramaid', $tipoodontogramaid)
            ->orderBy('d.fila')
            ->orderBy('c.numero')
            ->get();

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $results
        ]);
    }

    public function getFaceType()
    {
        $results = DB::table('salud.tipo_cara')->get();

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $results
        ]);
    }

    public function getTypeTreatment()
    {
        $results = DB::table('salud.tipo_tratamiento')->get();

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $results
        ]);
    }
}
