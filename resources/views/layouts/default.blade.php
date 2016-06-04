<html>
<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            | TrickOrVisa
        @show
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <!-- global level css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />--}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- end of global css-->
    <!-- page level styles-->
    <!-- end of page level styles-->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->
    @include('meta')
</head>
<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', '{{ env("GOOGLE_ANALYTICS") }}', 'auto');
    ga('send', 'pageview');

</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter{{ env("YANDEX_ANALYTICS") }} = new Ya.Metrika({
                    id:{{ env("YANDEX_ANALYTICS") }},
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/37750070" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<div class="container">
    <div class="header clearfix">
        <a href="/" id="logo">Trick <img id="earth" src="img/logo.png"/>r Visa</a>
        <nav>
            <ul class="nav pull-right">
                <li role="presentation"><a href="/">Home</a></li>
                <li role="presentation"><a href="/chat">Chat</a></li>
                <li role="presentation"><a href="/about">About</a></li>
            </ul>
        </nav>
    </div>
    @yield('content')
</div>
<!-- global js -->
<script src=" {{ asset('js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<script src=" {{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- begin page level js -->
@yield('footer_scripts')
<!-- end page level js -->

</body>
</html>