@extends('layouts.adminApp')

@section('content')

    <h1>Место id {{ $place->id }}</h1>
    <div class="col-sm-12">
        <a href="{{ url()->previous() }}">Назад</a>
    </div>
    <div class="col-sm-12">
        <form action="">
            <div>
                Блок
                <select name="" id="">
    
                </select>
            </div>
            <div>
                Этаж
                <input type="text" name="" id="" value="{{ $place->floor }}">
            </div>
            <div>
                Ряд
                <input type="text" name="" id="">
            </div>
            <div>
                Номер места
                <input type="text" name="" id="" value="{{ $place->floor }}">
            </div>
            <div>
                Статус
                <select name="" id="">
    
                </select>
            </div>
            <div>
                Цена
                <input type="text" name="" id="" value="{{ $place->price }}">
            </div>
        </form> 
    </div>

@endsection