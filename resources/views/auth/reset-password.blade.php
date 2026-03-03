<!DOCTYPE html>
<html>
<head>
    <title>Сброс пароля</title>
    <style>
        body { font-family: sans-serif; max-width: 400px; margin: 50px auto; }
        input { width: 100%; padding: 8px; margin: 10px 0; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Установите новый пароль</h1>

    @if($errors->any())
        <div class="error">{{ $errors->first('email') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ $email }}" required readonly>
        </div>

        <div>
            <label>Новый пароль:</label>
            <input type="password" name="password" required autofocus>
        </div>

        <div>
            <label>Подтвердите пароль:</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Сбросить пароль</button>
    </form>
</body>
</html>