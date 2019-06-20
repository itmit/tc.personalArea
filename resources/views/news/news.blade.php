@extends('layouts.adminApp')

@section('content')
    
    @ability('super-admin,manager', 'show-purchase-requisition-list')
    <span><a href="{{ route('auth.manager.news.create') }}">Добавить</a></span>
    @endability

    <br>
    @foreach($news as $newsItem)

    <div class="row">
        <div class="col-sm-9">
                {{ $newsItem->head }}
            <div class="row">
            <div class="col-8 col-sm-6">
                <img src="{{ $newsItem->picture }}" alt="{{ $newsItem->head }}" width="100%" height="100%">
            </div>
            <div class="col-4 col-sm-6">
                {{ $newsItem->body }}
            </div>
            </div>
        </div>
    </div>
    
    @endforeach

@endsection