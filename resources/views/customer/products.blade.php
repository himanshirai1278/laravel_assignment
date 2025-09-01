<h3>Products</h3>
<form method="GET">
<input name="q" value="{{ request('q') }}" placeholder="Search"/>
<button>Search</button>
</form>
<ul>
@foreach($products as $p)
<li>
    <img src="{{ asset('storage/'.$p->image) }}" width="50"/>
    {{ $p->name }} - ₹{{ number_format($p->price,2) }}
    <form method="POST" action="{{ route('orders.place') }}">
    @csrf
    <input type="hidden" name="product_id" value="{{ $p->id }}"/>
    <input type="number" name="quantity" value="1" min="1"/>
    <button>Order</button>
    </form>
</li>
@endforeach
</ul>
{{ $products->links() }}
