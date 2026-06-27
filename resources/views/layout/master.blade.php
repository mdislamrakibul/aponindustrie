<!DOCTYPE html>
<html>

@include('layout.head')

<body style="overflow: hidden;">
    {{-- Preloader: covers page until JS + images finish loading --}}
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div style="text-align:center;">
                <img src="{{ asset('assets/imgs/logo/logo.png') }}" alt="Loading..." style="max-height:60px; opacity:0.7; animation: pulse 1s ease-in-out infinite alternate;">
            </div>
        </div>
    </div>
    <style>
        @keyframes pulse { from { opacity: 0.4; } to { opacity: 1; } }
        .preloader { background: #fff; position: fixed; top:0; left:0; right:0; bottom:0; z-index: 999999; }
    </style>

    <div class="whatsapp-main">
    <a href="https://wa.me/8801992977251?text={{ rawurlencode('Hello! How may I help you with your question.') }}"
       class="whatsapp-btn"
       target="_blank">
        <i class="fa fa-whatsapp"></i>
    </a>
</div>
    @include('layout.header')
    @include('layout.mobile_header')


    @yield('content')


    @include('layout.footer')
    @include('layout.script')
    @include('partials.scroll-to-top')

</body>

</html>
