@extends('user.layout')

@section('content')
<form action="{{ route('user.delete') }}" method="POST">
    @csrf
    Вы уверены?
    <button type="submit" class="button bg-red">Удалить</button>
</form>
@endsection