<!--Facebook Metadata /-->
<meta property="og:type" content="website" />
@if(!empty($meta['image']))
    <meta property="og:image" content="{{ url($meta['image']) }}"/>
@else
    <meta property="og:image" content="{{ url('api/v2/img/quantimodo-logo-qm-rainbow-150x150.jpg') }}"/>
@endif
@if(!empty($meta['description']))
    <meta property="og:description" content="{{ str_limit($meta['description'], $limit = 100, $end = '...') }}"/>
@else
    <meta property="og:description" content="Better living through data."/>
@endif
@if(!empty($meta['title']))
    <meta property="og:title" content="{{ $meta['title'] }}"/>
@else
    <meta property="og:title" content="Quantimodo"/>
@endif
        <!--Google+ Metadata /-->
@if(!empty($meta['title']))
    <meta itemprop="name" content="{{ $meta['title'] }}">
@else
    <meta itemprop="name" content="Quantimodo">
@endif
@if(!empty($meta['description']))
    <meta itemprop="description" content="{{ str_limit($meta['description'], $limit = 100, $end = '...') }}"/>
@else
    <meta itemprop="description" content="Better living through data."/>
@endif
@if(!empty($meta['image']))
    <meta itemprop="image" content="{{ url($meta['image']) }}"/>
@else
    <meta itemprop="image" content="{{ url('api/v2/img/quantimodo-logo-qm-rainbow-150x150.jpg') }}"/>
@endif
<!-- Twitter Metadata /-->
<meta name="twitter:card" content="summary"/>
<meta name="twitter:site" content="@quantimodo"/>
@if(!empty($meta['title']))
    <meta name="twitter:title" content="{{ $meta['title'] }}">
@else
    <meta name="twitter:title" content="Quantimodo">
@endif
@if(!empty($meta['description']))
    <meta name="twitter:description" content="{{ str_limit($meta['description'], $limit = 100, $end = '...') }}"/>
@else
    <meta name="twitter:description" content="Better living through data."/>
@endif
@if(!empty($meta['image']))
    <meta name="twitter:image" content="{{ url($meta['image']) }}"/>
@else
    <meta name="twitter:image" content="{{ url('api/v2/img/quantimodo-logo-qm-rainbow-150x150.jpg') }}"/>
@endif
<meta name="twitter:domain" content="{{ getenv('QM_API_HOST') }}">