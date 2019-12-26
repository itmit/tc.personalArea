@extends('layouts.adminApp')

@section('content')
<ul class="nav nav-tabs" id="myTab">
    <li data-type="untreated" class="active"><a href="#">Необработанные</a></li>
    <li data-type="in work"><a href="#">В работе</a></li>
    <li data-type="processed"><a href="#">Обработанные</a></li>
</ul>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Блок</th>
        <th>Этаж</th>
        <th>Ряд</th>
        <th>Место</th>
        <th>Имя продавца</th>
        <th>Номер телефона</th>
    </tr>
    </thead>
    <tbody>
    <?
        $place = null;
    ?>
    @foreach($questions as $bid)
    <?
        $place = $bid->place()->get()->first();
    ?>
        <tr>
            <td><a href="{{$link}}/{{ $bid->id }}">{{ $place->block }}</a></td>
            <td>{{ $place->floor }}</td>
            <td>{{ $place->row }}</td>
            <td>{{ $place->place_number }}</td>
            <td>{{ $bid->name }}</td>
            <td>{{ $bid->phone_number }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function()
    {
        let pathname = window.location.pathname;
        pathname = pathname.split('/')[1];
        $('#myTab li').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
        let type = $(this).data('type');
        $.ajax({
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            data: {type: type, pathname: pathname},
            url     : 'questions/selectByType',
            method    : 'post',
            success: function (response) {
                let result = '';
                    for(var i = 0; i < response.length; i++) {
                        result += '<tr>';
                        result += '<td><a href="'+response[i]['path']+'/'+response[i]['id']+'">' + response[i]['block'] + '</td>';
                        result += '<td>' + response[i]['floor'] + '</td>';
                        result += '<td>' + response[i]['row'] + '</td>';
                        result += '<td>' + response[i]['place'] + '</td>';
                        result += '<td>' + response[i]['name'] + '</td>';
                        result += '<td>' + response[i]['phone'] + '</td>';
                        result += '</tr>';
                    }
                    $('tbody').html(result);
            },
            error: function (xhr, err) { 
                console.log(err + " " + xhr);
            }
        });
    })

    });
</script>
@endsection