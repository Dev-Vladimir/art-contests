@extends('guest.index')

@section('content')
    <div class="page-title"><h2>Конкурсы</h2></div>
    <div class="contests-list">
        @if(empty($contests))
            <h3>В данный момент нет ни одного ктивного конкурса</h3>
        @else
            @foreach($contests as $contest)
                <div class="contest-preview d-flex">
                    <div class="title">{{$contest->title}}</div>
                    <a href="{{ route('contest-register', ['id' => $contest->id]) }}" class="button">Зарегистрироваться</a>
                </div>
            @endforeach
        @endif
    </div>
@endsection