@extends('layouts.cabinet')

@section('title', '| Добавить сайт')

@section('content')
    <div class="cnt">
        <div class="main-title">Добавить сайт</div>
        <form action="{{route('cabinet.sites.addPost')}}" method="post">
        {{csrf_field()}}
        <!-- row -->
            <div class="frm-row">
                <div class="frm-field half">
                    <label>Имя сайта</label>
                    <input type="text" name="name" value="{{old('name')}}">
                </div>
                <div class="frm-field half">
                    <label>Адрес сайта</label>
                    <input type="text" name="site" value="{{old('site')}}">
                </div>
            </div>
            <!-- row -->
            <div class="frm-row-submit">
                <input type="submit" value="Добавить">
            </div>
            <!-- /row -->
        </form>
    </div>
@endsection