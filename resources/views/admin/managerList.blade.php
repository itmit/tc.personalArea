@extends('layouts.adminApp')

@section('content')

    @ability('super-admin', 'create-manager')

    <a href="{{ route('auth.admin.managers.create') }}" class="btn btn-tc-manager">Создать менеджера</a>
    @endability
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Почта</th>
            <th>Дата создания</th>
            <th>Дата обновления</th>
        </tr>
        </thead>
        <tbody>
        @foreach($managers as $manager)
            <tr>
                <td>{{ $manager->name }}</td>
                <td>{{ $manager->email }}</td>
                <td>{{ $manager->created_at }}</td>
                <td>{{ $manager->updated_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection