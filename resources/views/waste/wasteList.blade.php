@extends('layouts.adminApp')

@section('content')
<h2>Выберите блок</h2>

<div class="col-sm-12">
    <select name="getPlacesByBlock" id="getPlacesByBlock" class="form-control">
        {{-- <option value="По-умолчанию">По-умолчанию</option> --}}
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
<br>
<table class="table table-bordered">
    <thead>
    <tr>
        @ability('super-admin', 'delete-place')
        <th><input type="checkbox" name="destroy-all-places" class="js-destroy-all"/></th>
        @endability
        <th><i class="material-icons">edit</i></th>
        <th>Блок</th>
        <th>Этаж</th>
        <th>Ряд</th>
        <th>Место</th>
        <th>Статус</th>
        <th>Цена</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@endsection