<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ __('messages.meta.title') }}</title>
  <meta name="description" content="{{ __('messages.meta.desc') }}" />
  <meta name="keywords" content="family tree, genealogy, visual editor, auto layout, relationship editor, tree visualization" />
  <link rel="canonical" href="/" />

  <!-- Open Graph -->
  <meta property="og:title" content="{{ __('messages.og.title') }}" />
  <meta property="og:description" content="{{ __('messages.og.desc') }}" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="/" />
  <meta property="og:image" content="/preview.png" />

  <!-- Tailwind via CDN (no build tools) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- GSAP for smooth animations; ScrollTrigger plugin -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

  <style>
    /* Small custom styles for layout & accessibility */
    :root {
      --accent: #4f46e5;
      --muted: #6b7280;
      --bg: #f8fafc;
    }
    html,body { height:100%; }
    .hero-visual { border-radius: 12px; box-shadow: 0 20px 40px rgba(2,6,23,0.08); overflow: hidden; background: #fff; }
    .feature-icon { width:48px; height:48px; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; background:linear-gradient(135deg,#eef2ff,#ffffff); color:var(--accent); }
    .kicker { font-weight:600; color:var(--accent); letter-spacing:0.06em; text-transform:uppercase; font-size:12px; }
    .fade-in { opacity:0; transform:translateY(16px); }
    .cta-primary { background:var(--accent); color: #fff; }
    .sr-only { position:absolute; height:1px; width:1px; overflow:hidden; clip:rect(1px,1px,1px,1px); white-space:nowrap; }
    @media (prefers-reduced-motion: reduce) { .no-motion { transition: none !important; } }
  </style>
</head>
<body class="bg-gray-50 text-slate-900 leading-relaxed">

  <header class="bg-white/60 backdrop-blur sticky top-0 z-50 border-b">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="/" class="flex items-center gap-3" aria-label="Family Tree Builder Home">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" aria-hidden>
          <rect width="24" height="24" rx="6" fill="#eef2ff"/>
          <path d="M8 13c1.657 0 3-1.567 3-3.5S9.657 6 8 6 5 7.567 5 9.5 6.343 13 8 13zM16 11a2 2 0 100-4 2 2 0 000 4z" fill="#4f46e5"/>
        </svg>
        <span class="font-semibold">Family Tree Builder</span>
      </a>
      <nav aria-label="Top" class="flex items-center gap-4">
        <ul class="flex gap-4 items-center text-sm">
          <li><a href="#features" class="text-slate-700 hover:text-black">{{ __('messages.nav.features') }}</a></li>
          <li><a href="#demo" class="text-slate-700 hover:text-black">{{ __('messages.nav.demo') }}</a></li>
          <li><a href="#trust" class="text-slate-700 hover:text-black">{{ __('messages.nav.trust') }}</a></li>
          <li><a href="#contact" class="px-3 py-2 rounded-md border bg-white hover:bg-gray-100">{{ __('messages.nav.contact') }}</a></li>
        </ul>
        <label for="langSelect" class="sr-only">Language</label>
        <select id="langSelect" aria-label="Select language" class="ml-4 border rounded-md px-2 py-1 text-sm">
          <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
          <option value="vi" {{ app()->getLocale() === 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
          <option value="es" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>Español</option>
        </select>
      </nav>
    </div>
  </header>

  <main>

    <!-- Hero -->
    <section class="max-w-6xl mx-auto px-4 py-16 grid gap-8 grid-cols-1 md:grid-cols-2 items-center">
      <div>
        <p class="kicker">{{ __('messages.hero.kicker') }}</p>
        <h1 class="mt-4 text-3xl md:text-5xl font-extrabold tracking-tight hero-title">{{ __('messages.hero.title') }}</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-xl hero-sub">{{ __('messages.hero.sub') }}</p>

        <div class="mt-6 flex gap-4 items-center">
          <a href="#demo" class="cta-primary px-5 py-3 rounded-md shadow hover:shadow-lg transition hero-cta">{{ __('messages.cta.primary') }}</a>
          <a href="#features" class="px-4 py-3 rounded-md border hover:bg-gray-50">{{ __('messages.cta.secondary') }}</a>
        </div>

        <ul class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
          <li>{!! __('messages.hero.benefit1') !!}</li>
          <li>{!! __('messages.hero.benefit2') !!}</li>
          <li>{!! __('messages.hero.benefit3') !!}</li>
          <li>{!! __('messages.hero.benefit4') !!}</li>
        </ul>
      </div>

      <div class="hero-visual p-4 fade-in" aria-hidden="true">
        <!-- Placeholder screenshot; replace with real screenshot or embed iframe / demo -->
        <img src="http://app.family.test/images/demo.webp" alt="Interactive family tree preview" class="w-full rounded-md shadow-sm" />
        {{-- <figcaption class="mt-2 text-xs text-muted">Interactive editor preview (click Demo to open live)</figcaption> --}}
      </div>
    </section>

    <!-- Problem → Solution -->
    <section id="problem" class="bg-white">
      <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid gap-8 md:grid-cols-2 items-start">
          <div class="fade-in">
            <h2 class="text-2xl font-bold">{{ __('messages.problem.title') }}</h2>
            <p class="mt-4 text-gray-600">{{ __('messages.problem.desc') }}</p>
              <h3 class="mt-6 text-lg font-semibold">Where other tools fall short</h3>
              <ul class="mt-3 list-disc list-inside text-gray-600">
                <li>Static exports that need manual cleanup</li>
                <li>Limited controls for complex relationships</li>
                <li>Large trees that overwhelm readers</li>
              </ul>
            </div>

            <div class="fade-in">
            <h2 class="text-2xl font-bold">{{ __('messages.solution.title') }}</h2>
            <p class="mt-4 text-gray-600">{{ __('messages.solution.desc') }}</p>
            <p class="mt-4 text-gray-600">{{ __('messages.solution.note') }}</p>
            </div>
        </div>
      </div>
    </section>

    <!-- Features -->
    <section id="features" class="max-w-6xl mx-auto px-4 py-12">
        <div class="text-center">
        <h2 class="text-3xl font-bold">{{ __('messages.features.title') }}</h2>
        <p class="mt-2 text-gray-600 max-w-2xl mx-auto">{{ __('messages.features.subtitle') }}</p>
        </div>

      <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <!-- icon -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 7a4 4 0 110-8 4 4 0 010 8zM21 23v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2" stroke="#4f46e5" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 class="font-semibold">{{ __('messages.feature.auto.title') }}</h3>
          <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.auto.desc') }}</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 12v0" stroke="#4f46e5" stroke-width="1.6" stroke-linecap="round"/></svg>
          </div>
          <h3 class="font-semibold">{{ __('messages.feature.spouse.title') }}</h3>
          <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.spouse.desc') }}</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 3h18v18H3z" stroke="#4f46e5" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 class="font-semibold">{{ __('messages.feature.collapse.title') }}</h3>
          <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.collapse.desc') }}</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2l3 8H9l3-8z" stroke="#4f46e5" stroke-width="1.6"/></svg>
          </div>
          <h3 class="font-semibold">{{ __('messages.feature.edit.title') }}</h3>
          <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.edit.desc') }}</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M21 8v8" stroke="#4f46e5" stroke-width="1.6"/></svg>
          </div>
          <h3 class="font-semibold">{{ __('messages.feature.export.title') }}</h3>
          <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.export.desc') }}</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 20v-6" stroke="#4f46e5" stroke-width="1.6"/></svg>
          </div>
          <h3 class="font-semibold">{{ __('messages.feature.private.title') }}</h3>
          <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.private.desc') }}</p>
        </article>
      </div>
    </section>

    <!-- How it works -->
    <section id="how" class="bg-white/50">
      <div class="max-w-5xl mx-auto px-4 py-12 text-center">
        <h2 class="text-2xl font-bold">{{ __('messages.how.title') }}</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div class="p-6 bg-white rounded-lg fade-in">
            <div class="text-2xl font-semibold">{{ __('messages.how.step1.title') }}</div>
            <p class="mt-2 text-gray-600">{{ __('messages.how.step1.desc') }}</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <div class="text-2xl font-semibold">{{ __('messages.how.step2.title') }}</div>
            <p class="mt-2 text-gray-600">{{ __('messages.how.step2.desc') }}</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <div class="text-2xl font-semibold">{{ __('messages.how.step3.title') }}</div>
            <p class="mt-2 text-gray-600">{{ __('messages.how.step3.desc') }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Demo / Screenshots -->
    <section id="demo" class="max-w-6xl mx-auto px-4 py-12">
      <h2 class="text-2xl font-bold text-center">{{ __('messages.demo.title') }}</h2>
      <p class="text-center text-gray-600 mt-2">{{ __('messages.demo.desc') }}</p>

      <div class="mt-6 grid gap-4 md:grid-cols-3">
        <figure class="bg-white p-3 rounded-lg shadow-sm fade-in">
          <img src="https://via.placeholder.com/600x360?text=Editor+Preview" alt="Family tree editor preview screenshot" class="w-full rounded-md demo-img" />
          <figcaption class="text-xs text-gray-500 mt-2">Editor preview — add nodes and relations</figcaption>
        </figure>
        <figure class="bg-white p-3 rounded-lg shadow-sm fade-in">
          <img src="https://via.placeholder.com/600x360?text=Auto+Layout" alt="Auto layout example" class="w-full rounded-md demo-img" />
          <figcaption class="text-xs text-gray-500 mt-2">Auto layout handling spouses and parents</figcaption>
        </figure>
        <figure class="bg-white p-3 rounded-lg shadow-sm fade-in">
          <img src="https://via.placeholder.com/600x360?text=Collapse+Branches" alt="Collapsed branches preview" class="w-full rounded-md demo-img" />
          <figcaption class="text-xs text-gray-500 mt-2">Collapse long branches for focus</figcaption>
        </figure>
      </div>
    </section>

    <!-- Use cases -->
    <section id="usecases" class="bg-white/50">
      <div class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-center">{{ __('messages.usecases.title') }}</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div class="p-6 bg-white rounded-lg fade-in">
            <h3 class="font-semibold">{{ __('messages.usecase.researchers.title') }}</h3>
            <p class="mt-2 text-gray-600">{{ __('messages.usecase.researchers.desc') }}</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <h3 class="font-semibold">{{ __('messages.usecase.historians.title') }}</h3>
            <p class="mt-2 text-gray-600">{{ __('messages.usecase.historians.desc') }}</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <h3 class="font-semibold">{{ __('messages.usecase.educators.title') }}</h3>
            <p class="mt-2 text-gray-600">{{ __('messages.usecase.educators.desc') }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Trust / Tech -->
    <section id="trust" class="max-w-6xl mx-auto px-4 py-12">
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div class="fade-in">
          <h2 class="text-2xl font-bold">{{ __('messages.trust.title') }}</h2>
          <p class="mt-4 text-gray-600">{{ __('messages.trust.desc') }}</p>
          <ul class="mt-4 text-gray-600 list-disc list-inside">
            <li>{{ __('messages.trust.b1') }}</li>
            <li>{{ __('messages.trust.b2') }}</li>
            <li>{{ __('messages.trust.b3') }}</li>
            <li>{{ __('messages.trust.b4') }}</li>
          </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm fade-in">
          <h3 class="font-semibold">{{ __('messages.trust.privacy.title') }}</h3>
          <p class="mt-2 text-gray-600">{{ __('messages.trust.privacy.desc') }}</p>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section id="contact" class="bg-gradient-to-r from-indigo-600 to-sky-600 text-white">
      <div class="max-w-4xl mx-auto px-4 py-12 text-center">
        <h2 class="text-3xl font-bold">{{ __('messages.cta.title') }}</h2>
        <p class="mt-2 max-w-2xl mx-auto">{{ __('messages.cta.desc') }}</p>
        <div class="mt-6 flex justify-center gap-4">
          <a href="/sample" class="px-6 py-3 bg-white text-indigo-600 rounded-md font-semibold">{{ __('messages.cta.demo') }}</a>
          <a href="mailto:hello@example.com?subject=Family%20Tree%20Demo" class="px-6 py-3 border border-white/30 rounded-md">{{ __('messages.cta.walk') }}</a>
        </div>
      </div>
    </section>

  </main>

  <footer class="bg-white border-t mt-6">
    <div class="max-w-6xl mx-auto px-4 py-8 text-sm text-gray-600">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
          <strong>Family Tree Builder</strong>
          <p class="text-xs text-gray-500 mt-1">{{ __('messages.footer.desc') }}</p>
        </div>
        <nav aria-label="Footer links" class="flex gap-4">
          <a href="/privacy" class="hover:underline">Privacy</a>
          <a href="/terms" class="hover:underline">Terms</a>
          <a href="README.md" class="hover:underline">Docs</a>
        </nav>
      </div>

      <p class="mt-6 text-xs text-gray-400">© <span id="year"></span> Family Tree Builder — {{ __('messages.footer.desc') }}</p>
    </div>
  </footer>

  <script>
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
        gsap.from('.hero-title', { y: 36, opacity: 0, duration: 0.9, ease: 'power3.out' });
        gsap.from('.hero-sub', { y: 18, opacity: 0, duration: 0.8, delay: 0.18, ease: 'power3.out' });
        gsap.from('.hero-cta', { scale: 0.98, opacity: 0, duration: 0.7, delay: 0.38, ease: 'back.out(1.1)' });
      } else {
        gsap.from('.hero-title, .hero-sub, .hero-cta', { opacity: 0, duration: 0.6 });
      }

      // Global section reveal with stagger; uses existing .fade-in elements
      gsap.utils.toArray('.fade-in').forEach((el, i) => {
        gsap.fromTo(el, { y: prefersReduced ? 0 : 20, opacity: 0 }, {
          y: 0, opacity: 1, duration: 0.7, ease: 'power3.out', delay: 0.06 * (i % 6),
          scrollTrigger: { trigger: el, start: 'top 88%' }
        });
      });

      // Feature cards stagger (slightly bouncy)
      gsap.from('.feature-card', {
        y: 20, opacity: 0, duration: 0.7, ease: 'power3.out', stagger: 0.12,
        scrollTrigger: { trigger: '#features', start: 'top 85%' }
      });

      // Hero visual subtle parallax
      const heroVisual = document.querySelector('.hero-visual');
      if (heroVisual && !prefersReduced) {
        gsap.to(heroVisual, {
          y: -28,
          ease: 'none',
          scrollTrigger: { scrub: 0.6, start: 'top top', end: 'bottom top' }
        });
      }

      // CTA gentle pulse on hover (paused by default)
      const cta = document.querySelector('.hero-cta');
      if (cta && !prefersReduced) {
        const pulse = gsap.to(cta, { scale: 1.03, duration: 1.2, ease: 'sine.inOut', repeat: -1, yoyo: true, paused: true });
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
          gsap.to(img, { rotationY: px * 6, rotationX: -py * 6, scale: 1.02, duration: 0.4, ease: 'power1.out' });
        });
        img.addEventListener('pointerleave', () => gsap.to(img, { rotationY: 0, rotationX: 0, scale: 1, duration: 0.6, ease: 'power2.out' }));
      });

      // Navigation: smooth scroll and active link highlight using IntersectionObserver
      document.documentElement.style.scrollBehavior = 'smooth';
      const navLinks = document.querySelectorAll('header nav a');
      const sections = Array.from(navLinks).map(a => {
        try { return document.querySelector(a.getAttribute('href')); } catch(e) { return null; }
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
        }, { threshold: 0.45 });
        sections.forEach(s => obs.observe(s));
      }
    }

    // Accessibility: enable keyboard focus visible styles
    document.addEventListener('keyup', (e) => {
      if (e.key === 'Tab') document.documentElement.classList.add('user-tabbed');
    });
  </script>
  </script>
</body>
</html>