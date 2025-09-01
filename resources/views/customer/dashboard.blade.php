<h3>Customer Dashboard</h3>
<a href="/products">Browse Products</a>
<form method="POST" action="{{ route('customer.logout') }}">@csrf<button>Logout</button></form>
<div id="orders"></div>
<script src="/js/echo.js"></script>
<script>
window.listenOrderChannel && window.listenOrderChannel({{ auth('customer')->id() }});
</script>
