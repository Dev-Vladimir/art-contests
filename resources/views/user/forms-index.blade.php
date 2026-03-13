@extends('user.layout')


@section('styles')
<link rel="stylesheet" href="{{asset('css/forms-list.css')}}">
@endsection

@section('content')
    
@include('includes.flash-messages')

@if(!empty($forms))
    <div class="forms-list">
        @foreach ($forms as $form)
            <div class="form-preview">
                <div class="title">{{$form['title']}}</div>
                <div class="edit-links d-flex">
                    <a href="{{route('user.forms.show', ['id' => $form['id']])}}" class="button">Посмотреть</a>
                    <a href="{{route('user.forms.edit', ['id' => $form['id']])}}" class="button">Редактировать</a>
                    <a href="{{route('user.forms.delete', ['id' => $form['id']])}}" class="button">Удалить</a>
                </div>
            </div>
        
        @endforeach
    </div>
@else
    <h3>Пока нет ни одной формы</h3>
@endif
    <a href="{{ route('user.forms.new') }}" class="button">Добавить форму</a>
@endsection