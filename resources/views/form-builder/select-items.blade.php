<div class="form-input">
    <div class="label">Выберите {{$select_name == 'nominations' ? 'номинацию' : 'группу'}}</div>
    <div class="input">
        <select name="{{$select_name}}" id="">
            @foreach($select_items as $item)
                <option value="{{$item}}">{{$item}}</option>
            @endforeach
        </select>
    </div>
</div>
