/**
 * Nihongo Bu STIS — Global Animation JS
 * Handles: Scroll reveal, Navbar compact, Footer reveal,
 *          Reading progress, Page transition, Sakura petals
 */

(function () {
  'use strict';

  /* ────────────────────────────────────────────────────
   * 0. SAKURA PETALS — auto-inject 8 petals into every hero section
   * ──────────────────────────────────────────────────── */
  document.querySelectorAll(
    'section.relative.overflow-hidden, header.relative.overflow-hidden'
  ).forEach(hero => {
    // Skip if already has petals
    if (hero.querySelector('.petal')) return;
    for (let i = 0; i < 8; i++) {
      const p = document.createElement('span');
      p.className = 'petal';
      hero.appendChild(p);
    }
  });

  /* ────────────────────────────────────────────────────
   * 1. SCROLL REVEAL — Intersection Observer
   * ──────────────────────────────────────────────────── */
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

  document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

  /* Section heading lines */
  const headingObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        headingObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });
  document.querySelectorAll('.section-heading').forEach(el => headingObserver.observe(el));

  /* Note boxes */
  const noteObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        noteObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });
  document.querySelectorAll('.note-box').forEach(el => noteObserver.observe(el));

  /* ────────────────────────────────────────────────────
   * 2. FOOTER REVEAL
   * ──────────────────────────────────────────────────── */
  const footerEl = document.querySelector('footer');
  if (footerEl) {
    const footerObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          footerEl.classList.add('is-visible');
          footerObserver.unobserve(footerEl);
        }
      });
    }, { threshold: 0.05 });
    footerObserver.observe(footerEl);
  }

  /* ────────────────────────────────────────────────────
   * 3. NAVBAR COMPACT ON SCROLL
   * ──────────────────────────────────────────────────── */
  // (Alpine.js already handles scrolled state in the navbar component)
  // This adds the CSS-driven compact class for non-Alpine fallback
  const navbar = document.getElementById('mainHeader');
  if (navbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 80) {
        navbar.classList.add('navbar--scrolled');
      } else {
        navbar.classList.remove('navbar--scrolled');
      }
    }, { passive: true });
  }

  /* ────────────────────────────────────────────────────
   * 4. READING PROGRESS BAR (article pages)
   * ──────────────────────────────────────────────────── */
  const progressBar = document.getElementById('reading-progress');
  if (progressBar) {
    window.addEventListener('scroll', () => {
      const scrollTop = window.scrollY;
      const docHeight = document.body.scrollHeight - window.innerHeight;
      const progress  = docHeight > 0 ? scrollTop / docHeight : 0;
      progressBar.style.transform = `scaleX(${Math.min(progress, 1)})`;
    }, { passive: true });
  }

  /* ────────────────────────────────────────────────────
   * 5. TABLE OF CONTENTS — Highlight active section
   * ──────────────────────────────────────────────────── */
  const tocLinks = document.querySelectorAll('.toc-link');
  if (tocLinks.length > 0) {
    const headings = Array.from(
      document.querySelectorAll('article h2[id], article h3[id]')
    );
    const tocObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = entry.target.id;
          tocLinks.forEach(link => {
            link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
          });
        }
      });
    }, { rootMargin: '-20% 0px -70% 0px' });
    headings.forEach(h => tocObserver.observe(h));
  }

  /* ────────────────────────────────────────────────────
   * 6. ARTICLE CARD — Scroll-triggered stagger reveal
   *    Each card animates when it enters the viewport.
   * ──────────────────────────────────────────────────── */
  const cardObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;

      const card  = entry.target;
      // Find position among visible siblings in same grid
      const grid  = card.parentElement;
      const siblings = grid ? Array.from(grid.querySelectorAll('.article-card')) : [card];
      const idx   = siblings.indexOf(card);

      card.style.transition = `opacity 500ms cubic-bezier(0.34,1.56,0.64,1) ${idx * 70}ms,
                               transform 500ms cubic-bezier(0.34,1.56,0.64,1) ${idx * 70}ms`;
      card.style.opacity    = '1';
      card.style.transform  = 'translateY(0) scale(1)';

      cardObserver.unobserve(card); // fire once
    });
  }, {
    threshold:  0.08,
    rootMargin: '0px 0px -40px 0px'
  });

  /* Set initial hidden state & start observing for every card now in DOM */
  function initCards() {
    document.querySelectorAll('.article-card').forEach(card => {
      card.style.opacity   = '0';
      card.style.transform = 'translateY(28px) scale(0.97)';
      cardObserver.observe(card);
    });
  }
  initCards();

  /* Re-run when filter JS swaps visible cards (expose globally) */
  window.revealArticleCards = initCards;

  /* ────────────────────────────────────────────────────
   * 7. HERO PARALLAX (desktop only, landing page)
   * ──────────────────────────────────────────────────── */
  const heroBg = document.querySelector('.hero-parallax-bg');
  if (heroBg && window.matchMedia('(min-width: 768px)').matches) {
    window.addEventListener('scroll', () => {
      heroBg.style.transform = `translateY(${window.scrollY * 0.3}px)`;
    }, { passive: true });
  }

  /* ────────────────────────────────────────────────────
   * 8. PAGE TRANSITIONS (View Transitions API)
   * ──────────────────────────────────────────────────── */
  if (document.startViewTransition) {
    document.querySelectorAll('a[href]').forEach(link => {
      const href = link.href;
      // Only same-origin, non-anchor, non-download links
      if (
        href &&
        href.startsWith(window.location.origin) &&
        !href.includes('#') &&
        !link.hasAttribute('download') &&
        !link.hasAttribute('target')
      ) {
        link.addEventListener('click', (e) => {
          e.preventDefault();
          document.startViewTransition(() => {
            window.location.href = href;
          });
        });
      }
    });
  }

  /* ────────────────────────────────────────────────────
   * 9. COPY BUTTON feedback (article detail)
   * ──────────────────────────────────────────────────── */
  const copyBtn = document.getElementById('copy-link-btn');
  if (copyBtn) {
    copyBtn.addEventListener('click', () => {
      navigator.clipboard.writeText(window.location.href).then(() => {
        copyBtn.classList.add('copied');
        setTimeout(() => copyBtn.classList.remove('copied'), 2000);
      });
    });
  }

  /* ────────────────────────────────────────────────────
   * 10. CAROUSEL swipe (mobile touch)
   * ──────────────────────────────────────────────────── */
  const carouselTrack = document.querySelector('.carousel-wrapper');
  if (carouselTrack) {
    let startX = 0;
    carouselTrack.addEventListener('touchstart', e => {
      startX = e.touches[0].clientX;
    }, { passive: true });
    carouselTrack.addEventListener('touchend', e => {
      const delta = e.changedTouches[0].clientX - startX;
      if (Math.abs(delta) > 50) {
        if (delta < 0 && typeof nextSlide === 'function') nextSlide();
        else if (typeof prevSlide === 'function') prevSlide();
      }
    }, { passive: true });
  }

  /* ────────────────────────────────────────────────────
   * 11. DOM ready — cards already handled by cardObserver above
   * ──────────────────────────────────────────────────── */
  // (initCards() already called — nothing extra needed)

})();
