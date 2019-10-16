@extends('layouts.adminApp')

@section('content')
    
<form class="form-horizontal" method="POST" action="{{ route('auth.manager.news.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('head') ? ' has-error' : '' }}">
        <div class="col-xs-12 col-sm-2">
        <label for="head" class="control-label text-tc">Заголовок</label>
        </div>

        <div class="col-xs-12 col-sm-10">
            <input id="head" type="text" class="form-control" name="head" value="{{ old('head') }}" required maxlength="191">

            @if ($errors->has('head'))
                <span class="help-block">
                    <strong>{{ $errors->first('head') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <div class="col-xs-12 col-sm-2">
        <label for="body" class="control-label text-tc">Текст</label>
        </div>

        <div class="col-xs-12 col-sm-10">
            <textarea id="body" type="text" class="md-textarea form-control" name="body" cols="30" rows="10" maxlength="2000">{{ old('body') }}</textarea>

            @if ($errors->has('body'))
                <span class="help-block">
                    <strong>{{ $errors->first('body') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
        <div class="col-xs-12 col-sm-2">
        <label for="picture" class=" control-label text-tc">Картинка</label>
        </div>
    
        <div class="col-xs-12 col-sm-10">
            <input type="file" name="picture" id="picture" class="form-control-file" accept="image/*" required>

            @if ($errors->has('picture'))
                <span class="help-block">
                    <strong>{{ $errors->first('picture') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">

        

        <div class="col-sm-12">
            <button type="submit" class="btn btn-tc-ct">
                Сохранить
            </button>
        </div>
    </div>

</form>

@endsection