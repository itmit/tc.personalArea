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
            <th>Сменить статус</th>
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
            <td><button class="makeReservation"  data-userid="{{ $place->id }}" data-placeid="{{ $place->place_id }}">Забронировать</button> / <button class="cancelReservation" data-placeid="{{ $place->place_id }}">Отказать</button></td>
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
                console.log(user_id);
                $.ajax({
                    headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    data: {place_id: place_id, user_id: user_id},
                    url     : 'reservation/confirmReservation',
                    method    : 'post',
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr, err) { 
                        console.log(err + " " + xhr);
                    }
                });
            });
        });
    </script>
@endsection