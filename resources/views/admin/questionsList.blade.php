@extends('layouts.adminApp')

@section('content')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Блок</th>
            <th>Этаж</th>
            <th>Ряд</th>
            <th>Место</th>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Текст</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{ $question->place()->get()->first()->block }}</td>
                <td>{{ $question->place()->get()->first()->floor }}</td>
                <td>{{ $question->place()->get()->first()->row }}</td>
                <td>{{ $question->place()->get()->first()->place_number }}</td>
                <td>{{ $question->name }}</td>
                <td>{{ $question->phone_number }}</td>
                <td>{{ $question->text }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection