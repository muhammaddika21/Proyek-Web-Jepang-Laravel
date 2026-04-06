{{-- Footer — 100% COPY dari original index.html --}}
{{-- Semua styling ditangani oleh footer.css + sakura.css --}}
<footer class="main-footer">
    {{-- Sakura petal container (JS spawns petals here) --}}
    <div class="sakura-container" aria-hidden="true"></div>

    <div class="footer-top-row">
        {{-- LEFT: Logo + Text — exact copy --}}
        <div class="footer-col footer-left">
            <img
                src="{{ asset('images/Logo ukm nihon fix.png') }}"
                alt="Logo UKM"
                class="footer-logo"
            />
            <div class="footer-text-wrapper">
                <h3>Nihongo Bu</h3>
                <p>Belajar Bahasa & Budaya Jepang</p>
            </div>
        </div>

        {{-- CENTER: Social Media — exact copy --}}
        <div class="footer-col footer-center">
            <h4 class="social-title">Sosial Media :</h4>
            <div class="social-icons">
                <a href="#" class="social-btn"><i class="bi bi-instagram"></i><span class="social-label">Instagram</span></a>
                <a href="#" class="social-btn"><i class="bi bi-facebook"></i><span class="social-label">Facebook</span></a>
                <a href="#" class="social-btn"><i class="bi bi-discord"></i><span class="social-label">Discord</span></a>
            </div>
        </div>

        {{-- RIGHT: Pixel Sakura Tree — exact copy --}}
        <div class="footer-col footer-right">
            <div class="pixel-sakura" aria-hidden="true"></div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="footer-bottom-row">
        <p>&copy; {{ date('Y') }} Nihongo Bu STIS. All Rights Reserved.</p>
    </div>
</footer>
