@extends('layouts.adminApp')

@section('content')

    <h1 data-reservation-id="{{ $reservation->id }}">Заявка на бронирование места</h1>
    <div class="col-sm-12">
        <a href="/reservation">Назад</a>
    </div>
    <div class="col-sm-12">
        <div>
            Заявку создал <a href="../client/{{ $reservation->client()->id }}">{{ $reservation->first_name }} {{ $reservation->last_name }}</a> тел. <i>{{ $reservation->client()->phone }}</i> в {{ date('H:i d.m.Y', strtotime($reservation->created_at->timezone('Europe/Moscow'))) }}
        </div>
        <div>
            Место {{ $reservation->place()->place_number }} ряд {{ $reservation->place()->row }} этаж {{ $reservation->place()->floor }} блок {{ $reservation->place()->block }}
        </div>
        <div>
            <h2>Текущий статус заявки: {{ $lastAction->action()->action }}</h2>
            <select name="" id="">
                @foreach ($actions as $action)
                    @if($action->id == $lastAction->action()->id)
                        @continue
                    @endif
                    <option value="{{ $action->id }}">{{ $action->action }}</option>
                @endforeach
            </select>
            <br>
            <input type="button" value="Обновить статус" class="changeReservationStatus">
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

    <script>
        $(document).ready(function()
        {
            $(document).on('click', '.changeReservationStatus', function() {
                console.log('changeReservationStatus');
            })
        })
    </script>

@endsection