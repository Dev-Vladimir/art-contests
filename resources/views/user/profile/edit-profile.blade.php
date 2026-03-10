<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <title>Обновление профиля</title>
</head>
<body>
    <div class="container-fluid header d-flex justify-content-center align-items-center">
        <h1>Электронная система музыкальных конкурсов</h1>
        <div class="header-nav d-flex container justify-content-center align-items-center">
            <ul class="d-flex">
                <li><a href="{{ route('home') }}">На главную</a></li>
                <li><a href="{{route('dashboard') }}">Профиль</a></li>
                <li><a href="{{route('user.contests.index') }}">Конкурсы</a></li>
                <li><a href="{{route('user.forms.index') }}">Формы</a></li>
                <li><a href="#">Результаты</a></li>
                <li><a href="#">Статистика</a></li>
                <li><a href="#">Обучение</a></li>
                <li><a href="{{ route('logout') }}">Выход</a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid page-content text-center">
        <div class="page-title">
            <h3>Обновление профиля</h3>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="d-flex justify-content-center form register-form">
            <form action="{{route('user.edit', $user)}}" method="POST">
                @csrf
                <div class="form-input d-flex">
                    <div class="label">Название организации</div>
                    <div class="input"><input type="text" placeholder="Сокращенное название организации" name="name" value="{{ $user->name }}"/></div>
                    @error('name') <div class="error">{{$message}} </div>@enderror
                </div>
                <div class="form-input d-flex">
                    <div class="label">Полное название Организации</div>
                    <!-- <div class="input"><input type="text" placeholder="Полное название Организации" /></div> -->
                    <div class="input"><textarea rows="5" name="full_name" value="{{ old('full_name') }}">{{ $user->full_name }}</textarea></div>
                    @error('full_name') <div class="error">{{$message}} </div>@enderror
                </div>
                <div class="form-input d-flex">
                    <div class="label">Адрес организации</div>
                    <div class="input"><input type="text" placeholder="Введите адрес организации" name="address" value="{{ $user->address }}"/></div>
                    @error('address') <div class="error">{{$message}} </div>@enderror
                </div>
                <div class="form-input d-flex">
                    <div class="label">Сайт организации</div>
                    <div class="input"><input type="text" placeholder="Введите адрес сайта организации" name="website" value="{{ $user->website }}"/></div>
                    @error('website') <div class="error">{{$message}} </div>@enderror
                </div>
                
                <div class="form-input d-flex">
                    <div class="label">Телефон</div>
                    <div class="input"><input type="text" placeholder="Введите телефон организации" name="phone" value="{{ $user->phone }}"/></div>
                    @error('phone') <div class="error">{{$message}} </div>@enderror
                </div>
                <button type="submit">Обновить профиль</button>
            </form>
        </div>
        <div class="d-flex justify-content-center form">
            <form action="{{route('user.edit-email', $user)}}" method="POST">
                @csrf
                <div class="form-input d-flex">
                    <div class="label">Email</div>
                    <div class="input"><input type="text" placeholder="Введите адрес электронной почты" name="email" value="{{ $user->email }}"/></div>
                    @error('email') <div class="error">{{$message}} </div>@enderror
                </div>
                <button type="submit">Обновить email</button>
                @if(Auth::user()->pending_email)
                    <div class="alert alert-info">
                        Ожидает подтверждения: {{ Auth::user()->pending_email }}
                        <form method="POST" action="{{ route('resend.email.change') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-link">Отправить повторно</button>
                        </form>
                    </div>
                @endif
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