@php
    $rout = Route::currentRouteName();
@endphp
<div class="side">
    <!-- side menu wrap -->
    <div class="side-menu-wrap js-popup-wrap">
        <a href="" class="btn-action-menu js-btn-toggle"></a>
        <div class="menu-block js-popup-block">
            <ul>
                <li class="open">
                    <a href="">Основное</a>
                    <ul>
                        <li>
                            <a href="{{route('cabinet.sites')}}" class="clr01 {{$rout=='cabinet.sites' || $rout=='cabinet.sites.new' ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu01"></span></span>
                                Сайты
                            </a>
                        </li>
                        <li>
                            <a href="{{route('cabinet.statistic')}}" class="clr02 {{$rout=='cabinet.statistic' ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu02"></span></span>
                                Статистика
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="open">
                    <a href="">Инфо</a>
                    <ul>
                        <li>
                            <a href="{{route('cabinet.news')}}" class="clr03 {{$rout=='cabinet.news' || $rout=='cabinet.view_new' ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu03"></span></span>
                                Новости
                            </a>
                        </li>
                        <li>
                            <a href="{{route('cabinet.contacts')}}" class="clr04 {{$rout=='cabinet.contacts' ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu04"></span></span>
                                Контакты
                            </a>
                        </li>
                        <li>
                            <a href="{{route('cabinet.conditions')}}" class="clr05 {{$rout=='cabinet.conditions' ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu05"></span></span>
                                Условия
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{request()->scriptPages ? 'open':''}}">
                    <a href="">Скрипты для сайта</a>
                    <ul>
                        @foreach(\App\Models\ScriptPages::where('active', 1)->get() as $script_page)
                            <li>
                                <a href="{{route('cabinet.scripts', ['script' => $script_page->uri])}}" class="{{isset(request()->scriptPages) && request()->scriptPages->uri==$script_page->uri ? 'active':''}}">
                                    <span class="menu-ico"><span class="i i-ico-menu06"></span></span>
                                    {{$script_page->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="open">
                    <a href="">Сообщения</a>
                    <ul>
                        <li>
                            <a href="{{route('cabinet.messages.write')}}" class="clr07 {{$rout=='cabinet.messages.write' ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu07"></span></span>
                                Написать
                            </a>
                        </li>
                        <li>
                            <a href="{{route('cabinet.messages.inbox')}}" class="clr08 {{$rout=='cabinet.messages.inbox' || (isset($message) && $message->recipient_id==Auth::user()->id) ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu08"></span></span>
                                Входящие {{\App\Models\Messages::getCount()}}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('cabinet.messages.outbox')}}" class="clr09 {{$rout=='cabinet.messages.outbox' || (isset($message) && $message->sender_id==Auth::user()->id) ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu09"></span></span>
                                Отправленные
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="open">
                    <a href="">Пользователь</a>
                    <ul>
                        <li>
                            <a href="{{route('cabinet.profile')}}" class="clr10 {{$rout=='cabinet.profile' ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu10"></span></span>
                                Профиль
                            </a>
                        </li>
                        <li>
                            <a href="{{route('cabinet.balance')}}" class="clr11 {{$rout=='cabinet.balance' ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu11"></span></span>
                                Баланс
                            </a>
                        </li>
                        <li>
                            <a href="{{route('cabinet.payments')}}" class="clr12 {{$rout=='cabinet.payments' ? 'active':''}}">
                                <span class="menu-ico"><span class="i i-ico-menu12"></span></span>
                                Выплаты
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="clr13">
                                <span class="menu-ico"><span class="i i-ico-menu13"></span></span>
                                Выйти
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="main-actions-wrap">
                <ul>
                    <li class="balance"><a href="">{{Auth::user()->balance}} ₽</a>
                    </li>
                    <li class="user"><a href="">{{Auth::user()->username}}</a>
                    </li>
                    <li class="exit"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /side menu wrap -->
</div>