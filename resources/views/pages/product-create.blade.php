<form action="{{ route('products-store') }}" method="POST">
    @csrf
  
    <div class="form-group">
      <label for="name">Nombre</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
  
    <div class="form-group">
      <label for="price">Precio</label>
      <input type="number" step="0.01" class="form-control" id="price" name="price" required>
    </div>
  
    <div class="form-group">
      <label for="tax">Impuesto</label>
      <input type="number" step="0.01" class="form-control" id="tax" name="tax" required>
    </div>
  
    <button type="submit" class="btn btn-primary">Crear producto</button>
  </form>