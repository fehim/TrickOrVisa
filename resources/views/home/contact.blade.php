@extends('layouts.default')

@section('title')
    Trick Or Visa
@stop

@section('header_styles')
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <style>
        .header {
            background: none !important;
        }
        body {
            background: transparent url('/img/contact.png') no-repeat 50% 50%;
        }
    </style>
@stop

@section('content')
    <div class="about text-center">
        <p>Write us: <a href="mailto:trickorvisa@gmail.com">trickorvisa@gmail.com</a> <br/><br/>
            Created by <a href="http://feh.im">Fehim Tabak</a> and <a href="http://inzare.com">Iulia Popa</a>
        </p>
    </div>
    <ul class="links text-center">
        <li>
            <a href="https://twitter.com/TrickOrVisa"> <i class="fa fa-twitter" aria-hidden="true"></i>Twitter</a>
        </li>
        <li>
            <a href="https://www.facebook.com/TrickOrVisa/"> <i class="fa fa-facebook" aria-hidden="true"></i>Facebook</a>
        </li>
        <li>
            <a href="https://github.com/fehim/TrickOrVisa"> <i class="fa fa-code-fork" aria-hidden="true"></i>Source Code</a>
        </li>
    </ul>

@endsection

@section('footer_scripts')
@stop