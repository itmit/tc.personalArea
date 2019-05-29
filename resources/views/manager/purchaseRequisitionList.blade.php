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
        @foreach($purchaseRequisitions as $purchaseRequisition)
            <tr>
                <td>{{ $purchaseRequisition->place->place_number }}</td>
                <td>{{ $purchaseRequisition->seller_name }}</td>
                <td>{{ $purchaseRequisition->phone_number }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection