@if (isset($hreflang))
    {!! $hreflang !!}
@endif
@php
    if (isset($page)) {
        $og='images/ogy/ogview/'.$page.'.png';
    }
@endphp
@if (isset($og) && file_exists(public_path($og)))
    <title><?=$meta_title ?? '' ?></title>
    <meta property="og:site_name" content="Technical Calculator" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?=$cal_name ?? '' ?>" />
    <meta property="og:image" content="<?=url('images/ogview/ogy/'.$page.'.png')?>" />
    <meta property="og:url" content="<?=url()->current()?>" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@thetime-calculator.com " />
    <meta name="twitter:title" content="<?=$cal_name ?? '' ?>" />
    <meta name="twitter:description" content="<?=$meta_des ?? '' ?>">
    <meta name="twitter:image" content="<?=url('images/ogview/ogy/'.$page.'.png')?>">
    @else
    <title><?=$meta_title ?? '' ?></title>
    <link rel="canonical" href="{{ url()->current() }}" />
     <meta property="og:site_name" content="Technical Calculator" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Technical Calculator" />
        <meta property="og:image" content="<?=url('images/ogview/ogy/technical-calculator.png')?>" />
        <meta property="og:url" content="<?=url()->current()?>" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@thetime-calculator.com " />
        <meta name="twitter:title" content="Technical Calculator" />
        <meta name="twitter:description" content="<?=$meta_des ?? '' ?>">
        <meta name="twitter:image" content="<?=url('images/ogview/ogy/technical-calculator.png')?>">
    @endif