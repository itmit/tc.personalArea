@extends('layouts.adminApp')

@section('content')
<ul class="nav nav-tabs" id="myTab">
    <li data-type="assignment" class="active"><a href="#">Переуступка прав</a></li>
    <li data-type="acquisition"><a href="#">Приобретение прав</a></li>
</ul>
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
        <th>Удалить</th>
    </tr>
    </thead>
    <tbody>
    @foreach($questions as $question)
    @if($question->place()->get()->first() == NULL)
    @continue
    @endif
        <tr>
            <td>{{ $question->place()->get()->first()->block }}</td>
            <td>{{ $question->place()->get()->first()->floor }}</td>
            <td>{{ $question->place()->get()->first()->row }}</td>
            <td>{{ $question->place()->get()->first()->place_number }}</td>
            <td>{{ $question->name }}</td>
            <td>{{ $question->phone_number }}</td>
            <td>{{ $question->text }}</td>
            <td><i class="material-icons delete-question" style="cursor: pointer" data-id="{{ $question->id }}">delete</i></td>
        </tr>
    @endforeach
    </tbody>
</table>

    <script>

    $(document).on('click', '.delete-question', function() {
        let isDelete = confirm("Удалить обращение? Данное действие невозможно отменить!");
    
        if(isDelete)
        {
            let id = $(this).data('id');
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data    : { id: id },
                url     : 'questions/delete',
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

    $('#myTab li').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
        let type = $(this).data('type');
        $.ajax({
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            data: {type: type},
            url     : 'questions/selectByType',
            method    : 'post',
            success: function (response) {
                let result = '';
                    for(var i = 0; i < response.length; i++) {
                        result += '<tr>';
                        result += '<td>' + response[i]['block'] + '</td>';
                        result += '<td>' + response[i]['floor'] + '</td>';
                        result += '<td>' + response[i]['row'] + '</td>';
                        result += '<td>' + response[i]['place'] + '</td>';
                        result += '<td>' + response[i]['name'] + '</td>';
                        result += '<td>' + response[i]['phone'] + '</td>';
                        result += '<td>' + response[i]['text'] + '</td>';
                        result += '<td <i class="material-icons delete-question" style="cursor: pointer" data-id="' + response[i]['id'] + '">delete</i></td>';
                        result += '</tr>';
                    }
                    $('tbody').html(result);
            },
            error: function (xhr, err) { 
                console.log(err + " " + xhr);
            }
        });
    })
    
    </script>
@endsection