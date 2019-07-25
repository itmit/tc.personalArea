@extends('layouts.adminApp')

@section('content')
    
    @ability('super-admin,manager', 'show-purchase-requisition-list')
    <form class="form-horizontal" method="GET" action="{{ route('auth.manager.news.create') }}">
    <button type="submit" class="btn btn-tc-manager">Добавить</button>
    </form>
    @endability

    <br>
    @foreach($news as $newsItem)

    <div class="row">
        <div class="col-sm-9">
                <h1>{{ $newsItem->head }}</h1>
            <div class="row">
            <div class="col-8 col-sm-6">
                <img src="{{ $newsItem->picture }}" alt="{{ $newsItem->head }}" width="100%" height="100%">
            </div>
            <div class="col-4 col-sm-6">
                {!! htmlspecialchars_decode($newsItem->body) !!}
            </div>
            </div>
        </div>
    </div>
    
    @endforeach

@endsection