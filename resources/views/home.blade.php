@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('list-invoices') }}">Listar facturas</a>
                    @endif
                </div>
                <div>
                    @if(Auth::user()->role == 'admin')
                        <li><a href="{{ route('create-product') }}">Crear producto</a></li>
                    @endif
                </div>
            </div>
        </div>
        @if(Auth::user()->role !== 'admin')
            <div>
                <table id="products-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Impuesto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->tax }}</td>
                            <td>
                                <form action="{{ route('buy-product', $product['id']) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Comprar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
