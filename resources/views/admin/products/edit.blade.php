<form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update',$product) }}">
@csrf @method('PUT')
<input name="name" value="{{ $product->name }}"/>
<textarea name="description">{{ $product->description }}</textarea>
<input name="price" type="number" value="{{ $product->price }}" step="0.01"/>
<input name="category" value="{{ $product->category }}"/>
<input name="stock" type="number" value="{{ $product->stock }}"/>
<input name="image" type="file"/>
<button>Update</button>
</form>
