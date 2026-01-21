<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Family Tree Builder — Visual Relationship Editor</title>
  <meta name="description" content="Build, visualize and edit complex family trees with auto-layout, relationship editing, and interactive collapsing. Fast, modern, and production-ready." />
  <meta name="keywords" content="family tree, genealogy, visual editor, auto layout, relationship editor, tree visualization" />
  <link rel="canonical" href="/" />

  <!-- Open Graph -->
  <meta property="og:title" content="Family Tree Builder — Visual Relationship Editor" />
  <meta property="og:description" content="Build, visualize and edit complex family trees with auto-layout and direct manipulation." />
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
      <nav aria-label="Top">
        <ul class="flex gap-4 items-center text-sm">
          <li><a href="#features" class="text-slate-700 hover:text-black">Features</a></li>
          <li><a href="#demo" class="text-slate-700 hover:text-black">Demo</a></li>
          <li><a href="#trust" class="text-slate-700 hover:text-black">Trust</a></li>
          <li><a href="#contact" class="px-3 py-2 rounded-md border bg-white hover:bg-gray-100">Get a Demo</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>

    <!-- Hero -->
    <section class="max-w-6xl mx-auto px-4 py-16 grid gap-8 grid-cols-1 md:grid-cols-2 items-center">
      <div>
        <p class="kicker">Visual genealogy • interactive</p>
        <h1 class="mt-4 text-3xl md:text-5xl font-extrabold tracking-tight hero-title">
          Build and edit beautiful family trees, visually.
        </h1>
        <p class="mt-4 text-lg text-gray-600 max-w-xl hero-sub">
          Create, visualize and maintain complex family relationships with automatic layout, smooth animations, and direct-manipulation editing — perfect for genealogists, researchers, and teams.
        </p>

        <div class="mt-6 flex gap-4 items-center">
          <a href="#demo" class="cta-primary px-5 py-3 rounded-md shadow hover:shadow-lg transition hero-cta">Try Interactive Demo</a>
          <a href="#features" class="px-4 py-3 rounded-md border hover:bg-gray-50">See Features</a>
        </div>

        <ul class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
          <li><strong>Auto-layout</strong> — Clean hierarchical layouts (see familyTreeLayout)</li>
          <li><strong>Interactive editing</strong> — Add people, spouses, collapse branches</li>
          <li><strong>Export & share</strong> — Static JSON / images for catalogs</li>
          <li><strong>Accessible UI</strong> — Keyboard & screen reader friendly</li>
        </ul>
      </div>

      <div class="hero-visual p-4 fade-in" aria-hidden="true">
        <!-- Placeholder screenshot; replace with real screenshot or embed iframe / demo -->
        <img src="https://images.unsplash.com/photo-1542736667-069246bdbc93?w=1200&q=60&auto=format&fit=crop" alt="Interactive family tree preview" class="w-full rounded-md shadow-sm" />
        <figcaption class="mt-2 text-xs text-muted">Interactive editor preview (click Demo to open live)</figcaption>
      </div>
    </section>

    <!-- Problem → Solution -->
    <section id="problem" class="bg-white">
      <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid gap-8 md:grid-cols-2 items-start">
          <div class="fade-in">
            <h2 class="text-2xl font-bold">The problem</h2>
            <p class="mt-4 text-gray-600">Genealogy tools often produce cluttered charts, require manual adjustments, or lack intuitive editing. Teams struggle with blended families, multiple marriages, and maintaining readable layouts as data grows.</p>
            <h3 class="mt-6 text-lg font-semibold">Why they fail</h3>
            <ul class="mt-3 list-disc list-inside text-gray-600">
              <li>Rigid import-only flows</li>
              <li>No visual tools for relationship correction</li>
              <li>Poor automatic layout for complex marriages</li>
            </ul>
          </div>

          <div class="fade-in">
            <h2 class="text-2xl font-bold">Our solution</h2>
            <p class="mt-4 text-gray-600">A modern web editor that combines automatic layout algorithms with direct node/edge editing, spouse handling and branch collapsing for clarity — enabling faster, accurate family research.</p>
            <p class="mt-4 text-gray-600">Powered by a lightweight API endpoint and client-side layout utilities (see <code>familyTreeLayout</code>).</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Features -->
    <section id="features" class="max-w-6xl mx-auto px-4 py-12">
      <div class="text-center">
        <h2 class="text-3xl font-bold">Features built from the codebase</h2>
        <p class="mt-2 text-gray-600 max-w-2xl mx-auto">Derived directly from the repository: layout helpers, spouse handling, collapsing branches, and an API-backed initial state.</p>
      </div>

      <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <!-- icon -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 7a4 4 0 110-8 4 4 0 010 8zM21 23v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2" stroke="#4f46e5" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 class="font-semibold">Auto Layout</h3>
          <p class="mt-2 text-sm text-gray-600">Dagre-based layout utilities produce readable hierarchical trees — see <a href="resources/js/utils/familyTreeLayout.ts" class="text-indigo-600">familyTreeLayout</a>.</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 12v0" stroke="#4f46e5" stroke-width="1.6" stroke-linecap="round"/></svg>
          </div>
          <h3 class="font-semibold">Spouse & Parent Rerouting</h3>
          <p class="mt-2 text-sm text-gray-600">Automatic spouse node insertion and parent rerouting keeps generations organized (implemented in <code>addSpouseAndRerouteParents</code>).</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 3h18v18H3z" stroke="#4f46e5" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 class="font-semibold">Collapse Branches</h3>
          <p class="mt-2 text-sm text-gray-600">Temporarily collapse subtrees to reduce clutter; expand later (see <a href="resources/js/composables/useCollapse.ts" class="text-indigo-600">useCollapse</a>).</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2l3 8H9l3-8z" stroke="#4f46e5" stroke-width="1.6"/></svg>
          </div>
          <h3 class="font-semibold">Interactive Editing</h3>
          <p class="mt-2 text-sm text-gray-600">Add people, spouses, and edges directly from the node toolbar in the editor (see person node components in <a href="resources/js/components/nodes/PersonNode.vue" class="text-indigo-600">PersonNode.vue</a>).</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M21 8v8" stroke="#4f46e5" stroke-width="1.6"/></svg>
          </div>
          <h3 class="font-semibold">Exportable Data</h3>
          <p class="mt-2 text-sm text-gray-600">Client-side code uses a JSON model for nodes/edges and an API seed endpoint at <a href="routes/api.php" class="text-indigo-600">/api/family-tree</a>.</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 20v-6" stroke="#4f46e5" stroke-width="1.6"/></svg>
          </div>
          <h3 class="font-semibold">Performance & Simplicity</h3>
          <p class="mt-2 text-sm text-gray-600">Minimal server-side behavior; most logic runs client-side for snappy interactions and easy static deployment.</p>
        </article>
      </div>
    </section>

    <!-- How it works -->
    <section id="how" class="bg-white/50">
      <div class="max-w-5xl mx-auto px-4 py-12 text-center">
        <h2 class="text-2xl font-bold">How it works — 3 steps</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div class="p-6 bg-white rounded-lg fade-in">
            <div class="text-2xl font-semibold">1. Load data</div>
            <p class="mt-2 text-gray-600">Start from JSON or the built-in API seed at <code>/api/family-tree</code>.</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <div class="text-2xl font-semibold">2. Auto layout</div>
            <p class="mt-2 text-gray-600">Client-side Dagre layout computes positions; spouse nodes are added and parent edges rerouted for readability.</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <div class="text-2xl font-semibold">3. Edit & share</div>
            <p class="mt-2 text-gray-600">Drag, add relations, collapse branches, and export the updated JSON or image.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Demo / Screenshots -->
    <section id="demo" class="max-w-6xl mx-auto px-4 py-12">
      <h2 class="text-2xl font-bold text-center">Live preview & screenshots</h2>
      <p class="text-center text-gray-600 mt-2">Interactive demo runs in-app. Use the Demo link to open the editor.</p>

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
        <h2 class="text-2xl font-bold text-center">Who benefits</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div class="p-6 bg-white rounded-lg fade-in">
            <h3 class="font-semibold">Genealogy Researchers</h3>
            <p class="mt-2 text-gray-600">Quickly map complex relationships and share clean diagrams.</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <h3 class="font-semibold">Family Historians</h3>
            <p class="mt-2 text-gray-600">Visual editing makes correcting lineage mistakes trivial.</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <h3 class="font-semibold">Teams & Educators</h3>
            <p class="mt-2 text-gray-600">Use as a collaborative visualization tool for teaching or projects.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Trust / Tech -->
    <section id="trust" class="max-w-6xl mx-auto px-4 py-12">
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div class="fade-in">
          <h2 class="text-2xl font-bold">Trust & Technology</h2>
          <p class="mt-4 text-gray-600">Built with proven libraries and simple backend API seeding for reliability.</p>
          <ul class="mt-4 text-gray-600 list-disc list-inside">
            <li>Client-side Dagre layout (see <a href="resources/js/utils/familyTreeLayout.ts" class="text-indigo-600">familyTreeLayout</a>)</li>
            <li>Vue Flow inspired node/edge model (nodes/edges JSON)</li>
            <li>Simple PHP API seed controller: <a href="app/Http/Controllers/FamilyTreeController.php" class="text-indigo-600">FamilyTreeController::index</a></li>
            <li>Static-first deployable, fast & cacheable</li>
          </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm fade-in">
          <h3 class="font-semibold">Security & Reliability</h3>
          <p class="mt-2 text-gray-600">No sensitive data stored by default. The app uses server-seeded JSON and client-side rendering to keep the surface area small.</p>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section id="contact" class="bg-gradient-to-r from-indigo-600 to-sky-600 text-white">
      <div class="max-w-4xl mx-auto px-4 py-12 text-center">
        <h2 class="text-3xl font-bold">Ready to visualize your family tree?</h2>
        <p class="mt-2 max-w-2xl mx-auto">Try the interactive demo or get in touch for a guided walkthrough.</p>
        <div class="mt-6 flex justify-center gap-4">
          <a href="/sample" class="px-6 py-3 bg-white text-indigo-600 rounded-md font-semibold">Open Demo</a>
          <a href="mailto:hello@example.com?subject=Family%20Tree%20Demo" class="px-6 py-3 border border-white/30 rounded-md">Request Demo</a>
        </div>
      </div>
    </section>

  </main>

  <footer class="bg-white border-t mt-6">
    <div class="max-w-6xl mx-auto px-4 py-8 text-sm text-gray-600">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
          <strong>Family Tree Builder</strong>
          <p class="text-xs text-gray-500 mt-1">Build, edit and share genealogical diagrams. Deployable as static files.</p>
        </div>
        <nav aria-label="Footer links" class="flex gap-4">
          <a href="/privacy" class="hover:underline">Privacy</a>
          <a href="/terms" class="hover:underline">Terms</a>
          <a href="README.md" class="hover:underline">Docs</a>
        </nav>
      </div>

      <p class="mt-6 text-xs text-gray-400">© <span id="year"></span> Family Tree Builder — All rights reserved. This landing page is a static marketing front-end for the repository (see <a href="README.md" class="text-indigo-600">README</a>).</p>
    </div>
  </footer>

  <script>
    // set year
    document.getElementById('year').textContent = new Date().getFullYear();

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
        // If reduced motion is preferred, simply fade elements (no movement)
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
      const sections = Array.from(navLinks).map(a => document.querySelector(a.getAttribute('href'))).filter(Boolean);
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
</body>
</html>