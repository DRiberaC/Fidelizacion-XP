<?php

namespace App\Http\Controllers;

use App\Models\CabeceraPremioHistorial;
use App\Models\Carga;
use App\Models\Premio;
use App\Models\PremioHistorial;
use App\Models\Producto;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

// use Mike42\Escpos\Printer;
// use Mike42\Escpos\EscposImage;
// use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

use Fpdf\Fpdf;

class ClienteController extends Controller
{
    function index()
    {
        $clienteRole = Role::where('name', 'Cliente')->first();

        if ($clienteRole) {
            $clientes = $clienteRole->users()->get();
        }
        return view('cliente.index', compact('clientes'));
    }

    function create()
    {
        return view('cliente.create');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'ci_nit' => 'required|unique:users',
            'subscription_start' => 'required|date',
        ]);

        $name = $request->input('name');
        $last_name = $request->input('last_name');
        $telefono = $request->input('telefono');
        $ci_nit = $request->input('ci_nit');
        $email = "$ci_nit@roes.com";
        $password = bcrypt('password');

        $cliente = User::create([
            'name' => $name,
            'last_name' => $last_name,
            'ci_nit' => $ci_nit,
            'telefono' => $telefono,
            'subscription_start' => $request->input('subscription_start'),
            'email' => $email,
            'password' => $password,
        ]);

        return redirect()->route('cliente.show', compact('cliente'));
        // return redirect()->route('cliente.index');
    }

    function show(User $cliente)
    {
        return view('cliente.show', compact('cliente'));
    }

    function edit(User $cliente)
    {
        return view('cliente.edit', compact('cliente'));
    }

    function update(Request $request, User $cliente)
    {
        $name = $request->input('name');
        $last_name = $request->input('last_name');
        $ci_nit = $request->input('ci_nit');
        $telefono = $request->input('telefono');

        $cliente->name = $name;
        $cliente->last_name = $last_name;
        $cliente->ci_nit = $ci_nit;
        $cliente->telefono = $telefono;
        $cliente->save();

        return redirect()->route('cliente.show', compact('cliente'));
    }

    function cargasCliente(User $cliente)
    {
        $pag = env('PAGINATE', 10);
        $cargas = Carga::where('user_id', $cliente->id)
            ->orderBy('fecha_venta', 'desc')
            ->orderBy('nro_factura', 'desc')
            ->paginate($pag); // Cambia 10 por el número de resultados por página que desees
        return view('cliente.cargasCliente', compact('cliente', 'cargas'));
    }

    function darPremio(User $cliente)
    {
        $premios = Premio::all();
        return view('cliente.premiar', compact('cliente', 'premios'));
    }

    function setPremio(Request $request, User $cliente)
    {

        $gnv = $cliente->getGNV();
        $gas = $cliente->getGAS();
        $dis = $cliente->getDIS();
        $ggd = $gnv + $gas + $dis;
        $reclamados = $cliente->puntosReclamados();

        $puntosD = $ggd - $reclamados;
        $premios = $request->input('premio');

        $puntosN = 0;

        foreach ($premios as $premio) {
            $cantidad = $premio['cantidad'];
            $premio_id = $premio['premio_id'];
            $pp = Premio::find($premio_id);
            $puntosN += $cantidad * $pp->puntos;
            $ad = $pp->obtenerAdiciones();
            $re = $pp->obtenerReclamos();
            $saldo = $ad - $re;

            if ($cantidad > $saldo) {
                return back()->with('error', "Existencias de $pp->name insuficientes.");
            }
        }

        if ($puntosD >= $puntosN) {

            $detalle = $request->input('detalle');
            $user_id = $cliente->id;

            $cabecera = CabeceraPremioHistorial::create([
                'detalle' => $detalle,
                'user_id' => $user_id,
            ]);

            foreach ($premios as $premio) {

                $premio_id = $premio['premio_id'];
                $pp = Premio::find($premio_id);
                $cantidad = $premio['cantidad'];
                $tipo = 'decremento';

                PremioHistorial::create([
                    'tipo' => $tipo,
                    'cantidad' => $cantidad,
                    'puntos' => $pp->puntos,
                    'detalle' => $detalle,
                    'premio_id' => $premio_id,
                    'user_id' => $user_id,
                    'cabecera_id' => $cabecera->id
                ]);
            }
        } else {
            return back()->with('error', 'Puntos insuficientes.');
        }

        return redirect()->route('cliente.show', compact('cliente'));
    }

    function listapremios(User $cliente)
    {
        $premios = CabeceraPremioHistorial::where('user_id', $cliente->id)->orderBy('created_at', 'desc')->get();
        return view('cliente.listapremios', compact('premios', 'cliente'));
    }

    function ticket(User $cliente, CabeceraPremioHistorial $premio)
    {
        // dd($premio->premioHistoriales);
        $pdf = new FPDF('P', 'mm', array(80, 150)); // Tamaño tickt 80mm x 150 mm (largo aprox)
        $pdf->AddPage();

        // CABECERA
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(60, 4, mb_convert_encoding('Estación de Servicio ROES', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        // DATOS FACTURA        
        $pdf->Ln(5);
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Cell(60, 4, 'Fecha: ' . date("Y-m-d H:i:s"), 0, 1, '');
        $pdf->Cell(60, 4, "Cliente: " . mb_convert_encoding($cliente->name, 'ISO-8859-1', 'UTF-8'), 0, 1, '');
        // $pdf->Cell(60, 4, 'Factura Simpl.: F2019-000001', 0, 1, '');
        // $pdf->Cell(60, 4, 'Fecha: 28/10/2019', 0, 1, '');
        // $pdf->Cell(60, 4, 'Metodo de pago: Tarjeta', 0, 1, '');

        // COLUMNAS
        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->Cell(30, 10, 'Articulo', 0);
        $pdf->Cell(5, 10, 'Und', 0, 0, 'R');
        $pdf->Cell(10, 10, 'Puntos', 0, 0, 'R');
        $pdf->Cell(15, 10, 'Total', 0, 0, 'R');
        $pdf->Ln(8);
        $pdf->Cell(60, 0, '', 'T');
        $pdf->Ln(0);

        // PRODUCTOS

        # Para mostrar el total
        $puntos = 0;
        $pdf->SetFont('Helvetica', '', 7);
        foreach ($premio->premioHistoriales as $item) {
            $puntos += $item->puntos * $item->cantidad;

            $pdf->MultiCell(30, 5, mb_convert_encoding($item->recompensa->name, 'ISO-8859-1', 'UTF-8'), 0, 'L');
            $pdf->Cell(35, -4, $item->cantidad, 0, 0, 'R');
            $pdf->Cell(10, -4, $item->puntos, 0, 0, 'R');
            $pdf->Cell(15, -4, $item->puntos * $item->cantidad, 0, 0, 'R');
            $pdf->Ln(1);
        }

        // SUMATORIO DE LOS PRODUCTOS Y EL IVA
        $pdf->Ln(4);
        $pdf->Cell(60, 0, '', 'T');
        $pdf->Ln(1);
        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->Cell(25, 10, '', 0);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, 'TOTAL: ' . $puntos, 0, 0, 'R');
        $pdf->Ln(1);

        // PIE DE PAGINA
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Ln(10);
        $pdf->Cell(60, 0, '______________', 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Cell(60, 0, 'FIRMA: ' . mb_convert_encoding($cliente->name, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        // Guardar el PDF en el servidor
        $pdf->Output(public_path('ticket.pdf'), 'F');

        // Mostrar el PDF en el navegador
        return response()->file(public_path('ticket.pdf'));

        // $pdf->Output('ticket.pdf', 'f');
        // $pdf->Output('ticket.pdf', 'i');

        // return view('cliente.ticket', compact('premio', 'cliente'));
    }

    function sincronizar(Request $request, User $cliente)
    {
        $vehiculos = $cliente->vehiculos;
        foreach ($vehiculos as $vehiculo) {

            $cargas = Carga::where('observacion', $vehiculo->placa)->where('user_id', null)->get();
            foreach ($cargas as $carga) {

                if ($carga->fecha_venta >= $cliente->subscription_start) {

                    $producto = Producto::where('precio', $carga->precio)->first();
                    // echo "$carga <br>";
                    $carga->factor = $producto->factor;
                    $carga->puntos = $carga->cantidad * $producto->factor;
                    $carga->user_id = $cliente->id;
                    $carga->save();
                    // echo "$carga";
                    // return 0;
                }
            }
        }
        return redirect()->route('cliente.show', compact('cliente'));
    }

    function buscarCliente()
    {
        return view('cliente.buscar');
    }

    function buscarClientePlaca(Request $request)
    {
        $placa = $request->input('placa');
        $vehiculo = Vehiculo::where('placa', $placa)->first();

        if ($vehiculo) {
            $cliente = $vehiculo->user->id;
            return redirect()->route('cliente.show', compact('cliente'));
        }

        return back()->with('error', 'No se encontró la placa : ' . $placa);
        // return view('cliente.buscar');
    }
}
