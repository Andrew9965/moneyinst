<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
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
    <!--[if lte IE 8]><link href= "{{asset('css/ie.css')}}" rel= "stylesheet" media= "all" /><![endif]-->
    <!--[if lt IE 9]>
    <script src="{{asset('js/html5shiv.min.js')}}"></script>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <![endif]-->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
    <script src="{{asset('js/jquery.placeholder.min.js')}}"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <link rel="icon" type="image/vnd.microsoft.icon" href="{{asset('favicon.ico')}}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
</head>

<body>
<!-- wrap -->
<div class="wrap wrap-form">
    <!-- header -->
    <header class="header-form">
        <div class="inner-wrap">
            <div class="logo-wrap">
                <a href="" class="logo">
                    <img src="{{asset('img/main/logo-form.png')}}" alt="">
                </a>
            </div>
            <div class="contacts-wrap">
                <div class="item-wrap">
                    <a href="skype:{{config('skype')}}" class="item-contact">
                        <span class="contact-ico"><span class="i i-ico-skype02"></span></span>
                        {{config('skype')}}
                    </a>
                </div>
                <div class="item-wrap">
                    <a href="icq:{{config('icq')}}" class="item-contact">
                        <span class="contact-ico"><span class="i i-ico-icq02"></span></span>
                        {{config('icq')}}
                    </a>
                </div>
            </div>
            <div class="menu-wrap js-popup-wrap">
                <a href="" class="btn-action-menu js-btn-toggle"></a>
                <div class="menu-block js-popup-block">
                    <ul>
                        <li><a href="{{ route('register') }}">Регистрация</a>
                        </li>
                        <li><a href="{{ route('password.request') }}">Восстановить пароль</a>
                        </li>
                        <li><a href="{{ route('login') }}">Вход</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- /header -->
    <!-- form -->
    @yield('content')
    <!-- /form -->
</div>
<!-- /wrap -->
</body>

</html>