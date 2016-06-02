@extends('layouts.default')

@section('title')
    Trick Or Visa
@stop

@section('header_styles')
    <link href="{{ asset('css/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
    <link rel="import"
          href="https://cdn.vaadin.com/vaadin-core-elements/master/vaadin-combo-box/vaadin-combo-box.html">
@stop

@section('content')

    <div class="selector" id="selector">
        <h3 class="pull-left">I am from</h3>
        <div class="combo-container">
            <vaadin-combo-box name="country" items='{{ json_encode($countries) }}' value="{{ $currentLocation->countryName }}" required ></vaadin-combo-box>
        </div>
    </div>

    <div id="map" style="width: 100%;"></div>

    <div id="popup">
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="name">Iceland</h2>
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