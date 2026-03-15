@extends('user.layout')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@section('styles')

@endsection

@section('content')
    <div class="container-fluid page-content text-center">
        <div class="page-title">
            <h3>Создание нового конкурса</h3>
        </div>
        @include('includes.flash-messages')
        <div class="d-flex justify-content-center form register-form">
            @if (empty($forms))
                <div>
                    <h3>Вы не можете создать конкурс, пока не добавите хотя бы одну форму</h3>
                    <a href="{{ route('user.forms.new') }}" class="button solid">Добавить форму</a>
                </div>
            @else
                <form action="{{route('user.contests.new')}}" method="POST">
                    @csrf
                    <div class="form-input d-flex">
                        <div class="label">Название конкурса</div>
                        <div class="input"><input type="text" placeholder="Введите название конкурса" name="title" value="{{ old('title') }}"/></div>
                        @error('title') <div class="error">{{$message}} </div>@enderror
                    </div>
                    <div class="form-input d-flex">
                        <div class="label">Привязанная форма</div>
                        <!-- <div class="input"><input type="text" placeholder="Полное название Организации" /></div> -->
                        <div class="input">
                            <select name="form_id">
                                @if(empty($forms))
                                    <span>Пока не ни одной формы</span>
                                    <a href="{{ route('user.forms.new') }}" class="button">Создать форму</a>
                                @else
                                    @foreach($forms as $form)
                                        <option value="{{ $form['id'] }}"> {{ $form['title'] }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('form_id') <div class="error"> {{$message}} </div>@enderror
                    </div>
                    <div class="form-input d-flex">
                        <div class="label">Группы</div>
                        <div class="input" id="groups-container">
                            <div class="groups-item d-flex">
                            
                            </div>
                        </div>
                        <button type="button" class="button" id="addGroup"><i class="bi bi-plus-circle-fill"></i>Добавить группу</button>
                        @error('groups') <div class="error">{{$message}} </div>@enderror
                    </div>
                    <div class="form-input d-flex">
                        <div class="label">Номинации</div>
                        <div class="input" id="nominations-container">
                            <div class="nomination-item d-flex">
                            
                            </div>
                        </div>
                        <button type="button" class="button" id="addNomination"><i class="bi bi-plus-circle-fill"></i>Добавить номинацию</button>
                        @error('nominations') <div class="error">{{$message}} </div>@enderror
                    </div>
                    
                    <button type="submit">Создать</button>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset('js/edit-contest.js')}}"></script>
@endsection