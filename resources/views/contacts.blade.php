@extends('layouts.cabinet')

@section('title', '| Контакты')

@section('content')
    <div class="cnt">
        <h1>Контакты</h1>
        <!-- contacts box -->
        <div class="contacts-box">
            <!-- item -->
            <div class="item-wrap">
                <a href="skype:{{config('skype')}}" class="item-contact">
                    <span class="contact-ico"><span class="i i-ico-skype"></span></span>
                    {{config('skype')}}
                </a>
            </div>
            <!-- /item -->
            <!-- item -->
            <div class="item-wrap">
                <a href="icq:{{config('icq')}}" class="item-contact">
                    <span class="contact-ico"><span class="i i-ico-icq"></span></span>
                    {{config('icq')}}
                </a>
            </div>
            <!-- /item -->
        </div>
        <!-- /contacts box -->
    </div>
@endsection