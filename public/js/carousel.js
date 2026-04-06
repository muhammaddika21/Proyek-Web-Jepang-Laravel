document.addEventListener("DOMContentLoaded", function () {

    // ======================================================
    // 1. GALLERY DATA (UPDATE INI)
    // ======================================================
    const galleryData = [
        { 
            label: '', 
            image: '/images/kelas_onigiri.png'
        },
        { 
            label: '', 
            image: '/images/kelas_bahasa.png' 
        },
        { 
            label: '', 
            image: '/images/kelas_teh.png' 
        },
        { 
            label: '', 
            image: '/images/comifuro_trip.png' 
        },
        { 
            label: '', 
            image: '/images/Gathering.png' 
        },
        { 
            label: '', 
            image: '/images/6.png' 
        }
    ];
   

    let currentSlide = 0;
    let autoSlideInterval;
    let itemsPerSlide = 3;

    // ======================================================
    // 2. UPDATE RESPONSIVE ITEMS PER SLIDE
    // ======================================================
    function updateItemsPerSlide() {
        if (window.innerWidth <= 768) {
            itemsPerSlide = 1;
        } else if (window.innerWidth <= 1024) {
            itemsPerSlide = 2;
        } else {
            itemsPerSlide = 3;
        }
    }

    // ======================================================
    // 3. GENERATE CAROUSEL
    // ======================================================
    function generateCarousel() {
        const wrapper = document.getElementById('carouselWrapper');
        const dotsContainer = document.getElementById('carouselDots');

        if (!wrapper || !dotsContainer) {
            console.error("Carousel element NOT FOUND in HTML.");
            return;
        }

        wrapper.innerHTML = "";
        dotsContainer.innerHTML = "";

        const totalSlides = Math.ceil(galleryData.length / itemsPerSlide);

        for (let i = 0; i < totalSlides; i++) {
            const slide = document.createElement('div');
            slide.className = 'carousel-slide';

            const start = i * itemsPerSlide;
            const end = Math.min(start + itemsPerSlide, galleryData.length);

            for (let j = start; j < end; j++) {
                const item = galleryData[j];
                const galleryItem = document.createElement('div');
                galleryItem.className = 'gallery-item';

                // --- BAGIAN INI YANG DIUBAH ---
                // Kita masukkan URL gambar langsung ke style HTML
                // Kita tambah div 'overlay' agar tulisan terbaca jelas
                galleryItem.innerHTML = `
                    <div class="gallery-placeholder" style="background-image: url('${item.image}');">
                        <div class="gallery-overlay">
                            <h3>${item.label}</h3>
                        </div>
                    </div>
                `;
                // -----------------------------
                
                slide.appendChild(galleryItem);
            }

            wrapper.appendChild(slide);

            // DOTS
            const dot = document.createElement('button');
            dot.className = 'dot';
            if (i === 0) dot.classList.add('active');
            dot.addEventListener("click", () => goToSlide(i));
            dotsContainer.appendChild(dot);
        }
    }

    // ======================================================
    // 4. SLIDE FUNCTIONS
    // ======================================================
    function goToSlide(index) {
        const wrapper = document.getElementById('carouselWrapper');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = Math.ceil(galleryData.length / itemsPerSlide);

        currentSlide = (index + totalSlides) % totalSlides;

        wrapper.style.transform = `translateX(-${currentSlide * 100}%)`;

        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentSlide);
        });
    }

    function nextSlide() { goToSlide(currentSlide + 1); }
    function prevSlide() { goToSlide(currentSlide - 1); }

    function startAutoSlide() {
        stopAutoSlide();
        autoSlideInterval = setInterval(nextSlide, 3000);
    }

    function stopAutoSlide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
    }

    // ======================================================
    // 5. BUTTON EVENT LISTENERS
    // ======================================================
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');

    if (nextBtn && prevBtn) {
        nextBtn.addEventListener("click", () => {
            nextSlide();
            startAutoSlide();
        });

        prevBtn.addEventListener("click", () => {
            prevSlide();
            startAutoSlide();
        });
    }

    // ======================================================
    // 6. RESPONSIVE HANDLING
    // ======================================================
    window.addEventListener("resize", () => {
        updateItemsPerSlide();
        generateCarousel();
        goToSlide(0);
    });

    // ======================================================
    // 7. INITIALIZE CAROUSEL
    // ======================================================
    updateItemsPerSlide();
    generateCarousel();
    startAutoSlide();
});
