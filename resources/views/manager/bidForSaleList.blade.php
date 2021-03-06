@extends('layouts.adminApp')

@section('content')

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Место</th>
            <th>Имя продовца</th>
            <th>Номер телефона</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bids as $bid)
            <tr>
                <td>{{ $bid->place->place_number }}</td>
                <td>{{ $bid->seller_name }}</td>
                <td>{{ $bid->phone_number }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection