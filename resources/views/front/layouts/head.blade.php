<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>El Hagry - @yield('front-title')</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="elhagry - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('front/assets')}}/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('front/assets')}}/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('front/assets')}}/images/icons/favicon-16x16.png">
    <link rel="manifest" href="{{asset('front/assets')}}/images/icons/site.html">
    <link rel="mask-icon" href="{{asset('front/assets')}}/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="{{asset('front/assets')}}/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="elhagry">
    <meta name="application-name" content="elhagry">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="{{asset('front/assets')}}/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet"
        href="{{asset('front/assets')}}/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{asset('front/assets')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('front/assets')}}/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="{{asset('front/assets')}}/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="{{asset('front/assets')}}/css/plugins/jquery.countdown.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('front/assets')}}/css/style.css">
    <link rel="stylesheet" href="{{asset('front/assets')}}/css/skins/skin-demo-6.css">
    <link rel="stylesheet" href="{{asset('front/assets')}}/css/demos/demo-6.css">

    @stack('front-css')
    @stack('front-cdn')
</head>