<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_des')">
    <link rel="canonical" href="{{ rtrim(url()->current(), '/') }}/" />
    <link href="{{ asset('logo.png') }}" rel="icon" type="image/x-icon" />
     <meta name="google-adsense-account" content="ca-pub-7193082976988035">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
      <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style_two.css') }}?v=1.0.2" />
    <link href="{{ asset('css/flowbite.min.css') }}?v=0.0.3" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @if (isset($noindex))
        {!! $noindex !!}
    @endif
    @include('layouts/metas')
    <style>
        .active-tags {
            color: #55be30 !important;
        }
    </style>
    @livewireStyles

    <!-- clarity -->
  <script type="text/javascript">
    (function (c, l, a, r, i, t, y) {
      c[a] = c[a] || function () { (c[a].q = c[a].q || []).push(arguments) };
      t = l.createElement(r); t.async = 1; t.src = "https://www.clarity.ms/tag/" + i;
      y = l.getElementsByTagName(r)[0]; y.parentNode.insertBefore(t, y);
    })(window, document, "clarity", "script", "sdhexxsxzo");
  </script>
  <!-- clarity -->
  <meta name="google-site-verification" content="nxk34mKPOypts6HIquQhPj4sZAxzFgK2hMmywdlvDpg" />
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-LY1NBHE7J7"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-LY1NBHE7J7');
  </script>
  <!-- ads -->

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7193082976988035"
    crossorigin="anonymous"></script>
</head>

<body>
    <button id="scrollToTopmove" class="scroll-to-tops hidden fixed right-6 bottom-[12px]" style="z-index: 999999;" aria-label="Scroll to top">
        <img src="{{ asset('assets/images/svgs/top_btn.svg') }}" alt="Scroll to top" width="40" height="40"></button>

    @include('layouts/header')
    <main>
        @section('content')
        @show
    </main>
    @include('layouts/footer')
    <script src="{{ asset('js/flowbite.min.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js" defer></script>
    @stack('mathjax')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('pdf-scripts')
    <script src="{{ asset('assets/js/website.js') }}?v=1.0.1" defer></script>
    <script src="{{ asset('js/javascriptCode.js') }}?v=1.0.2" defer></script>
    <script src="{{ asset('assets/js/add-calculator.js') }}?v=1.0.1" defer></script>

    @livewireScripts
    @stack('calculatorJS')
    @stack('scripts')
</body>

</html>
