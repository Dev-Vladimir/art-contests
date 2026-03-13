@if(session('success'))
    <div class="success">{{session('success')}}</div>
@endif
@if(session('error'))
    <div class="error">{{session('error')}}</div>
@endif