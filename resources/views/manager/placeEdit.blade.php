@extends('layouts.adminApp')

@section('content')

    <h1>Место id {{ $place->id }}</h1>
    <div class="col-sm-12">
        <a href="{{ url()->previous() }}">Назад</a>
    </div>
    <div class="col-sm-12">
        <form action="">

            <div class="form-group{{ $errors->has('block') ? ' has-error' : '' }}">
                <label for="block" class="col-md-4 control-label">Блок</label>
    
                <div class="col-md-6">
                    <select name="block" id="block">
                            <option value="Вещевые ряды" @if($place->block == "Вещевые ряды") selected @endif>Вещевые ряды</option>
                            <option value="Меха и кожа" @if($place->block == "Меха и кожа") selected @endif>Меха и кожа</option>
                            <option value="Новый ТЦ" @if($place->block == "Новый ТЦ") selected @endif>Новый ТЦ</option>
                            <option value="ТЦ 'Садовод'" @if($place->block == "ТЦ 'Садовод'") selected @endif>ТЦ 'Садовод'</option>
                            <option value="Свадебная галерея 'САЛЮТ'" @if($place->block == "Свадебная галерея 'САЛЮТ'") selected @endif>Свадебная галерея 'САЛЮТ'</option>
                            <option value="Ковры и текстиль" @if($place->block == "Ковры и текстиль") selected @endif>Ковры и текстиль</option>
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
                    <input type="text" name="" id="" value="{{ $place->floor }}">
    
                    @if ($errors->has('floor'))
                        <span class="help-block">
                            <strong>{{ $errors->first('floor') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div>
                Ряд
                <input type="text" name="" id=""  value="{{ $place->row }}">
            </div>
            <div>
                Номер места
                <input type="text" name="" id="" value="{{ $place->floor }}">
            </div>
            <div>
                Статус
                <select name="" id="">
                    <option value="Свободен"  @if($place->status == "Свободен") selected @endif>Свободен</option>
                    <option value="Арендован"  @if($place->block == "Арендован") selected @endif>Арендован</option>
                </select>
            </div>
            <div>
                Цена
                <input type="text" name="" id="" value="{{ $place->price }}">
            </div>
        </form> 
    </div>

@endsection