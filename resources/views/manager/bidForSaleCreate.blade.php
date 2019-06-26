@extends('layouts.adminApp')

@section('content')

<form class="form-horizontal" method="POST" action="{{ route('auth.manager.bid-for-sale.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('Block') ? ' has-error' : '' }}">
        <label for="head" class="col-md-1 control-label">Блок</label>

        <div class="col-md-6">
            <input id="Block" type="text" class="form-control" name="Block" value="{{ old('Block') }}" required autofocus>

            @if ($errors->has('Block'))
                <span class="help-block">
                    <strong>{{ $errors->first('Block') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('Floor') ? ' has-error' : '' }}">
        <label for="Floor" class="col-md-1 control-label">Этаж</label>

        <div class="col-md-6">
            <input id="Floor" type="text" class="form-control" name="Floor" value="{{ old('Floor') }}" required autofocus>

            @if ($errors->has('Floor'))
                <span class="help-block">
                    <strong>{{ $errors->first('Floor') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('PlaceNumber') ? ' has-error' : '' }}">
        <label for="PlaceNumber" class="col-md-1 control-label">Место</label>

        <div class="col-md-6">
            <input id="PlaceNumber" type="text" class="form-control" name="PlaceNumber" value="{{ old('PlaceNumber') }}" required autofocus>

            @if ($errors->has('PlaceNumber'))
                <span class="help-block">
                    <strong>{{ $errors->first('PlaceNumber') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('selNameler_name') ? ' has-error' : '' }}">
        <label for="Name" class="col-md-1 control-label">Имя</label>

        <div class="col-md-6">
            <input id="Name" type="text" class="form-control" name="Name" value="{{ old('Name') }}" required autofocus>

            @if ($errors->has('Name'))
                <span class="help-block">
                    <strong>{{ $errors->first('Name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('PhoneNumber') ? ' has-error' : '' }}">
        <label for="PhoneNumber" class="col-md-1 control-label">Телефон</label>

        <div class="col-md-6">
            <input id="PhoneNumber" type="text" class="form-control" name="PhoneNumber" value="{{ old('PhoneNumber') }}" required autofocus>

            @if ($errors->has('PhoneNumber'))
                <span class="help-block">
                    <strong>{{ $errors->first('PhoneNumber') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">

        <label for="picture" class="col-md-1 control-label"></label>

        <div class="col-md-1 offset-md-1">
            <button type="submit" class="btn btn-primary">
                Сохранить
            </button>
        </div>
    </div>

</form>    

@endsection