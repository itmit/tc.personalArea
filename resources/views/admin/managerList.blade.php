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
            <th>Изменить</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($managers as $manager)
            <tr>
                <td>{{ $manager->name }}</td>
                <td>{{ $manager->email }}</td>
                <td>{{ $manager->created_at }}</td>
                <td>{{ $manager->updated_at }}</td>
                <td><a href="managers/edit/{{ $manager->id }}"><i class="material-icons edit-manager" data-id="{{ $manager->id }}">edit</i></a></td>
                <td><i class="material-icons delete-manager" style="cursor: pointer" data-id="{{ $manager->id }}">delete</i></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>

    $(document).on('click', '.delete-manager', function() {
        let isDelete = confirm("Удалить менеджера? Данное действие невозможно отменить!");
    
        if(isDelete)
        {
            let id = $(this).data('id');
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data    : { id: id },
                url     : 'managers/delete',
                method    : 'delete',
                success: function (response) {
                    $(this).closest('tr').remove();
                    console.log('Удалено!');
                },
                error: function (xhr, err) { 
                    console.log("Error: " + xhr + " " + err);
                }
            });
        }
    });
    
    </script>
@endsection