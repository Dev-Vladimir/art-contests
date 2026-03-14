@extends('user.contests.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/contest-view.css') }}">
@endsection

@section('content')
    <div class="contest-info">
        <h3 class="contest-title">{{ucfirst($contest->title)}}</h3>

        @include('includes.flash-messages')
        
        <div class="contest-active d-flex">
            <div class="title">Активность конкурса: {{$contest->is_active ? 'Конкурс активен' : 'Неактивен'}}</div>
            @if($contest->is_active)
                <a href="{{route('user.contests.inactivate', ['id' => $contest->id])}}" class="button bg-purple">Завершить конкурс</a>
            @else
                <a href="{{route('user.contests.activate', ['id' => $contest->id])}}" class="button bg-purple">Начать конкурс</a>
            @endif
        </div>
        <div class="contest-open d-flex">
            <div class="title">Прием заявок: {{$contest->open ? 'открыт' : 'закрыт'}}</div>
            @if($contest->open)
                <a href="{{ route('user.contests.close', ['id' => $contest->id])}}" class="button bg-purple">Закрыть прием заявок</a>
            @else
                <a href="{{ route('user.contests.open', ['id' => $contest->id]) }}" class="button bg-purple">Открыть прием заявок</a>
            @endif
        </div>
        <div class="d-flex contest-info-content">
            <div class="participants d-flex">
                <div class="title">Участники</div>
                <div class="count">Всего участников: 32</div>
                <a href="#" class="button stroke">Смотреть участников</a>
            </div>
            <div class="competition-form">
                <div class="title">Привязанная форма</div>
                <div class="form-name">{{$form->title}}</div>
                <a href="{{ route('user.forms.show', ['id' => $form->id]) }}" class="button stroke">Смотреть форму</a>
            </div>
        </div>
    </div>
@endsection