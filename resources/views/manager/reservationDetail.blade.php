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
            Место {{ $reservation->place()->place_number }} ряд {{ $reservation->place()->row }} этаж {{ $reservation->place()->floor }} блок {{ $reservation->place()->block }}
        </div>
        <div>
            <h2>Текущий статус заявки: <i>{{ $lastAction->action()->action }}</i></h2>
            <select name="new-status" 
            @if($reservation->accepted == 2)
                disabled
            @endif>
                @foreach ($actions as $action)
                    @if($action->id == $lastAction->action()->id)
                        @continue
                    @endif
                    <option value="{{ $action->id }}">{{ $action->action }}</option>
                @endforeach
            </select>
            <br>
            <input type="button" value="Обновить статус" class="changeReservationStatus" data-reservation-id="{{ $reservation->id }}">
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
                let new_status = $("[name='new-status']").val();
                let reservation_id = $(this).data('reservationId');
                $.ajax({
                    headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    data: {new_status: new_status, reservation_id: reservation_id},
                    url     : 'changeReservationStatus',
                    method    : 'post',
                    success: function (response) {
                        // location.reload();
                        console.log(response);
                        // $('#' + user_id).remove();
                    },
                    error: function (xhr, err) { 
                        console.log(err + " " + xhr);
                    }
                });
            })
        })
    </script>

@endsection