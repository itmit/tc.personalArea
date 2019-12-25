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
    <div>
    <h2>Текущий статус заявки: <i>{{ $bid->status }}</i></h2>
        <select name="new-status"
        @if($bid->status == 'отказано' || $bid->status == 'успешно завершена')
            disabled title="Заявка закрыта и не может быть изменена"
        @endif
        class="form-control new-status">
            
        </select>
        <br>
        <input type="button" value="Обновить статус" class="changeReservationStatus" data-bid-id="{{ $bid->id }}"
        @if($bid->status == 'отказано' || $bid->status == 'успешно завершена')
            disabled title="Заявка закрыта и не может быть изменена"
        @endif>
    </div>
    <br>
    <div>
        История заявки
        <ul>
            {{-- @foreach ($history as $item)
                <li>{{$item->action()->action}} (изменение рейтинга: {{ $item->action()->points }}) в {{ $item->created_at->timezone('Europe/Moscow') }}</li>
            @endforeach --}}
        </ul>
    </div>
</div>

@endsection