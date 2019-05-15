@extends('layouts.adminApp')

@section('content')

    @ability('super-admin,manager', 'create-place')
    <a href="{{ route('auth.manager.createPlace') }}">Создать место</a>
    @endability
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Блок</th>
            <th>Этаж</th>
            <th>Ряд</th>
            <th>Место</th>
            <th>Статус</th>
            <th>Цена</th>
        </tr>
        </thead>
        <tbody>
        @foreach($places as $place)
            <tr>
                <td>{{ $place->block }}</td>
                <td>{{ $place->floor }}</td>
                <td>{{ $place->row }}</td>
                <td>{{ $place->place_number }}</td>
                <td>{{ $place->status }}</td>
                <td>{{ $place->price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection