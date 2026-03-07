@extends('user.contests.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/contest-view.css') }}">
@endsection

@section('content')
    <div class="contest-info">
        <div class="contest-active d-flex">
            <div class="title">Активность конкурса: {{$contest->active ? 'Конкурс активен' : 'Неактивен'}}</div>
            @if($contest->active)
                <a href="{{user.contests.inactivate}}" class="button">Завершить конкурс</a>
            @else
                <a href="user.contests.activate" class="button">Начать конкурс</a>
            @endif
        </div>
        <div class="contest-open d-flex">
            <div class="title">Прием заявок: {{$contest->open ? 'открыт' : 'закрыт'}}</div>
            @if($contest->open)
                <a href="{{user.contests.close}}" class="button">Закрыть прием заявок</a>
            @else
                <a href="user.contests.open" class="button">Открыть прием заявок</a>
            @endif
        </div>
        <div class="d-flex">
            <div class="participants d-flex">
                <div class="title">Участники</div>
                <div class="count">Всего участников: 32</div>
                <a href="#" class="button stroke">Смотреть участников</a>
            </div>
            <div class="form">
                <div class="title">Привязанная форма</div>
                <div class="form-name">{{$form->title}}</div>
                <a href="{{ route('user.forms.show', ['id' => $form->id]) }}" class="button stroke">Смотреть форму</a>
            </div>
        </div>
    </div>
@endsection