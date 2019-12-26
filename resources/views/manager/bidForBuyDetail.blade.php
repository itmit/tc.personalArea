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
            <option value="в работе">в работе</option>
            <option value="отказано">отказано</option>
            <option value="успешно завершена">успешно завершена</option>
        </select>
        <input type="text" name="message" class="form-control" placeholder=" введите поясняющее сообщение" @if($bid->status == 'отказано' || $bid->status == 'успешно завершена')
        disabled title="Заявка закрыта и не может быть изменена"
        @endif>
        <br>
        <input type="button" value="Обновить статус" class="changeBidStatus" data-bid-id="{{ $bid->id }}"
        @if($bid->status == 'отказано' || $bid->status == 'успешно завершена')
            disabled title="Заявка закрыта и не может быть изменена"
        @endif>
    </div>
    <br>
    <div>
        История заявки
        <ul>
            @foreach ($history as $item)
                <li>{{$item->status}} @if(!$item->text) без сообщения @else с сообщением '{{$item->text}}' @endif в {{ $item->created_at->timezone('Europe/Moscow') }}</li>
            @endforeach
        </ul>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        $(document).on('click', '.changeBidStatus', function() {
            let status = $("[name='new-status']").val();
            let bidId = $(this).data('bidId');
            let text = $("[name='message']").val();
            console.log(status + ' ' + bidId + ' ' + text);
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data: {status: status, bidId: bidId, text: text},
                url     : 'changeBidStatus',
                method    : 'post',
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        })
    })
</script>
@endsection