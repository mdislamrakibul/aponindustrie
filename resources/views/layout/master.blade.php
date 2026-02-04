<!DOCTYPE html>
<html>

@include('layout.head')

<body>
    @include('layout.header')
    @include('layout.mobile_header')


    @yield('content')


    @include('layout.footer')
    @include('layout.script')



</body>

</html>
