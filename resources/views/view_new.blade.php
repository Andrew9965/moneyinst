@extends('layouts.cabinet')

@section('title', '| '.$new->category->title.' | '.$new->title)

@section('content')
    <div class="cnt">
        {!! $new->content !!}
    </div>
@endsection