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
        <td>{{ $product['nombre'] }}</td>
        <td>{{ $product['precio'] }}</td>
        <td>{{ $product['impuesto'] }}</td>
        <td>
          <form action="{{ route('comprar', $product['id']) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">Comprar</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>