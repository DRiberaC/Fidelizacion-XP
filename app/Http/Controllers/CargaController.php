<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class CargaController extends Controller
{
    function index()
    {
        $cargas = Carga::all();
        return view('carga.index', compact('cargas'));
    }

    function getcarga()
    {
        return view('carga.getcarga');
    }

    public function getcargafechaAutomatico()
    {
        $fecha = now()->format('Y-m-d'); // Obtiene la fecha actual
        $this->procesarFecha($fecha);
        return redirect()->route('carga.index');
    }

    public function getcargafecha(Request $request)
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
        return redirect()->route('carga.index');
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
                $carga->user_id = null;
                $carga->save();
            }

            // return redirect()->route('carga.index');
        } else {
            // return redirect()->route('carga.index');
            // Manejar otros códigos de estado si es necesario
        }
    }
}
