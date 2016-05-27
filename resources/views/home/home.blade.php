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
            <vaadin-combo-box name="country" items='{{ json_encode($countries) }}' value="{{ $currentLocation->countryName }}" required label="..."></vaadin-combo-box>
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

            var visaColors = {!! json_encode($visaRequirements) !!};
            var visaInfo = {!! json_encode($visaInfo) !!};

            var popup = $("#popup");
            var oldRegion;
            var map = new jvm.Map({
                container: $('#map'),
                map: 'world_mill',
                backgroundColor: "#EAE3D3",
                zoomOnScroll: false,
                regionStyle: {
                  initial: {
                    fill: '#E39165',
                    stroke: "none",
                    "stroke-width": 0,
                    "stroke-opacity": 1
                  },
                  hover: {
                      fill: '#429FB6'
                  },
                    selected: {
                      fill: '#429FB6',
                      "fill-opacity": 0.8
                    },
                    selectedHover: {
                        "fill-opacity": 0.6
                    }
                },
                series: {
                    regions: [{
                        attribute: 'fill'
                    }]
                },
                regionsSelectable: true,
                regionsSelectableOne: true,
                onRegionClick: function(e, code) {
                    //var oldRegion = window.localStorage.getItem('map-selected-region');
                    if (oldRegion == code) {
                        return false;
                    }

                    popup.css({
                        'left': event.pageX,
                        'top': event.pageY,
                        'display': 'inline',
                        'position': 'absolute'
                    });

                    popup.find(".name").text(
                        //countries[code]
                        map.getRegionName(code)
                    );

                    var info = visaInfo[code];
                    if (typeof info !== "undefined") {
                        var infoText = "<p>" + info[0] + "</p>" +
                                "<p>" + info[1] + "</p>";
                        popup.find(".visa-info").html(infoText);
                    } else {
                        popup.find(".visa-info").html("<p>No data for this country yet.</p>");
                    }

                    oldRegion = code;
                    if (window.localStorage) {
                        window.localStorage.setItem(
                            'map-selected-region',
                            code
                        );
                    }
                },
                onViewportChange: function(e, scale) {
                    removePopup();
                }
            });

            map.series.regions[0].setValues(visaColors);

            function removePopup() {
                var mapObject = $('#map').vectorMap('get', 'mapObject');
                mapObject.clearSelectedRegions();
                popup.hide();
                oldRegion = null;
            }

            $("vaadin-combo-box").on("value-changed",function(e){
                var newCountry = $(this).val();

                if (!newCountry) {
                    return false;
                }

                $.get("/change-country/"+newCountry, function(result){
                    removePopup();
                    map.series.regions[0].setValues(result.visaRequirements);
                    visaInfo = result.visaInfo;
                }, 'json');
            });

//            $(".html").on("click", ".item", function(e){
//               console.log($("#input").val());
//            });

            $(".close").on("click", function(e) {
                console.log("e");
                removePopup();
            });

        });
    </script>
@stop