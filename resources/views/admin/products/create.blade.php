<form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}">
@csrf
<input name="name" placeholder="Name"/>
<textarea name="description" placeholder="Desc"></textarea>
<input name="price" type="number" step="0.01"/>
<input name="category" placeholder="Category"/>
<input name="stock" type="number"/>
<input name="image" type="file"/>
<button>Create</button>
</form>
