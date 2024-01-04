<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Estación de Servicio ROES</title>
</head>

<body>
    <div class="ticket">
        {{-- <img src="./logo.png" alt="Logo"> --}}
        <p class="centered">
            Estación de Servicio
        </p>
        <p class="centered">
            ROES
        </p>
        <p class="right-aligned">
            Fecha: {{ $premio->created_at->format('Y-m-d') }}
        </p>
        <p class="right-left">
            Cliente: {{ $cliente->name }}
        </p>
        <table>
            <thead>
                <tr>
                    <th class="quantity">Cant.</th>
                    <th class="description">Descrición</th>
                    <th class="price">$$</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $puntos = 0;
                @endphp
                @foreach ($premio->premioHistoriales as $item)
                    <tr>
                        <td class="quantity">{{ $item->cantidad }}</td>
                        <td class="description">{{ $item->recompensa->name }}</td>
                        <td class="price">{{ $item->puntos }}</td>
                    </tr>
                    @php
                        $puntos += $item->puntos * $item->cantidad;
                    @endphp
                @endforeach
                <tr>
                    {{-- <td class="quantity">{{ $item->cantidad }}</td> --}}
                    <td colspan="2" class="description">Total puntos</td>
                    <td class="price">{{ $puntos }}</td>
                </tr>
            </tbody>
        </table>

        <hr>

        @php
            $gnv = $cliente->getGNV();
            $gas = $cliente->getGAS();
            $dis = $cliente->getDIS();
            $ggd = $gnv + $gas + $dis;

            $reclamados = $cliente->puntosReclamados();

            $puntosrestantes = $ggd - $reclamados;
        @endphp

        <p class="right-left">
            Puntos Acumulados: {{ $ggd }}
        </p>
        <p class="right-left">
            Puntos Utilizados: {{ $reclamados }}
        </p>
        <p class="right-left">
            Puntos Restantes: {{ $puntosrestantes }}
        </p>
        <br><br>
        <p class="centered">
            <hr>
            Firma {{ $cliente->name }}
        </p>
        <br><br>
    </div>
    <button id="btnPrint" class="hidden-print">Imprimir</button>
</body>

</html>
<script>
    const $btnPrint = document.querySelector("#btnPrint");
    $btnPrint.addEventListener("click", () => {
        window.print();
    });
</script>
