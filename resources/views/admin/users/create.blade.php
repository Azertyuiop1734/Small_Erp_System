<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>إضافة عامل جديد</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if($errors->any())
    <div style="color:red">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('users.store') }}">
    @csrf

    <label>الاسم</label><br>
    <input type="text" name="name"><br><br>

    <label>البريد الإلكتروني</label><br>
    <input type="email" name="email"><br><br>

    <label>كلمة المرور</label><br>
    <input type="password" name="password"><br><br>

    <label>الراتب</label><br>
    <input type="number" name="salary" step="0.01"><br><br>

    <label>تاريخ التوظيف</label><br>
    <input type="date" name="hire_date"><br><br>

    <button type="submit">إنشاء عامل</button>
</form>

</body>
</html>