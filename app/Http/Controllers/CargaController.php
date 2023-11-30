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

    function getcargafecha(Request $request)
    {
        $client = new Client();
        $url = 'http://192.168.10.12:30004/reporteroes/2023-11-23?format=json';
        $token = env('TOKEN_XPSOLUTIONS');

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'auth-xpsolutions' => $token
                ]
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getBody()->getContents();
                // Aquí puedes manejar la respuesta de la URL, que está en $content
                // Por ejemplo, decodificar el JSON si es necesario
                $data = json_decode($content, true);
                // ... haz algo con los datos obtenidos
                // dd($data);

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

                return redirect()->route('carga.index');
            } else {
                // Manejar otros códigos de estado si es necesario
            }
        } catch (\Exception $e) {
            // Manejar errores de conexión u otros problemas
            dd($e->getMessage()); // Esto es solo para depurar, puedes manejar el error como desees
        }
    }
}
