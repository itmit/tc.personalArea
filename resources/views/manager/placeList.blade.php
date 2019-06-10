@extends('layouts.adminApp')

@section('content')

    <span>Импорт</span>
    @ability('super-admin,manager', 'import-place')
    <form action="{{ route('auth.manager.places.import') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}


        <div class="row form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label for="status" class="col-md-4 control-label">Статус</label>

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

        <div class="row form-group{{ $errors->has('excel') ? ' has-error' : '' }}">
            <label for="excel" class="col-md-4 control-label">.xlsx файл для импорта</label>

            <div class="col-md-6">
                <input type="file" name="excel" id="excel" accept=".xlsx">
            </div>

            @if ($errors->has('excel'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Импорт
            </button>
        </div>
    </form>
    @endability

    @ability('super-admin,manager', 'create-place')
    <div class="col-sm-12">
        <a href="{{ route('auth.manager.places.create') }}">Создать место</a>
    </div>
    @endability
    <table class="table table-bordered">
        <thead>
        <tr>
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