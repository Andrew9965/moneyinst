@extends('layouts.cabinet')

@section('title', '| Новости')

@section('content')
    <div class="cnt">
        <h1>Новости</h1>

        <!-- news box -->
        <div class="news-box">
            @foreach($news as $new)
            <div class="item-new">
                <div class="new-title"><a href="{{route('cabinet.view_new', ['category' => $new->category->slug, 'new' => $new->slug])}}">{{$new->title}}</a>
                </div>
                <div class="new-info">{{$new->created_at}} <a href="{{route('cabinet.news', ['category' => $new->category->slug])}}" class="new-category">{{$new->category->title}}</a>
                </div>
            </div>
            @endforeach
        </div>
        @if(!count($news))
            <center><h1>Пусто</h1></center>
        @endif
        <!-- /news box -->
        {{ $news->links() }}
    </div>
@endsection