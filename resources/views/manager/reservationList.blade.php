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
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Телефон</th>
            <th>Блок</th>
            <th>Этаж</th>
            <th>Ряд</th>
            <th>Место</th>
            <th>Сменить статус</th>
            <th>Создано</th>
            <th>Обновлено</th>
        </tr>
        </thead>
        <tbody>
        @foreach($places as $place)
            <tr id="{{ $place->id }}">
                <td>{{ $place->first_name }}</td>
                <td>{{ $place->last_name }}</td>
                <td>{{ $place->phone }}</td>
                <td>{{ $place->place()->block }}</td>
                <td>{{ $place->place()->floor }}</td>
                <td>{{ $place->place()->row }}</td>
                <td>{{ $place->place()->place_number }}</td>
                <td><button class="makeReservation"  data-userid="{{ $place->id }}" data-placeid="{{ $place->place_id }}">Забронировать</button> / <button class="cancelReservation" data-placeid="{{ $place->id }}">Отказать</button></td>
                <td>{{ $place->created_at->timezone('Europe/Moscow') }}</td>
                <td>{{ $place->updated_at->timezone('Europe/Moscow') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function()
        {
            $(document).on('click', '.makeReservation', function() {
                let place_id = $(this).data('placeid');
                let user_id = $(this).data('userid');
                $.ajax({
                    headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    data: {place_id: place_id, user_id: user_id},
                    url     : 'reservation/confirmReservation',
                    method    : 'post',
                    success: function (response) {
                        $('#' + user_id).remove();
                    },
                    error: function (xhr, err) { 
                        console.log(err + " " + xhr);
                    }
                });
            });

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
                            result += '<td>' + response[i]['first_name'] + '</td>';
                            result += '<td>' + response[i]['last_name'] + '</td>';
                            result += '<td>' + response[i]['phone'] + '</td>';
                            result += '<td>' + response[i]['place']['block'] + '</td>';
                            result += '<td>' + response[i]['place']['floor'] + '</td>';
                            result += '<td>' + response[i]['place']['row'] + '</td>';
                            result += '<td>' + response[i]['place']['place_number'] + '</td>';
                            if(response[i]['accepted'] == 0)
                            {
                                result += '<td><button class="makeReservation" data-userid="' + response[i]['id'] + '" data-placeid="' + response[i]['place']['id'] + '">Забронировать</button> / <button class="cancelReservation" data-placeid="' + response[i]['place']['id'] + '">Отказать</button></td>';
                            }
                            if(response[i]['accepted'] == 1)
                            {
                                result += '<td>1<button class="deleteReservation" data-userid="' + response[i]['id'] + '" data-placeid="' + response[i]['id'] + '">Снять бронь</button></td>';
                            }
                            if(response[i]['accepted'] == 2)
                            {
                                result += '<td>Бронь была отменена</td>';
                            }
                            result += '<td>' + response[i]['created_at'] + '</td>';
                            result += '<td>' + response[i]['updated_at'] + '</td>';
                            result += '</tr>';
                        }
                        $('tbody').html(result);

                    },
                    error: function (xhr, err) { 
                        console.log(err + " " + xhr);
                    }
                });
            });

            $(document).on('click', '.deleteReservation', function() {
                let place_id = $(this).data('placeid');
                console.log(place_id);
                $.ajax({
                    headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    data: {place_id: place_id},
                    url     : 'reservation/deleteReservation',
                    method    : 'post',
                    success: function (response) {
                        console.log('suc');
                        // console.log($(this).parent().html());
                    },
                    error: function (xhr, err) { 
                        console.log(err + " " + xhr);
                    }
                });
            });

            $(document).on('click', '.cancelReservation', function() {
                let place_id = $(this).data('placeid');
                $.ajax({
                    headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    data: {place_id: place_id},
                    url     : 'reservation/cancelReservation',
                    method    : 'post',
                    success: function (response) {
                        $('#' + place_id).remove();
                    },
                    error: function (xhr, err) { 
                        console.log(err + " " + xhr);
                    }
                });
            });
        });
    </script>
@endsection