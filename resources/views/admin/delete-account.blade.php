@extends('user.layout')

@section('content')
<form action="{{ route('user.delete', ['id' => $user_delete->id]) }}" method="POST">
    @csrf
    Вы уверены?
    <button type="submit" class="button bg-red">Удалить</button>
</form>
@endsection