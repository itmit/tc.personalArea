@extends('layouts.adminApp')

@section('content')

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Место</th>
            <th>Имя продовца</th>
            <th>Ряд</th>
            <th>Статус</th>
            <th>Цена</th>
        </tr>
        </thead>
        <tbody>
        @foreach($places as $place)
            <tr>
                <td>{{ $place->place_number }}</td>
                <td>{{ $place->seller_name }}</td>
                <td>{{ $place->phone_number }}</td>
                <td>{{ $place->price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection