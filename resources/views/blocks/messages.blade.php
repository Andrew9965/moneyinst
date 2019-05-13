@if (count($errors) > 0)
    <div class="alert alert-danger cnt" style="background-color: #fde4e4;padding: 20px 0 1px 30px;margin-bottom: 20px;min-height:auto;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('status'))
    <div class="alert alert-danger cnt" style="background-color: #e5ffed;padding: 20px 0 20px 30px;margin-bottom: 20px;min-height:auto;">
        {{ session('status') }}
    </div>
@endif