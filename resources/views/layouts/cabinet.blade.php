<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/reset.css')}}" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    @stack('head_style')
    <!--[if lte IE 8]><link href= "{{asset('css/ie.css')}}" rel= "stylesheet" media= "all" /><![endif]-->
    <!--[if lt IE 9]>
    <script src="{{asset('js/html5shiv.min.js')}}"></script>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <![endif]-->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
    <script src="{{asset('js/jquery.placeholder.min.js')}}"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    @stack('head_scripts')
    <link rel="icon" type="image/vnd.microsoft.icon" href="{{asset('favicon.ico')}}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
</head>

<body>
<!-- wrap -->
<div class="wrap">
    <!-- header -->
    <header class="header">
        <div class="inner-wrap">
            <div class="logo-wrap">
                <a href="" class="logo">
                    <img src="{{asset('img/main/logo.png')}}" alt="">
                </a>
            </div>
            <div class="main-actions-wrap">
                <ul>
                    <li class="balance"><a href="{{route('cabinet.balance')}}">{{number_format(Auth::user()->balance, 2, ',', ' ')}} ₽</a>
                    </li>
                    <li class="user"><a href="{{route('cabinet.profile')}}">{{Auth::user()->username}}</a>
                    </li>
                    @if(Auth::user()->is_admin)
                    <li><a href="/{{config('admin.route.prefix')}}">Админ</a>
                    </li>
                    @endif
                    <li class="exit"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- /header -->
    <!-- page -->
    <div class="page">
        <!-- content -->
        <div class="content">
            @include('blocks.messages')
            @yield('content')
        </div>
        <!-- /content -->
        <!-- side -->
        @include('blocks.side-bar')
        <!-- /side -->
    </div>
    <!-- /page -->
</div>
<!-- /wrap -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
@stack('scripts')
</body>
</html>