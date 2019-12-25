@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12">
    <a href="/bidForSale">Назад</a>
</div>
<div class="col-sm-12">
    <div>
        Заявку создал {{ $bid->seller_name }} тел. <i>{{ $bid->phone_number }}</i> в {{ date('H:i d.m.Y', strtotime($bid->created_at->timezone('Europe/Moscow'))) }}
    </div>
    <div>
        <?
            $place = $bid->place()->get()->first();    
        ?>
        Место <b>{{ $place->place_number }}</b> ряд <b>{{ $place->row }}</b> этаж <b>{{ $place->floor }}</b> блок <b>{{ $place->block }}</b>
        <p>
            {{ $bid->text }}
        </p>
    </div>
    {{-- <div>
        <h2>Текущий статус заявки: <i>
            @if($lastAction->action()->type == "reservation")
            {{ $lastAction->action()->action }} на {{ $lastAction->timer }} ч.
            @else
            {{ $lastAction->action()->action }}
            @endif
        </i></h2>
        @if($lastAction->action()->type == "reservation")
            <h3>Осталось: <span class="reservation-time-left" data-timer="{{ $ends_at }}"></span></h3>
        @endif
        <select name="new-status"
        @if($reservation->accepted == 2 || $reservation->accepted == 3)
            disabled title="Заявка закрыта и не может быть изменена"
        @endif
        class="form-control new-status">
            @foreach ($actions as $action)
                @if($action->id == $lastAction->action()->id)
                    @continue
                @endif
                @if($lastAction->action()->type == 'reservation' && $action->type == 'cancelBeforeReservation')
                    @continue
                @endif
                @if($lastAction->action()->type == 'create' && $action->type == 'cancelAfterReservation')
                    @continue
                @endif
                @if($action->type == 'create' || $action->type == 'cancelByExpiredTime')
                    @continue
                @endif
                <option value="{{ $action->id }}" data-action="{{ $action->type }}">{{ $action->action }}</option>
            @endforeach
        </select>
        <div class="reservation-time" style="display: none">
            Забронировать на
            <input type="number" min="1" max="72" name="timer" class="form-control timer" value="1">
            часов
        </div>
        <br>
        <input type="button" value="Обновить статус" class="changeReservationStatus" data-place-id="{{ $reservation->place()->id }}" data-reservation-id="{{ $reservation->id }}" data-client-id="{{ $reservation->client()->id }}"
        @if($reservation->accepted == 2 || $reservation->accepted == 3)
            disabled title="Заявка закрыта и не может быть изменена"
        @endif>
    </div> --}}
    <br>
    {{-- <div>
        История заявки
        <ul>
            @foreach ($history as $item)
                <li>{{$item->action()->action}} (изменение рейтинга: {{ $item->action()->points }}) в {{ $item->created_at->timezone('Europe/Moscow') }}</li>
            @endforeach
        </ul>
    </div> --}}
</div>

@endsection