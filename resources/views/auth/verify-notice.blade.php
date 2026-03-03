<!DOCTYPE html>
<html>
<head>
    <title>Подтверждение email</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 50px auto; text-align: center; }
        .alert-success { color: green; }
        .alert-error { color: red; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Подтвердите ваш email</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">{{ $errors->first('email') }}</div>
    @endif

    <p>На ваш адрес <strong>{{ session('email') ?? old('email') ?? '' }}</strong> отправлено письмо с ссылкой для подтверждения.</p>
    <p>Если вы не получили письмо, вы можете запросить его повторно.</p>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <label for="email">Введите ваш email:</label>
        <input type="email" name="email" id="email" required value="{{ old('email') }}">
        <button type="submit">Отправить повторно</button>
    </form>

    <p><a href="{{ route('login') }}">Вернуться на страницу входа</a></p>
</body>
</html>