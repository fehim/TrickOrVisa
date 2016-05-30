var popup = $("#popup");
var oldRegion;

$(function(){
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

            console.log(code);
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

    fixComboWidth($("#input").val());

    $("vaadin-combo-box").on("value-changed",function(e){
        var newCountry = $(this).val();

        if (!newCountry) {
            return;
        }
        fixComboWidth(newCountry);
        $.get("/change-country/"+newCountry, function(result){
            removePopup();
            map.series.regions[0].setValues(result.visaRequirements);
            visaInfo = result.visaInfo;
        }, 'json');
    });

    $(".close").on("click", function(e) {
        removePopup();
    });
});

function fixComboWidth(text) {
    // vaadin combo box doesn't have auto width support for the input text
    // or i don't know how to use it

    // draw a canvas to calculate width, thanks to:
    // http://stackoverflow.com/questions/118241/calculate-text-width-with-javascript

    // re-use canvas object for better performance
    var canvas = fixComboWidth.canvas || (fixComboWidth.canvas = document.createElement("canvas"));
    var context = canvas.getContext("2d");
    context.font = "24px 'Lato'";
    var metrics = context.measureText(text);
    // 40 for down arrow and margins
    var newWidth = Math.round(metrics.width) + 45;
    $(".combo-container").width(newWidth);
    // 110 width of the text part
    $("#selector").width(110 + newWidth);
}


function removePopup() {
    var mapObject = $('#map').vectorMap('get', 'mapObject');
    mapObject.clearSelectedRegions();
    popup.hide();
    oldRegion = null;
}
