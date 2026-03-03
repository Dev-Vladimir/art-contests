@extends('user.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/contests-list.css') }}">
@endsection

@section('content')
    @if(session('error'))
        <h3>{{ session('error') }}</h3>
    @endif
    @if(session('success'))
        <h3>{{ session('success') }}</h3>
    @endif
    <div class="contests-list">
    @if(!empty($contests))
        @foreach ($contests as $contest)
            <div class="contest-preview">
                <div class="title">{{$contest['title']}}</div>
                <div class="edit-links d-flex">
                    <a href="{{route('user.contests.show', ['id' => $contest['id']])}}" class="button">Посмотреть</a>
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