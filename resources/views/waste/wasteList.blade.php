@extends('layouts.adminApp')

@section('content')
@ability('super-admin,manager,manager-waste', 'create-waste')
<a href="{{ route('auth.admin.wastes.create') }}" class="btn btn-tc-manager">Создать заявку</a>
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
        let type = $('#myTab li').data('type');
        console.log(type);

        $('#myTab li').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
            type = $(this).data('type');
            console.log(type);
        });

        let block = $('#getPlacesByBlock').val();
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data    : { block: block, type: type },
                url     : 'wastes/selectByBlock',
                method    : 'post',
                success: function (data) {
                let result = '';
                if(data[0].length === 0)
                {
                    result += '<tr><td colspan="7">В выбранном разделе ничего нет</td></tr>'
                }
                else
                {
                    for(var i = 0; i < data[0].length; i++) {
                        
                        if(data[0][i]['status'] == 'Арендован')
                        {
                            result += '<tr style="background-color: #f7ecdd!important;">';
                        }
                        if(data[0][i]['status'] == 'Забронировано')
                        {
                            result += '<tr style="background-color: #ff8c00!important;">';
                        }
                        if(data[0][i]['status'] == 'Свободен')
                        {
                            result += '<tr>';
                        }
                        result += '<td><input type="checkbox" data-place-id="' + data[0][i]['id'] + '" name="destoy-place-' + data[0][i]['id'] + '" class="js-destroy"/></td>';
                        result += '<td><i class="material-icons"><a href="place/edit/' + data[0][i]['id'] + '">edit</a></i></td>';
                        result += '<td>' + data[0][i]['block'] + '</td>';
                        result += '<td>' + data[0][i]['floor'] + '</td>';
                        result += '<td>' + data[0][i]['row'] + '</td>';
                        result += '<td>' + data[0][i]['place_number'] + '</td>';
                        result += '<td>';
                        result += '<select name="changePlaceStatus" id="changePlaceStatus" class="form-control" data-placeid="'+data[0][i]['id']+'">';
                        
                        if(data[0][i]['status'] == 'Свободен')
                        {
                            result += '<option value="Свободен" selected>Свободен</option>';
                        }
                        else
                        {
                            result += '<option value="Свободен">Свободен</option>';
                        }
                        if(data[0][i]['status'] == 'Арендован')
                        {
                            result += '<option value="Арендован" selected>Арендован</option>';
                        }
                        else
                        {
                            result += '<option value="Арендован">Арендован</option>';
                        }
                        if(data[0][i]['status'] == 'Забронировано')
                        {
                            result += '<option value="Забронировано" selected>Забронировано</option>';
                        }
                        else
                        {
                            result += '<option value="Забронировано">Забронировано</option>';
                        }
                        result += '</select>';
                        result += '</td>';
                        if(data[0][i]['price'] == null)
                        {
                            result += '<td></td>';
                        }
                        else
                        {
                            result += '<td>' + data[0][i]['price'] + '</td>';
                        }
                        
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
</script>

@endsection