<!--Facebook Metadata /-->
<meta property="og:type" content="website" />
@if(!empty($meta['image']))
    <meta property="og:image" content="{{ url($meta['image']) }}"/>
@endif
@if(!empty($meta['description']))
    <meta property="og:description" content="{{ str_limit($meta['description'], $limit = 100, $end = '...') }}"/>
@endif
<meta property="og:description" content="Check which countries you can visit without a visa"/>
@if(!empty($meta['title']))
    <meta property="og:title" content="{{ $meta['title'] }}"/>
@else
    <meta property="og:title" content="Trick or Visa"/>
@endif
        <!--Google+ Metadata /-->
@if(!empty($meta['title']))
    <meta itemprop="name" content="{{ $meta['title'] }}">
@else
    <meta itemprop="name" content="Trick or Visa">
@endif
@if(!empty($meta['description']))
    <meta itemprop="description" content="{{ str_limit($meta['description'], $limit = 100, $end = '...') }}"/>
@endif
@if(!empty($meta['image']))
    <meta itemprop="image" content="{{ url($meta['image']) }}"/>
@endif
<!-- Twitter Metadata /-->
<meta name="twitter:card" content="summary"/>
<meta name="twitter:site" content="@trickorvisa"/>
@if(!empty($meta['title']))
    <meta name="twitter:title" content="{{ $meta['title'] }}">
@else
    <meta name="twitter:title" content="Trick or Visa">
@endif
@if(!empty($meta['description']))
    <meta name="twitter:description" content="{{ str_limit($meta['description'], $limit = 100, $end = '...') }}"/>
@endif
@if(!empty($meta['image']))
    <meta name="twitter:image" content="{{ url($meta['image']) }}"/>
@endif