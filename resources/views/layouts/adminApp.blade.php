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
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

<!-- Scripts -->
<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/nicEdit.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
{{-- <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script> --}}
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>


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

                    <li name="home"><a href="{{ route('auth.home') }}">Главная</a></li>

                    @ability('super-admin', 'show-manager-list')
                    <li name="managers"><a href="{{ route('auth.admin.managers.index') }}">Список менеджеров</a></li>
                    @endability

                    @ability('super-admin,manager', 'show-place-list')
                    <li name="places"><a href="{{ route('auth.manager.places.index') }}">Места</a></li>
                    @endability

                    @ability('super-admin,manager', 'show-reservation-places-list')
                    <li name="reservation"><a href="{{ route('auth.manager.reservation.index') }}">Заявки на бронь</a></li>
                    @endability

                    @ability('super-admin,manager', 'show-bid-for-sale-list')
                    <li name="bidForSale"><a href="{{ route('auth.manager.bidForSale.index') }}">Арендовать помещение</a></li>
                    @endability

                    @ability('super-admin,manager', 'show-purchase-requisition-list')
                    <li name="bidForBuy"><a href="{{ route('auth.manager.bidForBuy.index') }}">Сдать помещение</a></li>
                    @endability

                    @ability('super-admin', 'show-questions-list')
                    <li name="questions"><a href="{{ route('auth.manager.questions.index') }}">Переуступка прав пользования помещением</a></li>
                    @endability

                    @ability('super-admin', 'show-questions-list')
                    <li name="questions"><a href="{{ route('auth.manager.questions.index') }}">Приобретение прав пользования помещением</a></li>
                    @endability

                    @ability('super-admin,manager', 'show-purchase-requisition-list')
                    <li name="news"><a href="{{ route('auth.manager.news.index') }}">Новости</a></li>
                    @endability
                </ul>
            </div>
            <div class="col-xs-12 col-sm-9 tc-main-content">
                <h1>{{ $title ?? '' }}</h1>
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        let pathname = window.location.pathname;

        switch(pathname.split('/')[1]) {
        case '':
            $( "li[name='home']" ).addClass( "active" );
            break;

        case 'managers':
            $( "li[name='managers']" ).addClass( "active" );
            break;

        case 'places':
            $( "li[name='places']" ).addClass( "active" );
            break;

        case 'reservation':
            $( "li[name='reservation']" ).addClass( "active" );
            break;

        case 'bidForSale':
            $( "li[name='bidForSale']" ).addClass( "active" );
            break;

        case 'bidForBuy':
            $( "li[name='bidForBuy']" ).addClass( "active" );
            break;

        case 'questions':
            $( "li[name='questions']" ).addClass( "active" );
            break;

        case 'news':
            $( "li[name='news']" ).addClass( "active" );
            break;
        }
        

        $(document).on('click', '.js-destroy-button', function() {
            let ids = [];

            $(".js-destroy:checked").each(function(){
                ids.push($(this).data('placeId'));
            });
            
            console.log(ids);

            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data    : { ids: ids },
                url     : 'places/delete',
                method    : 'delete',
                success: function (response) {
                    console.log(response);
                    $(".js-destroy:checked").closest('tr').remove();
                    $(".js-destroy").prop("checked", "");
                },
                error: function (xhr, err) { 
                    console.log("Error: " + xhr + " " + err);
                }
            });

        });

        $(document).on('change', '#getPlacesByBlock', function() {
            let block = $('#getPlacesByBlock').val();
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data    : { block: block },
                url     : 'places/getPlacesByBlock',
                method    : 'post',
                success: function (data) {
                let result = '';
                if(data[0].length === 0)
                {
                    result += '<tr><td colspan="7">В выбранном разделе ничего нет</td></tr>'
                }
                else
                {
                    for(var i = 0; i < data[0].length; i++) {
                        
                        if(data[0][i]['status'] == 'Арендован')
                        {
                            result += '<tr style="background-color: #f7ecdd!important;">';
                        }
                        if(data[0][i]['status'] == 'Забронировано')
                        {
                            result += '<tr style="background-color: #ff8c00!important;">';
                        }
                        if(data[0][i]['status'] == 'Свободен')
                        {
                            result += '<tr>';
                        }
                        result += '<td><input type="checkbox" data-place-id="' + data[0][i]['id'] + '" name="destoy-place-' + data[0][i]['id'] + '" class="js-destroy"/></td>';
                        result += '<td><i class="material-icons"><a href="place/edit/' + data[0][i]['id'] + '">edit</a></i></td>';
                        result += '<td>' + data[0][i]['block'] + '</td>';
                        result += '<td>' + data[0][i]['floor'] + '</td>';
                        result += '<td>' + data[0][i]['row'] + '</td>';
                        result += '<td>' + data[0][i]['place_number'] + '</td>';
                        result += '<td>';
                        result += '<select name="changePlaceStatus" id="changePlaceStatus" class="form-control" data-placeid="'+data[0][i]['id']+'">';
                        
                        if(data[0][i]['status'] == 'Свободен')
                        {
                            result += '<option value="Свободен" selected>Свободен</option>';
                        }
                        else
                        {
                            result += '<option value="Свободен">Свободен</option>';
                        }
                        if(data[0][i]['status'] == 'Арендован')
                        {
                            result += '<option value="Арендован" selected>Арендован</option>';
                        }
                        else
                        {
                            result += '<option value="Арендован">Арендован</option>';
                        }
                        if(data[0][i]['status'] == 'Забронировано')
                        {
                            result += '<option value="Забронировано" selected>Забронировано</option>';
                        }
                        else
                        {
                            result += '<option value="Забронировано">Забронировано</option>';
                        }
                        result += '</select>';
                        result += '</td>';
                        if(data[0][i]['price'] == null)
                        {
                            result += '<td></td>';
                        }
                        else
                        {
                            result += '<td>' + data[0][i]['price'] + '</td>';
                        }
                        
                        result += '</tr>';
                    }
                }   
                $('tbody').html(result);
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        });


    });    
</script>
</body>
</html>
