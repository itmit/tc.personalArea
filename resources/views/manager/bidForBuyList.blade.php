@extends('layouts.adminApp')

@section('content')
    @ability('super-admin', 'delete-bidForBuy')
    <div class="col-sm-12">
        <button type="button" class="btn btn-tc-manager js-destroy-button">Удалить отмеченные заявки</button>
    </div>
    @endability
    <table class="table table-bordered">
        <thead>
        <tr>
            <th><input type="checkbox" name="destroy-all-bidsForBuy" class="destroy-all-bidsForBuy"/></th>
            <th>Блок</th>
            <th>Этаж</th>
            <th>Ряд</th>
            <th>Место</th>
            <th>Имя продавца</th>
            <th>Номер телефона</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bids as $bid)
            <tr>
                <td><input type="checkbox" data-place-id="{{ $bid->place()->get()->first()->id }}" name="destoy-place-{{ $bid->place()->get()->first()->id }}" class="js-destroy-bidForBuy"/></td>
                <td>{{ $bid->place()->get()->first()->block }}</td>
                <td>{{ $bid->place()->get()->first()->floor }}</td>
                <td>{{ $bid->place()->get()->first()->row }}</td>
                <td>{{ $bid->place()->get()->first()->place_number }}</td>
                <td>{{ $bid->seller_name }}</td>
                <td>{{ $bid->phone_number }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

<script>
$(document).ready(function()
    {
        $(function(){
            $(".destroy-all-bidsForBuy").on("click", function() {
                console.log('s');
                if($(".destroy-all-bidsForBuy").prop("checked")){
                    $(".js-destroy-bidForBuy").prop("checked", "checked");
                }
                else{
                    $(".js-destroy-bidForBuy").prop("checked", "");
                }

            });
        });
    });
</script>
