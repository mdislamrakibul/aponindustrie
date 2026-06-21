<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/logo/logo.png') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/slick.css') }}">

    {{-- From template-ecom-1 --}}
    {{--
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/chosen.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/color-01.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <style>
        /* --- Ticker Layout --- */
        .news-ticker-wrapper {
            width: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .marquee-viewport {
            width: 100%;
            overflow: hidden;
            position: relative;
            background: transparent;
            /* Matches your header background */
        }

        .marquee-content {
            display: flex;
            width: max-content;
            /* Dynamically fits the width of the news items */
            animation: scroll-left 25s linear infinite;
        }

        /* Pause when the user moves their mouse over the news */
        .marquee-content:hover {
            animation-play-state: paused;
        }

        .news-list {
            display: flex;
            flex-shrink: 0;
        }

        .news-item {
            white-space: nowrap;
            /* Forces text to stay on one line */
            padding: 0 15px;
            /* Spacing between news items */
            font-size: 13px;
            color: #253d4e;
            /* Professional dark blue color */
        }

        .news-item a {
            color: #0d3b66;
            /* Brand navy for links */
            font-weight: 600;
            text-decoration: underline;
        }

        /* --- THE CONTINUOUS LOOP ANIMATION --- */
        @keyframes scroll-left {
            0% {
                transform: translateX(0);
            }

            100% {
                /* Moves exactly half the total width (one full set) to restart invisibly */
                transform: translateX(-50%);
            }
        }

        /* Styling the Wrapper */
        .news-ticker-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            height: 30px;
            overflow: hidden;
        }

        .ticker-label {
            background: #e63946;
            color: white;
            padding: 0 20px;
            height: 100%;
            display: flex;
            align-items: center;
            font-weight: bold;
            z-index: 2;
            /* Keeps label above the moving text */
        }

        .featured-menu {
            border-top: 1px solid #f1f1f1;
            border-bottom: 1px solid #f1f1f1;
            padding: 5px 0;
        }

        .menu-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            /* Allows items to wrap on mobile */
        }

        /* --- Menu Item Styling --- */
        .menu-item {
            text-decoration: none;
            color: #253d4e;
            /* Dark professional blue/grey */
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            padding: 0 25px;
            position: relative;
            transition: color 0.3s ease;
        }

        .menu-item:hover {
            color: #0d3b66;
            /* Brand navy hover color */
        }

        /* --- Vertical Separators --- */
        .menu-item:not(:last-child)::after {
            content: "";
            position: absolute;
            right: 0;
            height: 20px;
            width: 1px;
            background-color: #dedfe2;
        }

        /* --- The "HOT" Badge --- */
        .badge {
            background-color: #ed4943;
            /* Orange color from image */
            color: #fff;
            font-size: 9px;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 8px;
            position: relative;
            line-height: 1;
            font-weight: 600;
        }

        /* The little triangle/tail on the badge */
        .badge::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            border-left: 5px solid #f39c12;
            border-bottom: 4px solid transparent;
        }


        /* WhatsApp Floating Button */
        .whatsapp-main {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .whatsapp-btn {
            background-color: #25d366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            text-decoration: none;
        }

        .whatsapp-btn:hover {
            transform: scale(1.1);
            color: white;
        }
    </style>
</head>