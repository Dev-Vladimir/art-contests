@extends('user.dashboard')

@section('styles')
<link rel="stylesheet" href="{{asset('css/user-form.css')}}">
<link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('content')

<div class="page-title">
    <h3>Регистрация</h3>
</div>
<div class="d-flex justify-content-center form register-form">
    <form action="{{$route}}" method="POST" id="form">
        @csrf
        <div class="form-builder" id="form-builder">

            @isset($form_data)
                <div class="form-data" id="form-data">{{$form_data}}</div>
            @else
            <div class="form-input d-flex">
                <div class="label">Название формы</div>
                <div class="input"><input type="text" placeholder="введите имя" name='form_title' id="form_title"/></div>
            </div>
            <div class="form-settings" id="form-settings">
                
                
            </div>
            @endisset
            <button type="submit">Сохранить</button>
            </div>
        </form>
        
            <div class="form-preview" id="form-preview">
                   
            </div>
        
</div>


@endsection

@section('script')
<!-- <script src="{{asset('js/radio-to-toggle.js')}}"></script> -->
<script src="{{asset('js/edit-form-builder.js')}}"></script>
<script src="{{asset('js/edit-form-text.js')}}"></script>
<script src="{{asset('js/edit-form-textarea.js')}}"></script>
@endsection