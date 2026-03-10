@extends('user.layout')
@section('styles')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('content')
    <div class="container-fluid page-content text-center">
        <div class="page-title">
            <h3>Редактирование конкурса</h3>
        </div>
        <div class="d-flex justify-content-center form register-form">
            <form action="{{route('user.contests.edit', ['id' => $contest->id])}}" method="POST">
                @csrf
                <div class="form-input d-flex">
                    <div class="label">Название конкурса</div>
                    <div class="input"><input type="text" placeholder="Введите название конкурса" name="title" value="{{ $contest->title }}"/></div>
                    @error('title') <div class="error">{{$message}} </div>@enderror
                </div>
                <div class="form-input d-flex">
                    <div class="label">Привязанная форма</div>
                    <div class="input">
                        <select name="form_id">
                            @foreach($forms as $form)
                                <option value="{{ $form['id'] }}" @if($form['id'] == $contest->form_id) {{'checked'}} @endif> {{ $form['title'] }} </option>
                            @endforeach
                        </select>
                    </div>
                    @error('form_id') <div class="error"> {{$message}} </div>@enderror
                </div>
                <div class="form-input d-flex">
                    <div class="label">Группы</div>
                    <div class="input" id="groups-container">
                        @if(!empty($contest->groups))
                            @foreach(explode('|', $contest->groups) as $group)
                                <div class="group-item d-flex">
                                    <input type="text" name="groups[]" value="{{$group}}" class="form-control">
                                    <button type="button" class="remove-group"><i class="bi bi-trash3-fill"></i></button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="button" id="addGroup"><i class="bi bi-plus-circle-fill"></i>Добавить группу</button>
                    @error('groups') <div class="error">{{$message}} </div>@enderror
                </div>
                <div class="form-input d-flex">
                    <div class="label">Номинации</div>
                    <div class="input" id="nominations-container">
                        @if(!empty($contest->nominations))
                            @foreach(explode('|', $contest->nominations) as $nomination)
                                <div class="nomination-item d-flex">
                                    <input type="text" name="nominations[]" value="{{$nomination}}" class="form-control">
                                    <button type="button" class="remove-group"><i class="bi bi-trash3-fill"></i></button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="button" id="addNomination"><i class="bi bi-plus-circle-fill"></i>Добавить номинацию</button>
                    @error('nominations') <div class="error">{{$message}} </div>@enderror
                </div>
                
                <button type="submit">Обновить конкурс</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset('js/edit-contest.js')}}"></script>
@endsection