<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
        <script src="/js/d3.min.js"></script>
        <script src="/js/topojson.min.js"></script>
        <script src="/js/datamaps.world.min.js"></script>
        <!-- <script src="/js//datamaps.world.hires.min.js"></script> -->
    </head>
    <body>
        <div class="container">

            <div id="map" style="position: relative; width: 500px; height: 300px;"></div>
            <!-- <div class="content">
                <div class="title">Laravel 5</div>
            </div> -->
        </div>
        <script>
            var map = new Datamap({
                element: document.getElementById('map'),
                responsive: true
            });

            window.addEventListener('resize', function(event){
                map.resize();
            });
        </script>
    </body>
</html>
