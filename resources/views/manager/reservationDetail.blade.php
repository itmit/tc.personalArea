@extends('layouts.adminApp')

@section('content')

    <h1>Заявка на бронирование места</h1>
    <div class="col-sm-12">
        <a href="/reservation">Назад</a>
    </div>
    <div class="col-sm-12">
        <div>
            Заявку создал <a href="../client/{{ $reservation->client()->id }}">{{ $reservation->first_name }} {{ $reservation->last_name }}</a> тел. <i>{{ $reservation->client()->phone }}</i> в {{ date('H:i d.m.Y', strtotime($reservation->created_at->timezone('Europe/Moscow'))) }}
        </div>
        <div>
            Место <b>{{ $reservation->place()->place_number }}</b> ряд <b>{{ $reservation->place()->row }}</b> этаж <b>{{ $reservation->place()->floor }}</b> блок <b>{{ $reservation->place()->block }}</b>
        </div>
        <div>
            <h2>Текущий статус заявки: <i>
                @if($lastAction->action()->type == "reservation")
                {{ $lastAction->action()->action }} на {{ $lastAction->timer }} ч.
                @else
                {{ $lastAction->action()->action }}
                @endif
            </i></h2>
            @if($lastAction->action()->type == "reservation")
                <h3>Осталось: <span class="reservation-time-left" data-timer="{{ $ends_at }}"></span> м</h3>
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
                    @if($action->action == 'создание')
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
        </div>
        <br>
        <div>
            История заявки
            <ul>
                @foreach ($history as $item)
                    <li>{{$item->action()->action}} (изменение рейтинга: {{ $item->action()->points }}) в {{ $item->created_at->timezone('Europe/Moscow') }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(function()
        {
            $(document).on('click', '.changeReservationStatus', function() {
                let new_status = $("[name='new-status']").val();
                let reservation_id = $(this).data('reservationId');
                let client_id = $(this).data('clientId');
                let place_id = $(this).data('placeId');
                let timer = $('.timer').val();
                $.ajax({
                    headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    data: {new_status: new_status, reservation_id: reservation_id, client_id: client_id, place_id: place_id, timer: timer},
                    url     : 'changeReservationStatus',
                    method    : 'post',
                    success: function (response) {
                        location.reload();
                    },
                    error: function (xhr, err) { 
                        console.log(err + " " + xhr);
                    }
                });
            })

            $(document).on('change', '.new-status', function() {
                let v = $('.new-status').val();
                let new_status = $('.new-status option[value='+v+']').data('action');
                if(new_status == 'reservation')
                {
                    $('.reservation-time').show();
                }
                else
                {
                    $('.reservation-time').hide();
                }
            })

            let date = new Date($.now());
            console.log(date);
        })
    </script>

@endsection