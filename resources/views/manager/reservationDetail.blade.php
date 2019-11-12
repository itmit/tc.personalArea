@extends('layouts.adminApp')

@section('content')

    <h1 data-reservation-id="{{ $reservation->id }}">Заявка на бронирование места</h1>
    <div class="col-sm-12">
        <a href="/reservation">Назад</a>
    </div>
    <div class="col-sm-12">
        <div>
            Заявку создал {{ $reservation->first_name }} {{ $reservation->last_name }} ({{ $reservation->client()->phone }}) в {{ date('H:i:s d.m.Y', strtotime($reservation->created_at->timezone('Europe/Moscow'))) }}
        </div>
        <div>
            История заявки
            <ul>
                @foreach ($history as $item)
                    <li>{{$item->action()->action}}</li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection