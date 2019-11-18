@extends('layouts.adminApp')

@section('content')

    <h1>Место id {{ $place->id }}</h1>
    <div class="col-sm-12">
        <a href="{{ url()->previous() }}">Назад</a>
    </div>
    <div class="col-sm-12">
        <form class="form-horizontal" method="POST" action="">

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

            <div class="form-group{{ $errors->has('row') ? ' has-error' : '' }}">
                <label for="row" class="col-md-4 control-label">Ряд</label>
    
                <div class="col-md-6">
                    <input type="text" name="row" id="row" value="{{ $place->row }}">
    
                    @if ($errors->has('row'))
                        <span class="help-block">
                            <strong>{{ $errors->first('row') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('place_number') ? ' has-error' : '' }}">
                <label for="row" class="col-md-4 control-label">Номер места</label>
    
                <div class="col-md-6">
                    <input type="text" name="place_number" id="place_number" value="{{ $place->place_number }}">
    
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
                    <select name="" id="">
                        <option value="Свободен"  @if($place->status == "Свободен") selected @endif>Свободен</option>
                        <option value="Арендован"  @if($place->status == "Арендован") selected @endif>Арендован</option>
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
                    <input type="text" name="price" id="price" value="{{ $place->price }}">
    
                    @if ($errors->has('price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
        </form> 
    </div>

@endsection