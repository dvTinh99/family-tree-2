// set year
document.getElementById('year').textContent = new Date().getFullYear();

// Language selector: redirect to set locale
const langSelect = document.getElementById('langSelect');
if (langSelect) {
    langSelect.addEventListener('change', (e) => {
        window.location.href = `/lang/${e.target.value}`;
    });
}

// GSAP: enhanced animations and scroll interactions
if (typeof gsap !== 'undefined') {
    gsap.registerPlugin(ScrollTrigger);

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Hero entrance (staggered)
    if (!prefersReduced) {
        gsap.from('.hero-title', {
            y: 36,
            opacity: 0,
            duration: 0.9,
            ease: 'power3.out'
        });
        gsap.from('.hero-sub', {
            y: 18,
            opacity: 0,
            duration: 0.8,
            delay: 0.18,
            ease: 'power3.out'
        });
        gsap.from('.hero-cta', {
            scale: 0.98,
            opacity: 0,
            duration: 0.7,
            delay: 0.38,
            ease: 'back.out(1.1)'
        });
    } else {
        gsap.from('.hero-title, .hero-sub, .hero-cta', {
            opacity: 0,
            duration: 0.6
        });
    }

    // Global section reveal with stagger; uses existing .fade-in elements
    gsap.utils.toArray('.fade-in').forEach((el, i) => {
        gsap.fromTo(el, {
            y: prefersReduced ? 0 : 20,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.7,
            ease: 'power3.out',
            delay: 0.06 * (i % 6),
            scrollTrigger: {
                trigger: el,
                start: 'top 88%'
            }
        });
    });

    // Feature cards stagger (slightly bouncy)
    gsap.from('.feature-card', {
        y: 20,
        opacity: 0,
        duration: 0.7,
        ease: 'power3.out',
        stagger: 0.12,
        scrollTrigger: {
            trigger: '#features',
            start: 'top 85%'
        }
    });

    // Hero visual subtle parallax
    const heroVisual = document.querySelector('.hero-visual');
    if (heroVisual && !prefersReduced) {
        gsap.to(heroVisual, {
            y: -28,
            ease: 'none',
            scrollTrigger: {
                scrub: 0.6,
                start: 'top top',
                end: 'bottom top'
            }
        });
    }

    // CTA gentle pulse on hover (paused by default)
    const cta = document.querySelector('.hero-cta');
    if (cta && !prefersReduced) {
        const pulse = gsap.to(cta, {
            scale: 1.03,
            duration: 1.2,
            ease: 'sine.inOut',
            repeat: -1,
            yoyo: true,
            paused: true
        });
        cta.addEventListener('mouseenter', () => pulse.play());
        cta.addEventListener('focus', () => pulse.play());
        cta.addEventListener('mouseleave', () => pulse.pause());
        cta.addEventListener('blur', () => pulse.pause());
    }

    // Demo image tilt / micro-parallax for pointer movement
    const demoImgs = document.querySelectorAll('.demo-img');
    demoImgs.forEach((img) => {
        if (prefersReduced) return;
        img.style.transformOrigin = 'center';
        img.addEventListener('pointermove', (ev) => {
            const rect = img.getBoundingClientRect();
            const px = (ev.clientX - rect.left) / rect.width - 0.5; // -0.5 .. 0.5
            const py = (ev.clientY - rect.top) / rect.height - 0.5;
            gsap.to(img, {
                rotationY: px * 6,
                rotationX: -py * 6,
                scale: 1.02,
                duration: 0.4,
                ease: 'power1.out'
            });
        });
        img.addEventListener('pointerleave', () => gsap.to(img, {
            rotationY: 0,
            rotationX: 0,
            scale: 1,
            duration: 0.6,
            ease: 'power2.out'
        }));
    });

    // Navigation: smooth scroll and active link highlight using IntersectionObserver
    document.documentElement.style.scrollBehavior = 'smooth';
    const navLinks = document.querySelectorAll('header nav a');
    const sections = Array.from(navLinks).map(a => {
        try {
            return document.querySelector(a.getAttribute('href'));
        } catch (e) {
            return null;
        }
    }).filter(Boolean);
    if ('IntersectionObserver' in window && sections.length) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const id = entry.target.id;
                const link = document.querySelector(`header nav a[href="#${id}"]`);
                if (link) {
                    if (entry.isIntersecting) link.classList.add('text-indigo-600');
                    else link.classList.remove('text-indigo-600');
                }
            });
        }, {
            threshold: 0.45
        });
        sections.forEach(s => obs.observe(s));
    }
}

// Accessibility: enable keyboard focus visible styles
document.addEventListener('keyup', (e) => {
    if (e.key === 'Tab') document.documentElement.classList.add('user-tabbed');
});