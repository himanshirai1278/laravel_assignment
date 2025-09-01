<a href="{{ route('admin.products.create') }}">Create</a>
<ul>
@foreach($products as $p)
<li>
{{ $p->name }} - ₹{{ number_format($p->price,2) }}
<a href="{{ route('admin.products.edit',$p) }}">Edit</a>
<form method="POST" action="{{ route('admin.products.destroy',$p) }}">
@csrf @method('DELETE')
<button>Delete</button>
</form>
</li>
@endforeach
</ul>
{{ $products->links() }}
