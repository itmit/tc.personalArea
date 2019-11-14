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
                    <li>Заявка на бронирование места {{ $reservation->place_id }}</li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection