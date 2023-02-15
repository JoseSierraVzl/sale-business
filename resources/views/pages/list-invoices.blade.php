<div>
    <a href="/home">Home</a>
    <h2>Facturas pendientes</h2>
    @if(count($unbilledPurchases) > 0)
        @foreach($unbilledPurchases as $unbilledPurchase)
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Monto Total</th>
                        <th>Impuesto Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $unbilledPurchase['name'] }}</td>
                        <td>{{ $unbilledPurchase['amountTotal'] }}</td>
                        <td>{{ $unbilledPurchase['taxsTotal'] }}</td>
                    </tr>
                </tbody>
            </table>
            <h2>Listado de compras</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre producto</th>
                        <th>Precio</th>
                        <th>Impuesto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unbilledPurchase['products'] as $product)
                    <tr>
                        <td>{{ $product[0]['name'] }}</td>
                        <td>{{ $product[0]['price'] }}</td>
                        <td>{{ $product[0]['tax'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <form action="{{ route('create-invoices', $unbilledPurchase['userId']) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Facturar</button>
            </form>
            <span>-------------------------------------------------------</span>
        @endforeach
    @else
        <h3>No hay facturas pendientes</h3>
    @endif
</div>

<div>
    <h2>Ultimas facturas procesadas</h2>
    @if(count($invoicedPurchases) > 0)
        @foreach($invoicedPurchases as $invoicedPurchase)
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Monto Total</th>
                        <th>Impuesto Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $invoicedPurchase['name'] }}</td>
                        <td>{{ $invoicedPurchase['amountTotal'] }}</td>
                        <td>{{ $invoicedPurchase['taxsTotal'] }}</td>
                    </tr>
                </tbody>
            </table>
            <span>-------------------------------------------------------</span>
        @endforeach
    @else
        <h3>No hay facturas procesadas</h3>
    @endif
</div>

{{-- <h1>Desglose de factura</h1>
<table>
    <tr>
        <td>Cliente:</td>
        <td>{{ $user }}</td>
    </tr>
    <tr>
        <td>Monto total:</td>
        <td>{{ $amountTotal }}$</td>
    </tr>
    <tr>
        <td>Impuesto total:</td>
        <td>{{ $taxsTotal }}%</td>
    </tr>
</table>
<h2>Listado de compras</h2>
<table>
    <thead>
        <tr>
            <th>Nombre producto</th>
            <th>Precio</th>
            <th>Impuesto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product[0]['name'] }}</td>
            <td>{{ $product[0]['price'] }}</td>
            <td>{{ $product[0]['tax'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table> --}}