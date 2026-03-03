<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="forms.css">
    <title>Это название страницы</title>
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
        
    @yield('content')
        
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