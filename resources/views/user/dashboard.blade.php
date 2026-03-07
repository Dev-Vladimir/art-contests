@extends('user.layout')

@section('content')

@if(session('success'))
    <h1 class="message">{{ session('success') }}</h1>
@endif
@if(session('error'))
    <h1 class="message">{{ session('error') }}</h1>
@endif
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