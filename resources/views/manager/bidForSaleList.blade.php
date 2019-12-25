@extends('layouts.adminApp')

@section('content')
<ul class="nav nav-tabs" id="myTab">
    <li data-type="assignment" class="active"><a href="#">Переуступка прав</a></li>
    <li data-type="acquisition"><a href="#">Приобретение прав</a></li>
</ul>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Блок</th>
        <th>Этаж</th>
        <th>Ряд</th>
        <th>Место</th>
        <th>Имя продавца</th>
        <th>Номер телефона</th>
        {{-- <th>Текст</th> --}}
    </tr>
    </thead>
    <tbody>
    <?
        $place = null;
    ?>
    @foreach($bids as $bid)
    <?
        $place = $bid->place()->get()->first();
    ?>
        <tr>
            <td><a href="bidForSale/{{ $bid->id }}">{{ $place->block }}</a></td>
            <td>{{ $place->floor }}</td>
            <td>{{ $place->row }}</td>
            <td>{{ $place->place_number }}</td>
            <td>{{ $bid->seller_name }}</td>
            <td>{{ $bid->phone_number }}</td>
            {{-- <td>{{ $bid->text }}</td> --}}
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function()
    {
            
    });
</script>
@endsection