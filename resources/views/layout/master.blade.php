<!DOCTYPE html>
<html>

@include('layout.head')

<body>
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
