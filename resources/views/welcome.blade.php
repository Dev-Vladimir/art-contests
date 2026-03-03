<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid header d-flex justify-content-center align-items-center">
        <div class="header-nav d-flex container justify-content-between align-items-center">
                <ul class="d-flex">
                    <li><a href="{{route('home')}}">Главная</a></li>
                    <li><a href="{{route('about')}}">О системе</a></li>
                    <li><a href="{{route('contests.list')}}">Конкурсы</a></li>
                    <li><a href="{{route('news')}}">Новости</a></li>
                    <li><a href="{{route('contact')}}">Контакты</a></li>
                </ul>
            <div class="header-info">Сервисом пользуются 25 организаций!</div>
            <div class="header-login">
                <a class="login-button" href="{{ route('dashboard') }}"><i class="bi bi-person-fill"></i></a> 
            </div>
        </div>
    </div>
    <div class="d-flex container-fluid main-screen justify-content-center align-items-center">
        <div class="main-screen-title text-center">
            <h1>Электронная система <br>музыкальных конкурсов</h1>
            <span class="main-screen-title-desc">обработка заявок в мгновение ока</span>
        </div>
        <div class="d-flex justify-content-center main-screen-buttons">
            <a href="{{ route('register') }}" class="button bg-purple">Регистрация</a>
            <a href="{{route('user.contests.new')}}" class="button">Провести конкурс</a>
            <a href="#" class="button">Создать демо-аккаунт</a>
        </div>
    </div>
    <div class="container-fluid content">
        <div class="features">
            <h2>Принесите пользу своей организации!</h2>
            <div class="features-list d-flex">
                <div class="features-item d-flex">
                    <div class="features-item-icon"><i class="bi bi-hourglass-split"></i></div>
                    <div class="features-item-info">
                        <div class="features-item-title">Экономия времени</div>
                        <div class="features-item-desc">Получите готовое решение для обработки входящих заявок на конкурсы. Все максимально просто, прозрачно и без проблем в работе. Теперь не нужно долго искать нужную информацию в почте, чтобы сформировать список участников, достаточно просто нажать одну кнопку, и получить список в формате word-документа или же сразу распечатать его.</div>
                    </div>
                </div>
                <div class="features-item d-flex">
                    <div class="features-item-icon"><i class="bi bi-trophy"></i></div>
                    <div class="features-item-info">
                        <div class="features-item-title">Ваше преимущество</div>
                        <div class="features-item-desc">Нужно сформировать протокол для жюри с одними полями,
                    
                                а итоги совсем с другими? Не нужно копаться в документе,
                                достаточно просто выбрать нужные поля и распечатать
                                получившийся документ!
                        </div>
                    </div>
                </div>
                <div class="features-item d-flex">
                    <div class="features-item-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <div class="features-item-info">
                        <div class="features-item-title">Работайте эффективно</div>
                        <div class="features-item-desc">Сделайте работу ваших сотрудников проще и приятнее,
                    
                            освободите их время для другой работы и повысьте их
                            продуктивность. Они вам будут только благодарны!
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="work-process d-flex container-fluid">
            <div class="container-fluid">
                <h2>Как это работает</h2>
                <div class="work-process-items-list">
                    <div class="work-process-item f-flex justify-content-center">
                        <div class="title">Создайте конкурс</div>
                        <div class="desc">Нажмите на кнопку создания конкурса и введите его название</div>
                        <div class="img"><div class="arrow"></div></div>
                    </div>
                    <div class="work-process-item f-flex justify-content-center float-right">
                        <div class="title">Привяжите к нему форму</div>
                        <div class="desc">Создайте новую форму заявки 
    или выберите уже имеющуюся</div>
                        <div class="img"><div class="arrow left"></div></div>
                    </div>
                    <div class="work-process-item f-flex justify-content-center">
                        <div class="title">Сделайте конкурс активным</div>
                        <div class="desc">Поздравляем! Теперь можно наблюдать в меню конкурса, как добавляются новые участники и ловить благодарные взгляды своих заместителей!</div>
                        <div class="img"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="abilities">
            <h2>Дополнительные возможности</h2>
            <div class="abilities-list d-flex">
                <div class="abilities-item d-flex">
                    <div class="abilities-item-icon"><i class="bi bi-award-fill"></i></div>
                    <div class="abilities-item-info">
                        <div class="abilities-item-title">Сформируйте результаты</div>
                        <div class="abilities-item-desc">На основе таблицы участников сгенерируйте файл с результатами и добавьте его на страницу конкурса.</div>
                    </div>
                </div>
                <div class="abilities-item d-flex">
                    <div class="abilities-item-icon"><i class="bi bi-bar-chart-line"></i></div>
                    <div class="abilities-item-info">
                        <div class="abilities-item-title">Соберите статистику</div>
                        <div class="abilities-item-desc">Нужно узнать процент успешности выступлений учеников
вашей школы? Нет ничего проще! Сформируйте файл с отчетом на лету! .</div>
                    </div>
                </div>
                <div class="abilities-item d-flex">
                    <div class="abilities-item-icon"><i class="bi bi-table"></i></div>
                    <div class="abilities-item-info">
                        <div class="abilities-item-title">Добавьте таблицу с оценками</div>
                        <div class="abilities-item-desc">Загрузите фото протоколов на страницу результатов конкурса, чтобы каждый из участников мог ознакомиться с мнением комиссии.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid prices d-flex">
            <div class="container-fluid">
                <h2>Стоимость</h2>
                <div class="prices-list d-flex justify-content-between">
                    <div class="prices-item">
                        <div class="title">Базовый</div>
                        <div class="desc">до 3 конкурсов в месяц
доступ к разделу “результаты”
</div>
                        <div class="cost">300 руб/мес</div>
                        <a href="#" class="button button-dark-stroke">Создать аккаунт</a>
                    </div>
                    <div class="prices-item">
                        <div class="title">Продвинутый</div>
                        <div class="desc">до 6 конкурсов в месяц
доступ к разделу “результаты”
доступ к разделу “статистика”</div>
                        <div class="cost">600 руб/мес</div>
                        <a href="#" class="button button-dark-stroke">Создать аккаунт</a>
                    </div>
                    <div class="prices-item">
                        <div class="title">Ультра</div>
                        <div class="desc">безлимитное количество конкурсов
доступ к разделу “результаты”
доступ к разделу “статистика”
возможность загружать протоколы жюри</div>
                        <div class="cost">1000 руб/мес</div>
                        <a href="#" class="button button-dark-stroke">Создать аккаунт</a>
                    </div>
                </div>
                <h2>Сомневаетесь? Попробуйте месяц бесплатно!</h2>
                
                <div class="button-container"><div class="button button-dark-stroke">Создать демо-аккаунт</div></div>
                <h3 class="text-center">Повысить эффективность работы с конкурсами<br>
стало как никогда просто!</h3>
            </div>
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