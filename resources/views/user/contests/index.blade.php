@extends('user.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/contests-list.css') }}">
@endsection

@section('page_title', 'Конкурсы')

@section('content')
    
    @include('includes.flash-messages')

    <div class="contests-list">
    @if(!empty($contests))
        @foreach ($contests as $contest)
            <div class="contest-preview">
                <div class="title">{{ucfirst($contest['title'])}}</div>
                <div class="edit-links d-flex">
                    <a href="{{route('user.contests.show', ['id' => $contest['id']])}}" class="button">Посмотреть</a>
                    @if($contest['is_active'])
                        <a href="{{route('user.contests.inactivate', ['id' => $contest['id']])}}" class="button">Завершить</a>
                    @else
                        <a href="{{route('user.contests.activate', ['id' => $contest['id']])}}" class="button">Начать конкурс</a>
                    @endif
                    @if($contest['open'])
                        <a href="{{route('user.contests.close', ['id' => $contest['id']])}}" class="button">Закрыть подачу заявок</a>
                    @else
                        <a href="{{route('user.contests.open', ['id' => $contest['id']])}}" class="button">Открыть подачу заявок</a>
                    @endif
                    <a href="{{route('user.contests.edit', ['id' => $contest['id']])}}" class="button">Редактировать</a>
                    <a href="{{route('user.contests.delete', ['id' => $contest['id']])}}" class="button">Удалить</a>
                </div>
            </div>
        
        @endforeach
    @else
        <h3>Пока нет ни одного конкурса</h3>
    @endif
    <a href="{{route('user.contests.new')}}" class="button">Создать конкурс</a>
    </div>
@endsection