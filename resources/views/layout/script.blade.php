<!-- Vendor JS-->
<script src="{{ asset('assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/slick.js')}}"></script>
<script src="{{ asset('assets/js/plugins/wow.js')}}"></script>
<script src="{{ asset('assets/js/plugins/jquery-ui.js')}}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup.js')}}"></script>
<script src="{{ asset('assets/js/plugins/select2.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/jquery.theia.sticky.js')}}"></script>
<script src="{{ asset('assets/js/plugins/jquery.elevatezoom.js')}}"></script>
<!-- Template  JS -->
<script src="{{ asset('assets/js/main.js')}}"></script>
<script src="{{ asset('assets/js/shop.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const marquee = document.getElementById('newsMarquee');
        if (!marquee) return;
    });
</script>
@yield('custom_script')
