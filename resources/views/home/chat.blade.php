@extends('layouts.default')

@section('title')
    Trick Or Visa
@stop

@section('header_styles')
@stop

@section('content')

    <div id="tlkio" data-channel="trickorvisa" data-theme="theme--night" style="width:100%;height:400px;"></div><script async src="http://tlk.io/embed.js" type="text/javascript"></script>

@endsection

@section('footer_scripts')
@stop