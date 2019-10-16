@extends('layouts.adminApp')

@section('content')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Текст</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{ $question->name }}</td>
                <td>{{ $question->phone_number }}</td>
                <td>{{ $question->text }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection