<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CargaController extends Controller
{
    function index($fecha)
    {
        $pag = env('PAGINATE', 10);
        $cargas = Carga::where('fecha_venta', 'LIKE', "$fecha-%")
            ->orderBy('fecha_venta', 'desc')
            ->orderBy('nro_factura', 'desc')
            ->paginate($pag); // Cambia 10 por el número de resultados por página que desees

        $fecha_ant = Carbon::createFromFormat('Y-m', $fecha)->subMonth()->format('Y-m');
        $fecha_act = Carbon::createFromFormat('Y-m', $fecha)->format('Y-m');
        $fecha_sig = Carbon::createFromFormat('Y-m', $fecha)->addMonth()->format('Y-m');

        return view('carga.index', compact('cargas', 'fecha_ant', 'fecha_act', 'fecha_sig'));
    }

    public function recibirCarga(Request $request)
    {

        $datos = $request->json()->all();

        if (!empty($datos)) {
            foreach ($datos as $dato) {
                // Crear una nueva instancia del modelo Carga
                $carga = new Carga();
                $carga->id_referencia = $dato['id'];
                $carga->observacion = $dato['observacion'];
                $carga->total = $dato['total'];
                $carga->nro_factura = $dato['nro_factura'];
                $carga->fecha_venta = $dato['fecha_venta'];
                $carga->razon_social = $dato['razon_social'];
                $carga->nit = $dato['nit'];
                $carga->cantidad = $dato['cantidad'];
                $carga->precio = $dato['precio'];

                // Guardar el objeto Carga en la base de datos
                $carga->save();
            }

            return response()->json(['message' => 'Datos guardados correctamente'], 200);
        }

        return response()->json(['message' => 'No se recibieron datos válidos'], 400);
    }

    function lastCarga()
    {
        $carga = Carga::latest('fecha_venta')->first();

        // Obtener la fecha formateada sin la hora
        $fechaVenta = Carbon::parse($carga->fecha_venta)->format('Y-m-d');

        return response()->json($fechaVenta, 200);
    }
}
