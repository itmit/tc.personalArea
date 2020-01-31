@extends('layouts.adminApp')

@section('content')
<h2>Выберите блок</h2>

<div class="col-sm-12">
    <select name="getPlacesByBlock" id="getPlacesByBlock" class="form-control">
        <option value="empty" disabled selected>Выберите блок</option>
        <option value="Вещевой">Вещевые ряды</option>
        <option value="ТЦ">ТЦ Садовод</option>
        <option value="Новый ТЦ">Новый ТЦ</option>
        <option value="5 павильон">Меха и кожа</option>
        <option value="ЗСМИ">Пальтовый круг</option>
        <option value="Салют">Свадебная галерея 'САЛЮТ'</option>
        <option value="ковры и текстиль">Ковры и текстиль</option>
        <option value="Дом бижутерии">Дом бижутерии</option>
    </select>
</div>
<ul class="nav nav-tabs" id="myTab">
    <li data-type="active" class="active"><a href="#">Активные</a></li>
    <li data-type="unactive"><a href="#">Неактивные</a></li>
</ul>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Блок</th>
        <th>Этаж</th>
        <th>Ряд</th>
        <th>Место</th>
        <th>Дата освобождения</th>
        <th>Имя</th>
        <th>Телефон</th>
        @ability('super-admin,manager', 'change-waste-status')
        <th>Имя</th>
        @endability
    </tr>
    </thead>
    <tbody>
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
            url     : 'wastes/selectByBlock',
            method    : 'post',
            success: function (response) {
                let result = '';
                    for(var i = 0; i < response.length; i++) {
                        result += '<tr>';
                        result += '<td>' + response[i]['block'] + '</td>';
                        result += '<td>' + response[i]['floor'] + '</td>';
                        result += '<td>' + response[i]['row'] + '</td>';
                        result += '<td>' + response[i]['place'] + '</td>';
                        result += '<td>' + response[i]['release_date'] + '</td>';
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