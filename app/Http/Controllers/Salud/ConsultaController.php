<?php

namespace App\Http\Controllers\Salud;

use App\Http\Controllers\Controller;
use App\Models\Salud\ConsultaOdontograma;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsultaController extends Controller
{
    public function getConsultations()
    {
        $results = DB::table('salud.consulta as c')
            ->select(
                'c.consultaid',
                'cc.fecha',
                'cc.hora',
                DB::raw("(SELECT CONCAT(pn.nombre, ' ', pn.ape_pat, ' ', pn.ape_mat) FROM basic.persona_natural pn WHERE pn.personaid = cc.pacienteid) as paciente"),
                DB::raw("(SELECT CONCAT(pn2.nombre, ' ', pn2.ape_pat, ' ', pn2.ape_mat) FROM basic.persona_natural pn2 WHERE pn2.personaid = cc.medicoid) as medico"),
                'e.nombre as especialidad',
                'e2.nombre as edificio',
                'ec.nombre as estado',
                'ec.abreviatura as estado_abreviatura'
            )
            ->join('salud.cita as cc', 'cc.citaid', '=', 'c.citaid')
            ->join('salud.medico as m', 'm.medicoid', '=', 'cc.medicoid')
            ->join('salud.especialidad as e', 'e.especialidadid', '=', 'cc.especialidadid')
            ->join('basic.edificio as e2', 'e2.edificioid', '=', 'cc.edificioid')
            ->join('salud.estado_cita as ec', 'ec.estadoid', '=', 'cc.estadoid')
            ->get();

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $results
        ]);
    }

    public function getOdontogramConsultation($consultaid)
    {
        $results = DB::table('salud.consulta_odontograma as co')
            ->select(
                'co.consultaid',
                'co.piezaid',
                'co.detalle',
                'co.observacion',
                'onp.numero as pieza_numero',
                'onp.fila as pieza_fila',
                'tt.nombre as tipo_tratamiento',
                'tc.nombre as tipo_cara',
                'co.es_tratamiento'
            )
            ->join('salud.odontograma_numero_pieza as onp', 'onp.piezaid', '=', 'co.piezaid')
            ->join('salud.tipo_tratamiento as tt', 'tt.tipotratamientoid', '=', 'co.tipotratamientoid')
            ->join('salud.tipo_cara as tc', 'tc.tipocaraid', '=', 'co.tipocaraid')
            ->where('co.consultaid', '=', $consultaid)
            ->get();

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $results
        ]);
    }

    public function addOdontogramConsultation(Request $request, $consultaid)
    {
        $validated = $request->validate([
            'piezaid' => 'required|numeric',
            'tipotratamientoid' => 'required|numeric',
            'tipocaraid' => 'required|numeric',
            'es_tratamiento' => 'required|boolean',
            'detalle' => 'required|string',
            'observacion' => 'required|string',
            'imagen' => 'required|string',
        ]);

        $validated['consultaid'] = $consultaid;

        DB::beginTransaction();
        try {
            ConsultaOdontograma::create($validated);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' =>  null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "status" => true,
            "message" => "Odontogram consultation registered successfully",
            "data" => []
        ]);
    }

    public function patchOdontogramConsultation(Request $request, $consultaid, $piezaid)
    {
        $validated = $request->validate([
            'es_tratamiento' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $consultaOdontograma = ConsultaOdontograma::where('consultaid', $consultaid)
                ->where('piezaid', $piezaid)
                ->firstOrFail();

            $consultaOdontograma->update($validated);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' =>  null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "status" => true,
            "message" => "Odontogram consultation updated successfully",
            "data" => []
        ]);
    }

    public function deleteOdontogramConsultation($consultaid, $piezaid)
    {
        DB::beginTransaction();
        try {
            $consultaOdontograma = ConsultaOdontograma::where('consultaid', $consultaid)
                ->where('piezaid', $piezaid)
                ->firstOrFail();

            $consultaOdontograma->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' =>  null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "status" => true,
            "message" => "Odontogram consultation deleted successfully",
            "data" => []
        ]);
    }
}
