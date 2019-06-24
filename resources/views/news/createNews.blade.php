@extends('layouts.adminApp')

@section('content')
    
<form class="form-horizontal" method="POST" action="{{ route('auth.manager.news.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('head') ? ' has-error' : '' }}">
        <label for="head" class="col-md-1 control-label">Заголовок</label>

        <div class="col-md-6">
            <input id="head" type="text" class="form-control" name="head" value="{{ old('head') }}" required autofocus>

            @if ($errors->has('head'))
                <span class="help-block">
                    <strong>{{ $errors->first('head') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <label for="body" class="col-md-1 control-label">Текст</label>

        <div class="col-md-6">
            <textarea id="body" type="text" class="md-textarea form-control" name="body" cols="30" rows="10">{{ old('body') }}</textarea>

            @if ($errors->has('body'))
                <span class="help-block">
                    <strong>{{ $errors->first('body') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
        <label for="picture" class="col-md-1 control-label">Картинка</label>
    
        <div class="col-md-6">
            <input type="file" name="picture" id="picture" class="form-control-file" accept="image/*" required>

            @if ($errors->has('picture'))
                <span class="help-block">
                    <strong>{{ $errors->first('picture') }}</strong>
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