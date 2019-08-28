@extends('layouts.adminApp')

@section('content')
<select name="" id="">
    <option value="all">Все</option>
    <option value="active" selected>Активные</option>
    <option value="accepted">Обработанные</option>
</select>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Телефон</th>
            <th>Блок</th>
            <th>Этаж</th>
            <th>Ряд</th>
            <th>Место</th>
            <th>Забронировать</th>
        </tr>
        </thead>
        <tbody>
        @foreach($places as $place)
            <tr>
                <td>{{ $place->first_name }}</td>
                <td>{{ $place->last_name }}</td>
                <td>{{ $place->phone }}</td>
                <td>{{ $place->place()->block }}</td>
                <td>{{ $place->place()->floor }}</td>
                <td>{{ $place->place()->row }}</td>
                <td>{{ $place->place()->place_number }}</td>
            <td><button class="makeReservation" data-placeid="{{ $place->place_id }}">Забронировать</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function()
        {
            $(document).on('click', '.makeReservation', function() {
            let place_id = $(this).data('placeid');
            console.log(place_id);
            // $.ajax({
            //     headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //     dataType: "json",
            //     data: {selectBidsByStatus: selectBidsByStatus},
            //     url     : 'bid/updateList',
            //     method    : 'post',
            //     success: function (response) {
            //         let result = '';
            //             for(var i = 0; i < response.length; i++) {
            //                 result += '<tr>';
            //                 result += '<td><a href="bid/' + response[i]['id'] + '">' + response[i]['status'] + '</a></td>';
            //                 result += '<td>' + response[i]['client']['email'] + '</td>';
            //                 result += '<td>' + response[i]['location']['latitude'] + ' | ' + response[i]['location']['longitude'] + '</td>';
            //                 result += '<td>' + response[i]['type'] + '</td>';
            //                 result += '<td>' + response[i]['created_at'] + '</td>';
            //                 result += '<td>' + response[i]['updated_at'] + '</td>';
            //                 result += '</tr>';
            //             }
            //             $('tbody').html(result);
            //     },
            //     error: function (xhr, err) { 
            //         console.log(err + " " + xhr);
            //     }
            // });
            });
        });
    </script>
@endsection