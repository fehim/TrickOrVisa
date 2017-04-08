@extends('layouts.default')

@section('title')
    Trick Or Visa
@stop

@section('header_styles')
    <link href="{{ asset('css/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('css/selectize.theme.css') }}" rel="stylesheet" /> --}}
    <style>
        .legend .from {
            background-color: {!! config('map.colors.from') !!}
        }

        .legend .yes {
            background-color: {!! config('map.colors.yes') !!}
        }

        .legend .no {
            background-color: {!! config('map.colors.no') !!}
        }

        .legend .default {
            background-color: {!! config('map.colors.default') !!}
        }
        .home-header {
            background: transparent url('/img/home.png') no-repeat 50% 56%;
        }
    </style>
@stop

@section('topContent')
    <p class="to-go text-center">
        Can't decide where to go?
    </p>
@endsection

@section('content')

    <div class="selector clearfix" id="selector">
        <h3 class="text-center">I am from</h3>

        <select id="countries">
            @foreach ($countries as $countryCode => $countryName)
                <option {{ $countryCode == $currentLocation ? 'selected=selected' : '' }} value="{{ $countryCode }}">{{ $countryName }}</option>
            @endforeach
        </select>
    </div>
    <ul class="legend clearfix">
        <li> <span class="from"></span> Your Country</li>
        <li> <span class="yes"></span> Visa Free</li>
        <li> <span class="no"></span> Visa Required</li>
        <li> <span class="default"></span> No data</li>
    </ul>

    <div id="map" style="width: 100%;"></div>

    <div id="popup">
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="name"></h2>
        <div class="visa-info">

        </div>
        <a class="more-link" href="">More?</a>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('js/selectize.js') }}"></script>
    <script>
        $(function(){

            $('#countries').selectize();

            visaColors = {!! json_encode($visaRequirements) !!};
            visaInfo = {!! json_encode($visaInfo) !!};
            countryInfo = {!! json_encode($countryInfo) !!};
            defaultColor = "{!! config('map.colors.default') !!}";
            strokeColor = "{!! config('map.colors.stroke') !!}";
            hoverColor = "{!! config('map.colors.hover') !!}";

        });
    </script>
    <script src="{{ asset('js/home.js') }}"></script>
@stop