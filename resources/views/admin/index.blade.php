@extends('admin.dashboard')

@section('content')
    @if(session('success'))
        <h3>{{ session('success') }}</h3>
    @endif
    @if(session('error'))
        <h3>session('error')</h3>
    @endif
    <h3>Пользователи</h3>
    <div class="users-list">
    @forelse($users_list as $item)
        <div class="user-preview d-flex justify-content-between">
            <div class="name">{{$item->name}}</div>
            <div class="edit-links d-flex">
                <a href="{{route('dashboard', ['id' => $item->id])}}" class="button">Посмотреть профиль</a>
                <a href="{{route('user.edit', ['id' => $item->id])}}" class="button">Редактировать</a>
                <a href="{{route('user.delete', ['id' => $item->id])}}" class="button">Удалить</a>
            </div>
        </div>
    @empty
        <h3>Пока нет ни одного пользователя</h3>
    @endforelse
    </div>
@endsection