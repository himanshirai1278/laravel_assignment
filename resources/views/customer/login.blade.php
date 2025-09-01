<form method="POST" action="/login">
@csrf
<h3>Customer Login</h3>
<input name="email" type="email" placeholder="Email"/>
<input name="password" type="password" placeholder="Password"/>
<button type="submit">Login</button>
</form>
<a href="/register">Register</a>
