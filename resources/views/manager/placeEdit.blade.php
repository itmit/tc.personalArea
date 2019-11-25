@extends('layouts.adminApp')

@section('content')

    <h1>Место id {{ $place->id }}</h1>
    <div class="col-sm-12">
        <a href="/places">Назад</a>
    </div>
    <div class="col-sm-12">
        <form class="form-horizontal" method="POST" action="{{ route('auth.manager.place.store') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $place->id }}">

            <div class="form-group{{ $errors->has('block') ? ' has-error' : '' }}">
                <label for="block" class="col-md-4 control-label">Блок</label>
    
                <div class="col-md-6">
                    <select name="block" id="block" required autofocus>
                        <option value="Вещевой" @if($place->block == "Вещевой") selected @endif>Вещевые ряды</option>
                        <option value="ТЦ" @if($place->block == "ТЦ") selected @endif>ТЦ Садовод</option>
                        <option value="Новый ТЦ" @if($place->block == "Новый ТЦ") selected @endif>Новый ТЦ</option>
                        <option value="5 павильон" @if($place->block == "5 павильон") selected @endif>Меха и кожа</option>
                        <option value="ЗСМИ" @if($place->block == "ЗСМИ") selected @endif>Пальтовый круг</option>
                        <option value="Салют" @if($place->block == "Салют") selected @endif>Свадебная галерея 'САЛЮТ'</option>
                        <option value="ковры и текстиль" @if($place->block == "ковры и текстиль") selected @endif>Ковры и текстиль</option>
                        <option value="Дом бижутерии" @if($place->block == "Дом бижутерии") selected @endif>Дом бижутерии</option>
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
                    <input type="text" name="floor" id="floor" value="{{ $place->floor }}" required>
    
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
                    <input type="text" name="row" id="row" value="{{ $place->row }}" required>
    
                    @if ($errors->has('row'))
                        <span class="help-block">
                            <strong>{{ $errors->first('row') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('place_number') ? ' has-error' : '' }}">
                <label for="place_number" class="col-md-4 control-label">Номер места</label>
    
                <div class="col-md-6">
                    <input type="text" name="place_number" id="place_number" value="{{ $place->place_number }}" required>
    
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
                    <select name="status" id="status" required>
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
                    <input type="text" name="price" id="price" value="{{ $place->price }}" required> 
    
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
                        Обновить место
                    </button>
                </div>
            </div>
        </form> 
    </div>

@endsection