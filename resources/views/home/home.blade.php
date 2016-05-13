@extends('layouts.default')

@section('title')
    Trick Or Visa
@stop

@section('header_styles')
    <link href="{{ asset('css/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
@stop

@section('content')
    <div id="map" style="width: 100%;"></div>

    <div id="popup">
        <h2 class="name">Iceland</h2>
        <p>Visa not required</p>
        <p>You can stay 3 months in a 6 months period of time</p>
        <a href="#">You want more?</a>
    </div>
    <!-- position: relative; -->
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-jvectormap-world-mill.js') }}"></script>
    <!-- 
    <script src=""></script>
    <script src="{{ asset('js/topojson.min.js') }}"></script>
    <script src="{{ asset('js/datamaps.world.min.js') }}"></script>
 -->
    <script>
        $(function(){
            $('#map').vectorMap({
                map: 'world_mill',
                backgroundColor: "#262323",
                zoomOnScroll: false,
                regionStyle: {
                  initial: {
                    fill: '#59D9A4',
                    stroke: "none",
                    "stroke-width": 0,
                    "stroke-opacity": 1
                  },
                  hover: {
                    fill: '#818FF0'
                  },
                  selected: {
                    fill: '#818FF0'
                  }
                },
                regionsSelectable: true,
                regionsSelectableOne: true,
                onRegionClick: function(e, code) {
                    var oldRegion = window.localStorage.getItem('map-selected-region')
                    if (oldRegion == code) {
                        return false;
                    }

                    $('#popup').css('left',event.pageX);      // <<< use pageX and pageY
                    $('#popup').css('top',event.pageY);
                    $('#popup').css('display','inline');     
                    $("#popup").css("position", "absolute");  // <<< also make it absolute!

                    if (window.localStorage) {
                        window.localStorage.setItem(
                            'map-selected-region',
                            code
                        );
                    }
                }
            });
        });
        // var map = new Datamap({
        //     element: document.getElementById('map'),
        //     fills: {
        //       defaultFill: "#59D9A4",
        //       authorHasTraveledTo: "#fa0fa0"
        //     },
        //     responsive: true,
        //     geographyConfig: {
        //         dataUrl: null, //if not null, datamaps will fetch the map JSON (currently only supports topojson)
        //         hideAntarctica: true,
        //         borderWidth: 1,
        //         borderOpacity: 1,
        //         borderColor: '#262323',
        //         popupTemplate: function(geography, data) { //this function should just return a string
        //           return '<div class="hoverinfo"><strong>' + geography.properties.name + '</strong></div>';
        //         },
        //         popupOnHover: true, //disable the popup while hovering
        //         highlightOnHover: true,
        //         highlightFillColor: '#FC8D59',
        //         highlightBorderColor: 'rgba(250, 15, 160, 0.2)',
        //         highlightBorderWidth: 2,
        //         highlightBorderOpacity: 1
        //     },
        //     projection: 'mercator',
        // });

        // window.addEventListener('resize', function(event){
        //     map.resize();
        // });
    </script>
@stop