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
            {{-- <div class="col-8 col-sm-6"> --}}
                {{-- <img src="{{ $newsItem->picture }}" alt="{{ $newsItem->head }}" width="25%" style="float:left; margin: 7px 7px 7px 0;"> --}}
            {{-- </div> --}}
            <div class="col-4 col-sm-10">
                <img src="{{ $newsItem->picture }}" alt="{{ $newsItem->head }}" width="25%" style="float:left; margin: 7px 7px 7px 0;">
                {!! htmlspecialchars_decode($newsItem->body) !!}
            </div>
            </div>
        </div>
    </div>
    
    @endforeach

@endsection