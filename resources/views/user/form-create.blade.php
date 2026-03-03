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
                
                <!-- <div class="form-section">
                    <div class="form-section-heading d-flex justify-content-between">
                        <div class="menu"><span></span><span></span><span></span></div>
                        <div class="title">Название поля</div>
                        <div class="delete"><i class="bi bi-trash3-fill"></i></div>
                    </div>
                    <div class="form-section-settings" id="form-section-settings">

                        <div class="form-section-type d-flex">
                            <div class="label">Тип поля</div>
                            <select name="form_section_type" id="form_section_type_1">
                                <option value="text">Текст</option>
                                <option value="textarea">Текстовое поле</option>
                                <option value="select">Выбор</option>
                                <option value="file">Загрузка файла</option>
                            </select>
                            <div class="field-types d-flex justify-content-between">
                                <div class="field-types-button active">текст</div>
                                <div class="field-types-button">текстовое поле</div>
                                <div class="field-types-button">выбор</div>
                                <div class="field-types-button">загрузка файла</div>
                            </div>
                        </div>

                        <div class="form-input d-flex">
                            <div class="label">Название поля</div>
                            <div class="input"><input type="text" placeholder="введите имя" name='title' name="field-title"/></div>
                        </div>
                        <div class="form-input d-flex">
                            <div class="label">Служебное имя</div>
                            <div class="input"><input type="text" placeholder="введите имя" name='title' name="service-name"/></div>
                        </div>
                        <div class="form-input d-flex">
                            <div class="label">Подсказка</div>
                            <div class="input"><input type="text" placeholder="введите имя" name='title' name="message"/></div>
                        </div>
                        <div class="form-input d-flex">
                            <div class="label">Обязательно для заполнения</div>
                            <div class="input">
                                <div>
                                    <input type="radio" id="yes" name="required" value="yes" checked />
                                    <label for="yes">Да</label>
                                </div>

                                <div>
                                    <input type="radio" id="no" name="required" value="no" />
                                    <label for="no">Нет</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            @endisset
            <!-- <div class="button add-field" id="add-field"><i class="bi bi-plus"></i>добавить поле</div> -->
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