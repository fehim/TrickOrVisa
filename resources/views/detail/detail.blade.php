@extends('layouts.default')

@section('title')
    Trick Or Visa
@stop

@section('header_styles')
<style>
    .html {
        color: #fff;
    }
    .header {
        background: transparent url('https://res.cloudinary.com/trickorvisa/image/upload/v1490464032/countries/{{ $to->name }}.png') no-repeat 50% 56%;
        padding-bottom: 30px;
    }
    .pin {
        width: 45px;
    }

    .top-content {
        margin-top: 100px;
        color: #fff;
    }

    .country {
        margin-top: 10px;
        font-size: 32px;
    }

    .info {
        font-size: 16px;
        margin-top: 5px;
    }

    .info.city {
        margin-top: 20px;
    }
</style>
@stop

@section('topContent')
<div class="top-content text-center">
    <img src="/img/pin.png" class="pin"/>
    <h2 class="country">{{ $to->name }}</h2>
    <div class="info city">{{ $to->capital }}</div>
    <div class="info">
        {{ $weather['temp'].' '.$weather['unit'] }} {{ $weather['desc'] }}
    </div>
</div>
@endsection

@section('content')
    <style>
        .basic-info {
            padding: 20px 50px;
        }
        td {
            padding: 10px;
        }
    </style>
    <div class="basic-info">
        <h2>Basic Info</h2>
        <table>
            <tr>
                <td>Region</td>
                <td>{{ $to->subregion }}</td>
            </tr>
            <tr>
                <td>Capital</td>
                <td>{{ $to->capital }}</td>
            </tr>
            <tr>
                <td>Languages</td>
                <td>{{ implode(", ", $details['language']) }}</td>
            </tr>
            <tr>
                <td>Timezones</td>
                <td>{{ implode(", ", $details['timezone']) }}</td>
            </tr>
            <tr>
                <td>Currencies</td>
                <td>{{ implode(", ", $details['currency']) }}</td>
            </tr>
            <tr>
                <td>Borders to</td>
                <td>{{ implode(", ", $details['border']) }}</td>
            </tr>
            <tr>
                <td>Area</td>
                <td>{{ $to->area }} km2</td>
            </tr>
            <tr>
                <td>Population</td>
                <td>{{ $to->population }} </td>
            </tr>
            <tr>
                <td>Gini</td>
                <td>{{ $to->gini }}</td>
            </tr>
        </table>
    </div>
@endsection

@section('footer_scripts')

@stop