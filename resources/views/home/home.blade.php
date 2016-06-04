@extends('layouts.default')

@section('title')
    Trick Or Visa
@stop

@section('header_styles')
    <link href="{{ asset('css/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
    <link rel="import"
          href="https://cdn.vaadin.com/vaadin-core-elements/master/vaadin-combo-box/vaadin-combo-box.html">
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
    </style>
@stop

@section('content')

    <div class="selector clearfix" id="selector">
        <h3 class="pull-left">I am from</h3>
        <div class="combo-container">
            <vaadin-combo-box name="country" items='{{ json_encode($countries) }}' value="{{ $currentLocation->countryName }}" required ></vaadin-combo-box>
        </div>
    </div>
    <ul class="legend clearfix">
        <li> <span class="from"></span> Your Country</li>
        <li> <span class="yes"></span> Visa Free/E-Visa</li>
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
        {{--<a href="#">You want more?</a>--}}
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-jvectormap-world-mill.js') }}"></script>

    <script src="https://cdn.vaadin.com/vaadin-core-elements/latest/webcomponentsjs/webcomponents-lite.min.js"></script>
    <script>
        $(function(){

            visaColors = {!! json_encode($visaRequirements) !!};
            visaInfo = {!! json_encode($visaInfo) !!};
            defaultColor = "{!! config('map.colors.default') !!}";
            strokeColor = "{!! config('map.colors.stroke') !!}";
            hoverColor = "{!! config('map.colors.hover') !!}";

        });
    </script>
    <script src="{{ asset('js/home.js') }}"></script>
@stop