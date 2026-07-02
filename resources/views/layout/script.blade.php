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
<script src="{{ asset('assets/js/plugins/waypoints.js')}}"></script>
<script src="{{ asset('assets/js/plugins/counterup.js')}}"></script>
<script src="{{ asset('assets/js/plugins/images-loaded.js')}}"></script>
<script src="{{ asset('assets/js/plugins/isotope.js')}}"></script>
<script src="{{ asset('assets/js/plugins/jquery.countdown.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/jquery.vticker-min.js')}}"></script>
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
<script>
(function () {
    function initBurgerMenu() {
        var burger = document.querySelector('.burger-icon');
        var sidebar = document.querySelector('.mobile-header-active');
        var closeBtn = document.querySelector('.mobile-menu-close');

        if (!burger || !sidebar) return;

        function openMenu(e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.add('sidebar-visible');
            document.body.classList.add('mobile-menu-active');
            var dropdown = document.querySelector('.categori-dropdown-active-small');
            if (dropdown) dropdown.style.display = 'block';
        }

        function closeMenu() {
            sidebar.classList.remove('sidebar-visible');
            document.body.classList.remove('mobile-menu-active');
            var dropdown = document.querySelector('.categori-dropdown-active-small');
            if (dropdown) dropdown.style.display = 'none';
        }

        burger.addEventListener('touchstart', openMenu, { passive: false });
        burger.addEventListener('click', openMenu);

        if (closeBtn) {
            closeBtn.addEventListener('touchstart', closeMenu, { passive: true });
            closeBtn.addEventListener('click', closeMenu);
        }

        document.addEventListener('touchstart', function (e) {
            if (sidebar.classList.contains('sidebar-visible') && !sidebar.contains(e.target) && !burger.contains(e.target)) {
                closeMenu();
            }
        }, { passive: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBurgerMenu);
    } else {
        initBurgerMenu();
    }
})();
</script>
