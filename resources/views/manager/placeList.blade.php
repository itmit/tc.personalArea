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

    <h2>Выберете блок</h2>

    <div class="col-sm-12">
        <select name="getPlacesByBlock" id="getPlacesByBlock" class="form-control">
            {{-- <option value="По-умолчанию">По-умолчанию</option> --}}
            <option disabled selected>Выберите блок</option>
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

    <table class="table table-bordered">
        <thead>
        <tr>
            <th><input type="checkbox" name="destroy-all-places" class="js-destroy-all"/></th>
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
        {{-- @foreach($places as $place)
            <tr @if($place->status == 'Арендован') style="background-color: #f7ecdd!important;" @endif @if($place->status == 'Забронировано') style="background-color: #ff8c00!important;" @endif>
                <td><input type="checkbox" data-place-id="{{ $place->id }}" name="destoy-place-{{ $place->id }}" class="js-destroy"/></td>
                <td><i class="material-icons"><a href="place/edit/{{ $place->id }}">edit</a></i></td>
                <td>{{ $place->block }}</td>
                <td>{{ $place->floor }}</td>
                <td>{{ $place->row }}</td>
                <td>{{ $place->place_number }}</td>
                <td>
                    <select name="changePlaceStatus" id="changePlaceStatus" class='form-control' data-placeid="{{ $place->id }}">
                        <option value="Свободен" @if($place->status == 'Свободен') selected @endif >Свободен</option>
                        <option value="Арендован" @if($place->status == 'Арендован') selected @endif >Арендован</option>
                        <option value="Забронировано" @if($place->status == 'Забронировано') selected @endif >Забронировано</option>
                    </select>
                </td>
                <td>{{ $place->price }}</td>
            </tr>
        @endforeach --}}
        </tbody>
    </table>

    <script>
            $(document).ready(function()
            {    
                $(document).on('change', '#changePlaceStatus', function() {
                    let selectByAccept = $(this).val();
                    let place_id = $(this).data('placeid');
                    $.ajax({
                        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        data: {selectByAccept: selectByAccept, place_id: place_id},
                        url     : 'places/changePlaceStatus',
                        method    : 'post',
                        success: function (response) {
                            console.log(response)
                        },
                        error: function (xhr, err) { 
                            console.log(err + " " + xhr);
                        }
                    });
                });
            });
        </script>

@endsection