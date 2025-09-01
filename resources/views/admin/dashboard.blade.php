<h3>Admin Dashboard</h3>
<a href="/admin/products">Products</a> |
<a href="/admin/orders">Orders</a> |
<a href="/admin/import">Import</a>
<form method="POST" action="{{ route('admin.logout') }}">@csrf<button>Logout</button></form>
<div id="presence"></div>
<script src="/js/echo.js"></script>
<script>
window.initPresence && window.initPresence();
</script>
