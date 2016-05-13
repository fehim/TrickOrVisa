<html>
<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            | TrickOrVisa
        @show
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- end of global css-->
    <!-- page level styles-->
    <!-- <link href="{!! asset('api/v2/css/custom_css/login.css') !!}" rel="stylesheet" type="text/css"> -->
    <!-- end of page level styles-->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->
    @include('meta')
</head>
<body>
<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav pull-right">
                <li role="presentation" class="active"><a href="#">Tricks & Tips</a></li>
                <li role="presentation"><a href="#">Contact</a></li>
            </ul>
        </nav>
        <h3 id="logo">Trick Or Visa</h3>
    </div>
    @yield('content')
</div>
<!-- global js -->
<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js" type="text/javascript"></script>
<!-- begin page level js -->
@yield('footer_scripts')
<!-- end page level js -->
</body>
</html>