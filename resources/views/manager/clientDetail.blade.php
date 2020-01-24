@extends('layouts.adminApp')

@section('content')

    <h1>Клиент {{ $client->phone }}</h1>
    <div class="col-sm-12">
        <a href="{{ url()->previous() }}">Назад</a>
    </div>
    <div class="col-sm-12">
        <div>
            Рейтинг клиента: {{ $client->rating }}
        </div>
        <div>
            Телефон клиента: {{ $client->phone }}
        </div>
        <div>
            Заявки на бронирование:
            <ul>
                @foreach ($reservation as $item)
                    <li class="reservation-item" style="cursor: pointer">
                        Заявка на бронирование места id {{ $item->place_id }} 
                        <div style="display: none" class="reservation-detail">
                            <div>
                                Имя: {{ $item->first_name }} {{ $item->last_name }}
                            </div>
                            <div>
                                <?php $place = $item->place();?>
                                Место <b>{{ $place->place_number }}</b> ряд <b>{{ $place->row }}</b> этаж <b>{{ $place->floor }}</b> блок <b>{{ $place->block }}</b>
                            </div>
                            <div>
                                История заявки:
                                <ul>
                                    @foreach ($reservationHistory as $history)
                                    <li>
                                        <?php $action = $history->action();?>
                                        {{$action->action}} (изменение рейтинга: {{ $action->points }}) в {{ $history->created_at->timezone('Europe/Moscow') }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </li>
                    <hr>
                @endforeach
            </ul>
        </div>
    </div>
    <script>
        $(document).ready(function()
        {
            $(document).on('click', '.reservation-item', function() {
                $(this).find('.reservation-detail').show();
            })
        })
    </script>
@endsection