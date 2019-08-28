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
            <td><button class="makeReservation" data-placeid=" {{ $place->place_id }} ">Забронировать</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection