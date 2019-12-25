@extends('layouts.adminApp')

@section('content')
    @ability('super-admin', 'delete-bidForSale')
        <div class="col-sm-12">
            <button type="button" class="btn btn-tc-manager js-destroy-bidsForSale-button">Удалить отмеченные заявки</button>
        </div>
    @endability

    <table class="table table-bordered">
        <thead>
        <tr>
            <th><input type="checkbox" name="destroy-all-bidsForSale" class="destroy-all-bidsForSale"/></th>
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
        @foreach($bids as $bid)
            <tr>
                <td><input type="checkbox" data-place-id="{{ $bid->id }}" name="destoy-place-{{ $bid->id }}" class="js-destroy-bidForSale"/></td>
                    <td><a href="bidForSale/{{ $bid->id }}">{{ $bid->place()->get()->first()->block }}</a></td>
                    <td>{{ $bid->place()->get()->first()->floor }}</td>
                    <td>{{ $bid->place()->get()->first()->row }}</td>
                    <td>{{ $bid->place()->get()->first()->place_number }}</td>
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
                $(".destroy-all-bidsForSale").on("click", function() {
                    if($(".destroy-all-bidsForSale").prop("checked")){
                        $(".js-destroy-bidForSale").prop("checked", "checked");
                    }
                    else{
                        $(".js-destroy-bidForSale").prop("checked", "");
                    }
    
                });
            });

            $(document).on('click', '.js-destroy-bidsForSale-button', function() {
            let ids = [];

            $(".js-destroy-bidForSale:checked").each(function(){
                ids.push($(this).data('placeId'));
            });

            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data    : { ids: ids },
                url     : 'bidForSale/delete',
                method    : 'delete',
                success: function (response) {
                    console.log(response);
                    $(".js-destroy-bidForSale:checked").closest('tr').remove();
                    $(".js-destroy-bidForSale").prop("checked", "");
                },
                error: function (xhr, err) { 
                    console.log("Error: " + xhr + " " + err);
                }
            });

        });

    });
</script>
@endsection