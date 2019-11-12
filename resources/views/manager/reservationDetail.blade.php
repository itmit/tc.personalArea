@extends('layouts.adminApp')

@section('content')

    <h1 data-reservation-id="{{ $reservation->id }}">Заявка на бронирование места</h1>
    <div class="col-sm-12">
        <a href="/reservation">Назад</a>
    </div>
    <div class="col-sm-12">
        <div>
            Заявку создал {{ $reservation->first_name $reservation->last_name}} ({{ $reservation->client()->phone }}) в {{ $reservation->created_at }}
        </div>
    </div>

@endsection