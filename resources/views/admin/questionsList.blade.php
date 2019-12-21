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
                // let result = '';
                //     for(var i = 0; i < response.length; i++) {
                //         result += '<tr>';
                //         result += '<td><a href="bid/' + response[i]['id'] + '">' + response[i]['status'] + '</a></td>';
                //         if(response[i]['client']['name'] == null)
                //         {     
                //             result += '<td><a href="client/' + response[i]['client']['id'] + '">' + response[i]['client']['organization'] + '</a></td>';
                //         }
                //         else
                //         {
                //             result += '<td><a href="client/' + response[i]['client']['id'] + '">' + response[i]['client']['name'] + '</a></td>';
                //         }
                //         result += '<td>' + response[i]['guard'] + '</td>';
                //         result += '<td>' + response[i]['location']['latitude'] + ' | ' + response[i]['location']['longitude'] + '</td>';
                //         result += '<td>' + response[i]['type'] + '</td>';
                //         result += '<td>' + response[i]['client']['phone_number'] + '</td>';
                //         result += '<td>' + response[i]['created_at'] + '</td>';
                //         result += '<td>' + response[i]['updated_at'] + '</td>';
                //         result += '</tr>';
                //     }
                //     $('tbody').html(result);
            },
            error: function (xhr, err) { 
                console.log(err + " " + xhr);
            }
        });
    })
    
    </script>
@endsection