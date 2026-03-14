<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @hassection('styles')
        @yield('styles')
    @endif
    <title>Document</title>
</head>
<body>
    <div class="container-fluid header d-flex justify-content-center align-items-center">
        <div class="container header-top d-flex justify-content-between">
            <div class="page-title">
                <h3>Личный кабинет</h2>
            </div>
            <div class="header-login">
                <a class="login-button" href="{{route('logout')}}"><i class="bi bi-box-arrow-right"></i></a> 
            </div>
        </div>
        <div class="container d-flex justify-content-between profile-info">
            <div class="profile-name">{{$user->name}}</div>
            <div class="profile-controls d-flex justify-content-between">
                <a href="#" class="button small bg-purple"><i class="bi bi-eye-fill"></i></a>
                <a href="{{ route('user.change-plan') }}" class="button small bg-purple">Сменить тарифный план</a>
                <a href="{{ route('user.edit')}}" class="button small bg-purple">Редактировать профиль</a>
                <a href="{{ route('user.delete') }}" class="button small attention-button">Удалить аккаунт</a>
            </div>
        </div>
    </div>
    <div class="container page-content">
        <div class="profile-nav">
            <ul class="d-flex justify-content-start">
                <li><a href="{{ route('home') }}">На главную</a></li>
                <li><a href="{{route('dashboard') }}">Профиль</a></li>
                <li><a href="{{route('user.contests.index') }}">Конкурсы</a></li>
                <li><a href="{{route('user.forms.index') }}">Формы</a></li>
                <li><a href="#">Результаты</a></li>
                <li><a href="#">Статистика</a></li>
                <li><a href="#">Обучение</a></li>
                <!-- <li><a href="{{ route('logout') }}">Выход</a></li> -->
            </ul>
        </div>
        <!-- <div class="main-controls d-flex">
            <a href="{{route('user.contests.new')}}" class="button violet">Добавить конкурс</a>
            <a href="{{route('user.forms.new')}}" class="button violet">Добавить форму</a>
        </div> -->
        @hassection('page_title')
        <h3 class="profile-title">@yield('page_title')</h3>
        @endif
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
    @yield('script')
</body>
</html>