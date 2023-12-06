<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use App\Models\Vehiculo;
use DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

use GuzzleHttp\Client;

class CargaController extends Controller
{
    function index($fecha)
    {
        // $cargas = Carga::where('fecha_venta', $fecha)->get();
        $cargas = Carga::where('fecha_venta', 'LIKE', "$fecha-%")->get();

        // return $cargas;

        $fecha_ant = Carbon::createFromFormat('Y-m', $fecha)->subMonth()->format('Y-m');
        $fecha_act = Carbon::createFromFormat('Y-m', $fecha)->format('Y-m');
        $fecha_sig = Carbon::createFromFormat('Y-m', $fecha)->addMonth()->format('Y-m');

        return view('carga.index', compact('cargas', 'fecha_ant', 'fecha_act', 'fecha_sig'));
    }

    function getcarga()
    {
        return view('carga.getcarga');
    }

    public function getcargafechaAutomatico()
    {
        $fecha = now()->format('Y-m-d'); // Obtiene la fecha actual
        $this->procesarFecha($fecha);
        $fn = now()->format('Y-m');
        return redirect()->route('carga.index', [$fn]);
    }

    public function getcargafecha($fecha)
    {
        $fechaInicio = Carbon::createFromFormat('Y-m', $fecha)->startOfMonth();
        $fechaFin = Carbon::createFromFormat('Y-m', $fecha)->endOfMonth();

        // echo "$fechaInicio <hr> $fechaFin";

        for ($fecha = $fechaInicio; $fecha <= $fechaFin; $fecha->modify('+1 day')) {
            $ff = $fecha->format('Y-m-d');
            echo "Obteniendo datos de fecha $ff <br>";
            $this->procesarFecha($ff);
        }
        $fn = now()->format('Y-m');
        return redirect()->route('carga.index', [$fn]);
    }

    public function getcargafecharango(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        // Convertir las fechas a objetos DateTime
        $fechaInicio = new DateTime($fecha_inicio);
        $fechaFin = new DateTime($fecha_fin);

        // Iterar sobre el rango de fechas
        for ($fecha = $fechaInicio; $fecha <= $fechaFin; $fecha->modify('+1 day')) {
            $ff = $fecha->format('Y-m-d');
            echo "Obteniendo datos de fecha $ff <br>";
            $this->procesarFecha($ff);
        }
        $fn = now()->format('Y-m');
        return redirect()->route('carga.index', [$fn]);
    }

    private function procesarFecha($fecha)
    {
        $client = new Client();
        $url = "http://192.168.10.12:30004/reporteroes/$fecha?format=json";
        $token = env('TOKEN_XPSOLUTIONS');

        $response = $client->request('GET', $url, [
            'headers' => [
                'auth-xpsolutions' => $token
            ]
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            $content = $response->getBody()->getContents();
            $data = json_decode($content, true);
            foreach ($data as $item) {

                $vehiculo = Vehiculo::where('placa', $item['observacion'])->first();

                if ($vehiculo) {
                    $carga = new Carga();
                    $carga->id_referencia = $item['id'];
                    $carga->observacion = $item['observacion'];
                    $carga->total = $item['total'];
                    $carga->nro_factura = $item['nro_factura'];
                    $carga->fecha_venta = $item['fecha_venta'];
                    $carga->razon_social = $item['razon_social'];
                    $carga->nit = $item['nit'];
                    $carga->cantidad = $item['cantidad'];
                    $carga->precio = $item['precio'];
                    $carga->user_id = $vehiculo->user->id;
                }
            }

            // return redirect()->route('carga.index');
        } else {
            // return redirect()->route('carga.index');
            // Manejar otros códigos de estado si es necesario
        }
    }
}
