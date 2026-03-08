<form action="{{ route('admin.store') }}" method="POST">
@csrf

<input type="text" name="name" placeholder="Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Create Admin</button>

</form>