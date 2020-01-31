@extends('layouts.adminApp')

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('auth.managerwaste.wastes.store') }}">
        {{ csrf_field() }}
        
        @if ($errors->has('place'))
            <span class="help-block">
                <strong>{{ $errors->first('place') }}</strong>
            </span>
        @endif

        <div class="form-group{{ $errors->has('block') ? ' has-error' : '' }}">
            <label for="block" class="col-md-4 control-label">Блок</label>

            <div class="col-md-6">
                <select name="block" id="block" required autofocus>
                    <option value="Вещевой">Вещевые ряды</option>
                    <option value="ТЦ">ТЦ Садовод</option>
                    <option value="Новый ТЦ">Новый ТЦ</option>
                    <option value="5 павильон">Меха и кожа</option>
                    <option value="ЗСМИ">Пальтовый круг</option>
                    <option value="Салют">Свадебная галерея 'САЛЮТ'</option>
                    <option value="ковры и текстиль">Ковры и текстиль</option>
                    <option value="Дом бижутерии">Дом бижутерии</option>
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
                <input id="floor" type="number" class="form-control" name="floor" value="{{ old('floor') }}">

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
                <input id="row" type="text" class="form-control" name="row" value="{{ old('row') }}" required>

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

        <div class="form-group{{ $errors->has('release_date') ? ' has-error' : '' }}">
            <label for="release_date" class="col-md-4 control-label">Дата освобождения</label>

            <div class="col-md-6">
                <input id="release_date" type="date" class="form-control" name="release_date" value="{{ old('release_date') }}">

                @if ($errors->has('release_date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('release_date') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Имя (опционально)</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label for="phone" class="col-md-4 control-label">Телефон (опционально)</label>

            <div class="col-md-6">
                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}">

                @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Создать заявку
                </button>
            </div>
        </div>
    </form>
@endsection