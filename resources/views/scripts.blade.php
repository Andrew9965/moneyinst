@extends('layouts.cabinet')

@section('title', '| '.$name)

@section('content')
    <div class="cnt">
        {!! $content !!}
    </div>
@endsection