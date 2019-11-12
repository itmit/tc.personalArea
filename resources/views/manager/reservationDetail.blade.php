@extends('layouts.adminApp')

@section('content')

    <h1 data-reservation-id="{{ $reservation->id }}">Заявка на бронирование места</h1>
    <div class="col-sm-12">
        <a href="/reservation">Назад</a>
    </div>
    <div class="col-sm-12">
        <div>
            Заявку создал <a href="../client/{{ $reservation->client()->id }}">{{ $reservation->first_name }} {{ $reservation->last_name }}</a> <i>{{ $reservation->client()->phone }}</i> в {{ date('H:i:s d.m.Y', strtotime($reservation->created_at->timezone('Europe/Moscow'))) }}
        </div>
        <div>
            <h2>Текущий статус заявки: {{ $history->lastAction()->action }}</h2>
        </div>
        <div>
            История заявки
            <ul>
                @foreach ($history as $item)
                    <li>{{$item->action()->action}} (изменение рейтинга: {{ $item->action()->points }})</li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection