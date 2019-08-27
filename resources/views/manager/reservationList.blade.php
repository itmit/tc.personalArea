@extends('layouts.adminApp')

@section('content')
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
                <td>{{ $place->place()->id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection