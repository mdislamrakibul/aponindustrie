<!DOCTYPE html>
<html>

@include('layout.head')

<body style="overflow: hidden;">
    {{-- Preloader: covers page until JS + images finish loading --}}
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div style="text-align:center;">
                <div class="apon-loader" role="status" aria-label="Loading">
                    <span class="apon-loader__ring"></span>
                </div>
            </div>
        </div>
    </div>
    <style>
        .preloader { background: #fff; position: fixed; top:0; left:0; right:0; bottom:0; z-index: 999999; }
        .apon-loader { width: 56px; height: 56px; display: inline-block; }
        .apon-loader__ring {
            box-sizing: border-box;
            display: block;
            width: 56px; height: 56px;
            border-radius: 50%;
            border: 4px solid rgba(13,59,102,.15);
            border-top-color: #0d3b66;
            animation: apon-spin .8s linear infinite;
        }
        @keyframes apon-spin { to { transform: rotate(360deg); } }
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
