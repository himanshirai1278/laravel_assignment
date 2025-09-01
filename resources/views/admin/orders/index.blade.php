<h3>Orders</h3>
<ul>
@foreach($orders as $o)
<li>#{{ $o->id }} - {{ $o->customer->name }} - {{ $o->status }} - ₹{{ $o->total }}
<form method="POST" action="{{ route('admin.orders.status',$o) }}">
@csrf @method('PATCH')
<select name="status">
<option {{ $o->status=='Pending'?'selected':'' }}>Pending</option>
<option {{ $o->status=='Shipped'?'selected':'' }}>Shipped</option>
<option {{ $o->status=='Delivered'?'selected':'' }}>Delivered</option>
</select>
<button>Update</button>
</form>
</li>
@endforeach
</ul>
{{ $orders->links() }}
