@extends('layouts.adminApp')

@section('content')

<h1>Менеджер {{$manager->name}}</h1>
<div class="col-sm-12">
    <a href="/places">Назад</a>
</div>
<div class="col-sm-12">
    <form class="form-horizontal" method="POST" action="{{ route('auth.admin.managers.edit', ['id' => $manager->id]) }}">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $manager->id }}">

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Имя</label>

            <div class="col-md-6">
                <input type="text" name="name" id="name" value="{{ $manager->name }}" required>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">Почта</label>

            <div class="col-md-6">
                <input type="text" name="email" id="email" value="{{ $manager->email }}" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Обновить
                </button>
            </div>
        </div>
    </form> 
</div>

@endsection