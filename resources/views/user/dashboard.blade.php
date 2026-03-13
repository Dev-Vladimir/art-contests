@extends('user.layout')

@section('content')

@include('includes.flash-messages')

<div class="profile-details">
    <div class="profile-title">Основные сведения</div>
    <p>Полное название: {{ $user->full_name }}</p>
    <p>Сокращенное название: {{$user->name}}</p>
    <p>Адрес: {{ $user->address }}</p>
    <p>Телефон: {{ $user->phone }}</p>
    <p>email: {{ $user->email }}</p>
    <p>Сайт: {{ $user->website }}</p>
    <p>Проведено конкурсов: 20</p>
</div>
@endsection