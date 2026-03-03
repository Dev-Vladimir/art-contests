<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <title>Вход на сайт</title>
</head>
<body>
    <div class="container-fluid header d-flex justify-content-center align-items-center">
        <h1>Электронная система музыкальных конкурсов</h1>
        <div class="header-nav d-flex container justify-content-center align-items-center">
            <ul class="d-flex">
                <li><a href="{{route('home')}}">Главная</a></li>
                <li><a href="{{route('about')}}">О системе</a></li>
                <li><a href="{{route('contests.list')}}">Конкурсы</a></li>
                <li><a href="{{route('news')}}">Новости</a></li>
                <li><a href="{{route('contact')}}">Контакты</a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid page-content text-center">
        <div class="page-title">
            <h3>Авторизация</h3>
        </div>
        
        <div class="d-flex justify-content-center form">
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="form-input d-flex">
                    <div class="label">Логин</div>
                    <div class="input"><input type="text" placeholder="введите имя" name="email"/></div>
                </div>
                <div class="form-input d-flex">
                    <div class="label">Пароль</div>
                    <div class="input"><input type="password" placeholder="введите пароль" name="password"/></div>
                </div>
                <button type="submit">Войти</button>
                @if($errors->any())
                    <div class="error error-message">
                        <li>{{ $errors->first() }}</li>
                    </div>
                @endif      
                <div class="form-links d-flex justify-content-between">
                    <a href="{{route('register')}}">Создать аккаунт</a>
                    <a href="{{route('password.request')}}">Восстановление пароля</a>
                </div>
            </form>
        </div>
    </div>
    <div class="container-fluid footer">
        <div class=" container d-flex justify-content-center">
            <div class="footer-nav">
                <ul class="d-flex">
                    <li><a href="{{route('home')}}">Главная</a></li>
                    <li><a href="{{route('about')}}">О системе</a></li>
                    <li><a href="{{route('contests.list')}}">Конкурсы</a></li>
                    <li><a href="{{route('news')}}">Новости</a></li>
                    <li><a href="{{route('contact')}}">Контакты</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy 2025<br>
Электронная система музыкальных конкурсов<br>
Все права защищены
        </div>
    </div>
    
</body>
</html>