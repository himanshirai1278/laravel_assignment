<form method="POST" action="/admin/login">
@csrf
<h3>Admin Login</h3>
<input name="email" type="email" placeholder="Email"/>
<input name="password" type="password" placeholder="Password"/>
<button type="submit">Login</button>
</form>
