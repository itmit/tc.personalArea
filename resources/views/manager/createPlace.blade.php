@extends('layouts.adminApp')

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('auth.manager.places.store') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('block') ? ' has-error' : '' }}">
            <label for="block" class="col-md-4 control-label">Блок</label>

            <div class="col-md-6">
                <select name="block" id="block" required autofocus>
                    <option value="Вещевые ряды">Вещевые ряды</option>
                    <option value="Меха и кожа">Меха и кожа</option>
                    <option value="ТЦ 'Садовод'">ТЦ 'Садовод'</option>
                    <option value="Свадебная галерея 'САЛЮТ'">Свадебная галерея 'САЛЮТ'</option>
                </select>

                @if ($errors->has('block'))
                    <span class="help-block">
                        <strong>{{ $errors->first('block') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('floor') ? ' has-error' : '' }}">
            <label for="floor" class="col-md-4 control-label">Этаж</label>

            <div class="col-md-6">
                <input id="floor" type="number" class="form-control" name="floor" value="{{ old('floor') }}" required>

                @if ($errors->has('floor'))
                    <span class="help-block">
                        <strong>{{ $errors->first('floor') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('row') ? ' has-error' : '' }}">
            <label for="row" class="col-md-4 control-label">Ряд</label>

            <div class="col-md-6">
                <input id="row" type="number" class="form-control" name="row" value="{{ old('row') }}" required>

                @if ($errors->has('row'))
                    <span class="help-block">
                        <strong>{{ $errors->first('row') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('place_number') ? ' has-error' : '' }}">
            <label for="place_number" class="col-md-4 control-label">Место</label>

            <div class="col-md-6">
                <input id="place_number" type="text" class="form-control" name="place_number" value="{{ old('place_number') }}" required>

                @if ($errors->has('place_number'))
                    <span class="help-block">
                        <strong>{{ $errors->first('place_number') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
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

        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
            <label for="price" class="col-md-4 control-label">Цена</label>

            <div class="col-md-6">
                <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" required>

                @if ($errors->has('price'))
                    <span class="help-block">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Создать место
                </button>
            </div>
        </div>
    </form>
@endsection