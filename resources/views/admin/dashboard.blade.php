<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>

    <h1>لوحة تحكم الأدمن</h1>

    <!-- زر إنشاء حساب عامل -->
    <a href="{{ route('users.create') }}">
        <button>إنشاء حساب عامل</button>
    </a>

    <br><br>

    <!-- زر تسجيل الخروج -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">تسجيل الخروج</button>
    </form>

</body>
</html>
