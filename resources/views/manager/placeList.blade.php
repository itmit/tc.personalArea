@extends('layouts.adminApp')

@section('content')
<div class="import-tc">
    <p class="text-tc-h">Импорт</p>
    @ability('super-admin,manager', 'import-place')
    <form action="{{ route('auth.manager.places.import') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}


        <div class="row form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label for="status" class="col-md-4 control-label text-tc">Статус</label>

            <div class="col-md-6">
                <select name="status" id="status" required autofocus>
                    <option value="Свободен">Свободен</option>
                    <option value="Арендован">Арендован</option>
                </select>

                @if ($errors->has('status'))
                    <span class="help-block">
                        <strong>{{ $errors->first('status') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row form-group{{ $errors->has('block') ? ' has-error' : '' }}">
            <label for="excel" class="col-md-4 control-label text-tc">.xlsx файл для импорта</label>

            <div class="col-md-6">
                <input type="file" name="excel" id="excel" accept=".xlsx">
            </div>

            @if ($errors->has('block'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-tc-ct">
                Импорт
            </button>
        </div>
    </form>
</div>
    @endability

    @ability('super-admin,manager', 'create-place')
    <form class="form-horizontal" method="GET" action="{{ route('auth.manager.places.create') }}">
    <div class="col-sm-12">
        <button type="submit" class="btn btn-tc-manager">Создать место</button>
    </div>
    </form>
    @endability

    <div class="col-sm-12">
        <button type="button" class="btn btn-tc-manager js-destroy-button">Удалить отмеченные места</button>
    </div>

    <div class="col-sm-12">
        <select name="getPlacesByBlock" id="getPlacesByBlock" class="form-control">
            <option value="По-умолчанию">По-умолчанию</option>
            <option value="Вещевые ряды">Вещевые ряды</option>
            <option value="Меха и кожа">Меха и кожа</option>
            <option value="ТЦ 'Садовод'">ТЦ 'Садовод'</option>
            <option value="Свадебная галерея 'САЛЮТ'">Свадебная галерея 'САЛЮТ'</option>
            <option value="Ковры и текстиль">Ковры и текстиль</option>
            <option value="Новый ТЦ" disabled>Новый ТЦ</option>
        </select>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th><input type="checkbox" name="destroy-all-places" class="js-destroy-all"/></th>
            <th>Блок</th>
            <th>Этаж</th>
            <th>Ряд</th>
            <th>Место</th>
            <th>Статус</th>
            <th>Цена</th>
        </tr>
        </thead>
        <tbody>
        @foreach($places as $place)
            <tr>
                <td><input type="checkbox" data-place-id="{{ $place->id }}" name="destoy-place-{{ $place->id }}" class="js-destroy"/></td>
                <td>{{ $place->block }}</td>
                <td>{{ $place->floor }}</td>
                <td>{{ $place->row }}</td>
                <td>{{ $place->place_number }}</td>
                <td>{{ $place->status }}</td>
                <td>{{ $place->price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection