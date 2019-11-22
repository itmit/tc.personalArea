@extends('layouts.adminApp')

@section('content')
<select name="selectByAccept" id="selectByAccept" class="form-control" style="margin-bottom: 10px">
    <option value="all">Все</option>
    <option value="active" selected>Активные</option>
    <option value="accepted">Обработанные</option>
</select>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>Имя</th>
            <th>Рейтинг</th>
            <th>Телефон</th>
            <th>Блок</th>
            <th>Этаж</th>
            <th>Ряд</th>
            <th>Место</th>
            <th>Создано</th>
            <th>Истекает</th>
        </tr>
        </thead>
        <tbody>
        @foreach($places as $place)
            <tr id="{{ $place->id }}">
                <td><i class="material-icons"><a href="reservation/{{ $place->id }}">slideshow</a></i></td>
                <td><a href="../client/{{ $place->client()->id }}">{{ $place->first_name }} {{ $place->last_name }}</a></td>
                <td>{{ $place->client()->rating }}</td>
                <td>{{ $place->client()->phone }}</td>
                <td>{{ $place->place()->block }}</td>
                <td>{{ $place->place()->floor }}</td>
                <td>{{ $place->place()->row }}</td>
                <td>{{ $place->place()->place_number }}</td>
                <td>{{ $place->created_at->timezone('Europe/Moscow') }}</td>
                <td>{{ $place->expires_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function()
        {
            // $(document).on('click', '.makeReservation', function() {
            //     let place_id = $(this).data('placeid');
            //     let user_id = $(this).data('userid');
            //     $.ajax({
            //         headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         dataType: "json",
            //         data: {place_id: place_id, user_id: user_id},
            //         url     : 'reservation/confirmReservation',
            //         method    : 'post',
            //         success: function (response) {
            //             $('#' + user_id).remove();
            //         },
            //         error: function (xhr, err) { 
            //             console.log(err + " " + xhr);
            //         }
            //     });
            // });

            $(document).on('change', '#selectByAccept', function() {
                let selectByAccept = $('#selectByAccept').val();
                $.ajax({
                    headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    data: {selectByAccept: selectByAccept},
                    url     : 'reservation/selectByAccept',
                    method    : 'post',
                    success: function (response) {
                        let result = '';
                        for(var i = 0; i < response.length; i++) {
                            result += '<tr id="' + response[i]['id'] + '">';
                            result += '<td><i class="material-icons"><a href="reservation/' + response[i]['id'] + '">slideshow</a></i></td>';
                            result += '<td>' + response[i]['first_name'] + ' ' + response[i]['last_name'] + '</td>';
                            result += '<td>' + response[i]['rating'] + '</td>';
                            result += '<td>' + response[i]['phone'] + '</td>';
                            result += '<td>' + response[i]['place']['block'] + '</td>';
                            result += '<td>' + response[i]['place']['floor'] + '</td>';
                            result += '<td>' + response[i]['place']['row'] + '</td>';
                            result += '<td>' + response[i]['place']['place_number'] + '</td>';
                            // if(response[i]['accepted'] == 0)
                            // {
                            //     result += '<td><button class="makeReservation" data-userid="' + response[i]['id'] + '" data-placeid="' + response[i]['place']['id'] + '">Забронировать</button> / <button class="cancelReservation" data-placeid="' + response[i]['place']['id'] + '">Отказать</button></td>';
                            // }
                            // if(response[i]['accepted'] == 1)
                            // {
                            //     result += '<td><button class="deleteReservation" data-userid="' + response[i]['id'] + '" data-placeid="' + response[i]['id'] + '">Снять бронь</button></td>';
                            // }
                            // if(response[i]['accepted'] == 2)
                            // {
                            //     result += '<td>Бронь была отменена</td>';
                            // }
                            result += '<td>' + response[i]['created_at'] + '</td>';
                            // result += '<td>' + response[i]['updated_at'] + '</td>';
                            result += '</tr>';
                        }
                        $('tbody').html(result);

                    },
                    error: function (xhr, err) { 
                        console.log(err + " " + xhr);
                    }
                });
            });

            // $(document).on('click', '.deleteReservation', function() {
            //     let place_id = $(this).data('placeid');
            //     // console.log(place_id);
            //     $.ajax({
            //         headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         dataType: "json",
            //         data: {place_id: place_id},
            //         url     : 'reservation/deleteReservation',
            //         method    : 'post',
            //         success: function (response) {
            //             $(this).remove();
            //             // console.log('suc');
            //             // console.log($(this).parent().html());
            //         },
            //         error: function (xhr, err) { 
            //             console.log(err + " " + xhr);
            //         }
            //     });
            // });

            // $(document).on('click', '.cancelReservation', function() {
            //     let place_id = $(this).data('placeid');
            //     $.ajax({
            //         headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         dataType: "json",
            //         data: {place_id: place_id},
            //         url     : 'reservation/cancelReservation',
            //         method    : 'post',
            //         success: function (response) {
            //             $('#' + place_id).remove();
            //         },
            //         error: function (xhr, err) { 
            //             console.log(err + " " + xhr);
            //         }
            //     });
            // });
        });
    </script>

    {{-- <template id="item-of-reservations">
        <tr id="{{ $place->id }}">
            <td><i class="material-icons"><a href="reservation/{{ $place->id }}">slideshow</a></i></td>
            <td><a href="../client/{{ $place->client()->id }}">{{ $place->first_name }} {{ $place->last_name }}</a></td>
            <td>{{ $place->client()->rating }}</td>
            <td>{{ $place->client()->phone }}</td>
            <td>{{ $place->place()->block }}</td>
            <td>{{ $place->place()->floor }}</td>
            <td>{{ $place->place()->row }}</td>
            <td>{{ $place->place()->place_number }}</td>
            {{-- <td><button class="makeReservation"  data-userid="{{ $place->id }}" data-placeid="{{ $place->place_id }}">Забронировать</button> / <button class="cancelReservation" data-placeid="{{ $place->id }}">Отказать</button></td> --}}
            {{-- <td>{{ $place->created_at->timezone('Europe/Moscow') }}</td> --}}
        {{-- </tr> --}}
    {{-- </template> --}}

@endsection