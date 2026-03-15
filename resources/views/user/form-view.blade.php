@extends('user.layout')

@section('styles')
@endsection

@section('content')

<div class="page-title">
    <h3 class="color-dark">Просмотр формы</h3>
</div>
@include('includes.flash-messages')
<div class="d-flex justify-content-center form-view ">
    <div class="form-title">{{$form->title}}</div>
    <form>
        {!! $generated_form->content !!}
        <button class="button" type="submit">Зарегистрироваться</button>
    </form>
</div>


@endsection
