<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">


</head>
<body>
<div id="app">
   
    <nav class="navbar navbar-tc navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
<!--                    <img src="/tc.itmit-studio.ru/resources/views/layouts/img/mLogo.png" alt="TC" title="Садовод">-->
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <button type="button" class="btn btn-tc dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false" aria-haspopup="true" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </button>

<!-- Single button -->
<!--
<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Действие <span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="#">Действие</a></li>
    <li><a href="#">Другое действие</a></li>
    <li><a href="#">Что-то иное</a></li>
    <li class="divider"></li>
    <li><a href="#">Отдельная ссылка</a></li>
  </ul>
</div>
-->

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Выход
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
                
            </div>
        </div>
    </nav>
    

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3 tc-left-menu">
                <ul class="nav">

                    <li class="active"><a href="{{ route('auth.home') }}">Главная</a></li>

                    @ability('super-admin', 'show-manager-list')
                    <li><a href="{{ route('auth.admin.managers.index') }}">Список менеджеров</a></li>
                    @endability

                    @ability('super-admin,manager', 'show-place-list')
                    <li><a href="{{ route('auth.manager.places.index') }}">Места</a></li>
                    @endability

                    @ability('super-admin,manager', 'show-bid-for-sale-list')
                    <li><a href="{{ route('auth.manager.bidForSale.index') }}">Заявки на продажу</a></li>
                    @endability

                    @ability('super-admin,manager', 'show-purchase-requisition-list')
                    <li><a href="{{ route('auth.manager.bidForBuy.index') }}">Заявки на покупку</a></li>
                    @endability

                    @ability('super-admin,manager', 'show-purchase-requisition-list')
                    <li><a href="{{ route('auth.manager.news.index') }}">Новости</a></li>
                    @endability
                </ul>
            </div>
            <div class="col-xs-12 col-sm-9 tc-main-content">
                <h1>{{ $title }}</h1>
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
        <!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/nicEdit.js') }}" type="text/javascript"></script>
{{-- <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script> --}}
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
</body>
</html>
