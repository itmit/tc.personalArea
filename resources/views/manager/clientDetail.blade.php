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
                        Заявка на бронирование места {{ $item->place_id }} ({{ $item->first_name }} {{ $item->last_name }})
                        <div style="display: none" class="reservation-detail">
                            Текст
                        </div>
                    </li>
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