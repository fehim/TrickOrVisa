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