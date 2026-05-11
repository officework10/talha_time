<title><?=$meta_title ?? '' ?></title>
<link rel="canonical" href="{{ rtrim(url()->current(), '/') }}/" />

<meta property="og:site_name" content="Thetime Calculator" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?=$cal_name ?? 'Thetime Calculator' ?>" />
<meta property="og:image" content="{{ url('thetimecalculator.png') }}" />
<meta property="og:url" content="{{ rtrim(url()->current(), '/') }}/" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@thetime-calculator.com" />
<meta name="twitter:title" content="<?=$cal_name ?? 'Thetime Calculator' ?>" />
<meta name="twitter:description" content="<?=$meta_des ?? '' ?>">
<meta name="twitter:image" content="{{ url('thetimecalculator.png') }}">