@extends('layouts.adminApp')

@section('content')
@ability('super-admin,manager,manager-waste', 'create-waste')
<a href="{{ route('auth.managerwaste.wastes.create') }}" class="btn btn-tc-manager">Создать заявку</a>
@endability
@ability('super-admin,manager,manager-waste', 'create-excel')
<div class="row">
    <div class="col-md-6">
        <select name="active-type" id="active-type" class="form-control">
            <option value="активна">Активные</option>
            <option value="неактивна">Неактивные</option>
        </select>
    </div>
    <div class="col-md-6">
        <input type="button" value="Сформировать Excel-файл">
    </div>
</div>
@endability
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
    <li data-type="активна" class="active"><a href="#">Активные</a></li>
    <li data-type="неактивна"><a href="#">Неактивные</a></li>
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
        <th>Сменить статус</th>
        @endability
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
$(document).ready(function()
    {
        let type = $('#myTab li').data('type');
        let block = $('#getPlacesByBlock').val();

        $('#myTab li').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
            type = $(this).data('type');
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data    : { block: block, type: type },
                url     : 'wastes/selectByBlock',
                method    : 'post',
                success: function (data) {
                let result = '';
                if(data.length === 0)
                {
                    result += '<tr><td colspan="7">В выбранном разделе ничего нет</td></tr>'
                }
                else
                {
                    for(var i = 0; i < data.length; i++) {
                        result += '<tr>';
                        result += '<td>' + data[i]['block'] + '</td>';
                        result += '<td>' + data[i]['floor'] + '</td>';
                        result += '<td>' + data[i]['row'] + '</td>';
                        result += '<td>' + data[i]['place'] + '</td>';
                        result += '<td>' + data[i]['release_date'] + '</td>';
                        result += '<td>' + data[i]['name'] + '</td>';
                        result += '<td>' + data[i]['phone'] + '</td>';
                        result += '</tr>';
                    }
                }   
                $('tbody').html(result);
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        });

        $(document).on('change', '#getPlacesByBlock', function() {
            block = $('#getPlacesByBlock').val();
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data    : { block: block, type: type },
                url     : 'wastes/selectByBlock',
                method    : 'post',
                success: function (data) {
                let result = '';
                if(data.length === 0)
                {
                    result += '<tr><td colspan="7">В выбранном разделе ничего нет</td></tr>'
                }
                else
                {
                    for(var i = 0; i < data.length; i++) {
                        result += '<tr>';
                        result += '<td>' + data[i]['block'] + '</td>';
                        result += '<td>' + data[i]['floor'] + '</td>';
                        result += '<td>' + data[i]['row'] + '</td>';
                        result += '<td>' + data[i]['place'] + '</td>';
                        result += '<td>' + data[i]['release_date'] + '</td>';
                        result += '<td>' + data[i]['name'] + '</td>';
                        result += '<td>' + data[i]['phone'] + '</td>';
                        result += '</tr>';
                    }
                }   
                $('tbody').html(result);
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        });
    });
</script>

@endsection