<button id="scrollToTopBtn" aria-label="Scroll to top" title="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

<style>
    #scrollToTopBtn {
        position: fixed;
        right: 20px;
        bottom: 90px;
        width: 46px;
        height: 46px;
        border: none;
        border-radius: 50%;
        background: #0d6efd;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: opacity .25s ease, transform .25s ease, visibility .25s;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #scrollToTopBtn.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    #scrollToTopBtn:hover { background: #0b5ed7; }
    @media (max-width: 576px) {
        #scrollToTopBtn { right: 14px; bottom: 80px; width: 42px; height: 42px; font-size: 16px; }
    }
</style>

<script>
    (function () {
        var btn = document.getElementById('scrollToTopBtn');
        if (!btn) return;
        function toggle() {
            if (window.pageYOffset > 200) btn.classList.add('show');
            else btn.classList.remove('show');
        }
        window.addEventListener('scroll', toggle, { passive: true });
        btn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        toggle();
    })();
</script>
