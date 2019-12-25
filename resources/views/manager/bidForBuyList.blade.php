@extends('layouts.adminApp')

@section('content')
    @ability('super-admin', 'delete-bidForBuy')
    <div class="col-sm-12">
        <button type="button" class="btn btn-tc-manager js-destroy-bidsForBuy-button">Удалить отмеченные заявки</button>
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
            <th>Текст</th>
        </tr>
        </thead>
        <tbody>
            <?
            $place = null;
        ?>
        @foreach($bids as $bid)
        <?
            $place = $bid->place()->get()->first();
        ?>
            <tr>
                <td><input type="checkbox" data-place-id="{{ $bid->id }}" name="destoy-place-{{ $bid->id }}" class="js-destroy-bidForBuy"/></td>
                <td><a href="bidForBuy/{{ $bid->id }}">{{ $place->block }}</a></td></td>
                <td>{{ $place->floor }}</td>
                <td>{{ $place->row }}</td>
                <td>{{ $place->place_number }}</td>
                <td>{{ $bid->seller_name }}</td>
                <td>{{ $bid->phone_number }}</td>
                <td>{{ $bid->text }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>
    $(document).ready(function()
        {
            $(function(){
                $(".destroy-all-bidsForBuy").on("click", function() {
                    if($(".destroy-all-bidsForBuy").prop("checked")){
                        $(".js-destroy-bidForBuy").prop("checked", "checked");
                    }
                    else{
                        $(".js-destroy-bidForBuy").prop("checked", "");
                    }
    
                });
            });

            $(document).on('click', '.js-destroy-bidsForBuy-button', function() {
            let ids = [];

            $(".js-destroy-bidForBuy:checked").each(function(){
                ids.push($(this).data('placeId'));
            });

            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data    : { ids: ids },
                url     : 'bidForBuy/delete',
                method    : 'delete',
                success: function (response) {
                    console.log(response);
                    $(".js-destroy-bidForBuy:checked").closest('tr').remove();
                    $(".js-destroy-bidForBuy").prop("checked", "");
                },
                error: function (xhr, err) { 
                    console.log("Error: " + xhr + " " + err);
                }
            });

        });

    });
    </script>

@endsection


