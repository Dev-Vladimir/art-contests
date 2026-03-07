<!DOCTYPE html>
<html>
<head>
    <title>Подтверждение смены email</title>
</head>
<body>
    <h1>Подтверждение смены email</h1>
    <p>Для подтверждения нового email адреса нажмите на ссылку:</p>
    <a href="{{ route('verify.email.change', ['token' => $user->email_verification_token]) }}">
        Подтвердить email
    </a>
</body>
</html>