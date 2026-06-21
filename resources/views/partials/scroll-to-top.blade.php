<button id="scrollToTopBtn" aria-label="Scroll to top" title="Back to top">
    <i class="fa fa-arrow-up"></i>
</button>

<style>
    #scrollToTopBtn {
        position: fixed;
        right: 20px;
        bottom: 90px;
        width: 48px;
        height: 48px;
        border: none;
        border-radius: 50%;
        background: var(--brand-navy, #0d3b66);
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(13, 59, 102, .35);
        opacity: 0;
        visibility: hidden;
        transform: translateY(12px);
        transition: opacity .25s ease, transform .25s ease, visibility .25s, background .2s;
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
    #scrollToTopBtn:hover {
        background: var(--brand-red, #c54836);
        box-shadow: 0 6px 20px rgba(197, 72, 54, .40);
        transform: translateY(-2px);
    }
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
