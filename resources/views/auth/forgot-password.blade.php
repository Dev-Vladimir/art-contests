<!DOCTYPE html>
<html>
<head>
    <title>Восстановление пароля</title>
    <style>
        body { font-family: sans-serif; max-width: 400px; margin: 50px auto; }
        input { width: 100%; padding: 8px; margin: 10px 0; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Восстановление пароля</h1>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="error">{{ $errors->first('email') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <button type="submit">Отправить ссылку для сброса</button>
    </form>

    <p><a href="{{ route('login') }}">Вернуться на страницу входа</a></p>
</body>
</html>