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
      <nav aria-label="Top" class="flex items-center gap-4">
        <ul class="flex gap-4 items-center text-sm">
          <li><a href="#features" class="text-slate-700 hover:text-black" data-i18n="nav.features">Features</a></li>
          <li><a href="#demo" class="text-slate-700 hover:text-black" data-i18n="nav.demo">Demo</a></li>
          <li><a href="#trust" class="text-slate-700 hover:text-black" data-i18n="nav.trust">Trust</a></li>
          <li><a href="#contact" class="px-3 py-2 rounded-md border bg-white hover:bg-gray-100" data-i18n="nav.contact">Get a Demo</a></li>
        </ul>
        <label for="langSelect" class="sr-only">Language</label>
        <select id="langSelect" aria-label="Select language" class="ml-4 border rounded-md px-2 py-1 text-sm">
          <option value="en">English</option>
          <option value="vi">Tiếng Việt</option>
          <option value="es">Español</option>
        </select>
      </nav>
    </div>
  </header>

  <main>

    <!-- Hero -->
    <section class="max-w-6xl mx-auto px-4 py-16 grid gap-8 grid-cols-1 md:grid-cols-2 items-center">
      <div>
        <p class="kicker" data-i18n="hero.kicker">Visual genealogy • interactive</p>
        <h1 class="mt-4 text-3xl md:text-5xl font-extrabold tracking-tight hero-title" data-i18n="hero.title">Turn family stories into clear, beautiful family trees.</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-xl hero-sub" data-i18n="hero.sub">Quickly map relationships, fix mistakes, and share an organized family history. Interactive editing, smart arrangement, and clean visual exports make research and storytelling effortless.</p>

        <div class="mt-6 flex gap-4 items-center">
          <a href="#demo" class="cta-primary px-5 py-3 rounded-md shadow hover:shadow-lg transition hero-cta" data-i18n="cta.primary">Start Free Demo</a>
          <a href="#features" class="px-4 py-3 rounded-md border hover:bg-gray-50" data-i18n="cta.secondary">See Live Demo</a>
        </div>

        <ul class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
          <li data-i18n="hero.benefit1"><strong>Auto-layout</strong> — Clean hierarchical layouts (see familyTreeLayout)</li>
          <li data-i18n="hero.benefit2"><strong>Interactive editing</strong> — Add people, spouses, collapse branches</li>
          <li data-i18n="hero.benefit3"><strong>Export & share</strong> — Static JSON / images for catalogs</li>
          <li data-i18n="hero.benefit4"><strong>Accessible UI</strong> — Keyboard & screen reader friendly</li>
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
              <h2 class="text-2xl font-bold" data-i18n="problem.title">Why mapping family history is painful</h2>
              <p class="mt-4 text-gray-600" data-i18n="problem.desc">Manual charts get messy fast. When families have multiple marriages, adoptions, or missing records, diagrams become hard to read and even harder to correct. That slows research and breaks storytelling.</p>
              <h3 class="mt-6 text-lg font-semibold">Where other tools fall short</h3>
              <ul class="mt-3 list-disc list-inside text-gray-600">
                <li>Static exports that need manual cleanup</li>
                <li>Limited controls for complex relationships</li>
                <li>Large trees that overwhelm readers</li>
              </ul>
            </div>

            <div class="fade-in">
              <h2 class="text-2xl font-bold" data-i18n="solution.title">How this helps you</h2>
              <p class="mt-4 text-gray-600" data-i18n="solution.desc">Edit directly on the chart, let the layout organize the family, and collapse branches to focus on the story you care about. It’s faster to correct errors, easier to explain relationships, and simple to share polished visuals.</p>
              <p class="mt-4 text-gray-600" data-i18n="solution.note">No steep learning curve — built for people who want clear results, not extra steps.</p>
            </div>
        </div>
      </div>
    </section>

    <!-- Features -->
    <section id="features" class="max-w-6xl mx-auto px-4 py-12">
        <div class="text-center">
          <h2 class="text-3xl font-bold" data-i18n="features.title">Real features that save time</h2>
          <p class="mt-2 text-gray-600 max-w-2xl mx-auto" data-i18n="features.subtitle">Every feature is designed to help you understand and share family stories faster — less fiddling, more clarity.</p>
        </div>

      <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <!-- icon -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 7a4 4 0 110-8 4 4 0 010 8zM21 23v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2" stroke="#4f46e5" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 class="font-semibold" data-i18n="feature.auto.title">Auto‑Arrange</h3>
          <p class="mt-2 text-sm text-gray-600" data-i18n="feature.auto.desc">Automatically organize family nodes into a clean, readable layout so you can focus on relationships instead of positioning.</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 12v0" stroke="#4f46e5" stroke-width="1.6" stroke-linecap="round"/></svg>
          </div>
          <h3 class="font-semibold" data-i18n="feature.spouse.title">Smart marriage handling</h3>
          <p class="mt-2 text-sm text-gray-600" data-i18n="feature.spouse.desc">Keep spouses visually together and ensure parentage stays accurate—even for complex, multiple-marriage families.</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 3h18v18H3z" stroke="#4f46e5" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 class="font-semibold" data-i18n="feature.collapse.title">Focus with Collapse</h3>
          <p class="mt-2 text-sm text-gray-600" data-i18n="feature.collapse.desc">Hide distant branches to highlight the people and stories you care about, then expand when you’re ready.</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2l3 8H9l3-8z" stroke="#4f46e5" stroke-width="1.6"/></svg>
          </div>
          <h3 class="font-semibold" data-i18n="feature.edit.title">Direct visual editing</h3>
          <p class="mt-2 text-sm text-gray-600" data-i18n="feature.edit.desc">Click and edit on the chart: add people, adjust relationships, or drag nodes for instant updates—no menus, no guesswork.</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M21 8v8" stroke="#4f46e5" stroke-width="1.6"/></svg>
          </div>
          <h3 class="font-semibold" data-i18n="feature.export.title">Share & export</h3>
          <p class="mt-2 text-sm text-gray-600" data-i18n="feature.export.desc">Export clean JSON or polished images to share with relatives, publish in reports, or archive your research.</p>
        </article>

        <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
          <div class="feature-icon mb-3" aria-hidden>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 20v-6" stroke="#4f46e5" stroke-width="1.6"/></svg>
          </div>
          <h3 class="font-semibold" data-i18n="feature.private.title">Fast, private interaction</h3>
          <p class="mt-2 text-sm text-gray-600" data-i18n="feature.private.desc">Most work happens in your browser for quick, responsive edits. Keep data local until you decide to share.</p>
        </article>
      </div>
    </section>

    <!-- How it works -->
    <section id="how" class="bg-white/50">
      <div class="max-w-5xl mx-auto px-4 py-12 text-center">
        <h2 class="text-2xl font-bold" data-i18n="how.title">How it works — 3 simple steps</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div class="p-6 bg-white rounded-lg fade-in">
            <div class="text-2xl font-semibold" data-i18n="how.step1.title">1. Start with your data</div>
            <p class="mt-2 text-gray-600" data-i18n="how.step1.desc">Import a file or begin from the sample to see your family instantly.</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <div class="text-2xl font-semibold" data-i18n="how.step2.title">2. Let the editor organize it</div>
            <p class="mt-2 text-gray-600" data-i18n="how.step2.desc">The layout arranges people into a clear chart while keeping relationships correct.</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <div class="text-2xl font-semibold" data-i18n="how.step3.title">3. Edit and share your story</div>
            <p class="mt-2 text-gray-600" data-i18n="how.step3.desc">Make corrections, collapse branches, and export a clean image or data file to share with family.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Demo / Screenshots -->
    <section id="demo" class="max-w-6xl mx-auto px-4 py-12">
      <h2 class="text-2xl font-bold text-center" data-i18n="demo.title">Live preview & screenshots</h2>
      <p class="text-center text-gray-600 mt-2" data-i18n="demo.desc">Explore the editor to see how nodes, spouses and branches behave — or upload your own data to try it live.</p>

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
        <h2 class="text-2xl font-bold text-center" data-i18n="usecases.title">Who benefits</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div class="p-6 bg-white rounded-lg fade-in">
            <h3 class="font-semibold" data-i18n="usecase.researchers.title">Genealogy Researchers</h3>
            <p class="mt-2 text-gray-600" data-i18n="usecase.researchers.desc">Map complex families faster and spot lineage questions at a glance.</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <h3 class="font-semibold" data-i18n="usecase.historians.title">Family Historians</h3>
            <p class="mt-2 text-gray-600" data-i18n="usecase.historians.desc">Create presentation-ready charts for reunions, publications, or family archives.</p>
          </div>
          <div class="p-6 bg-white rounded-lg fade-in">
            <h3 class="font-semibold" data-i18n="usecase.educators.title">Community & educators</h3>
            <p class="mt-2 text-gray-600" data-i18n="usecase.educators.desc">Teach family-history concepts with clear visuals or collaborate on group projects.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Trust / Tech -->
    <section id="trust" class="max-w-6xl mx-auto px-4 py-12">
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div class="fade-in">
          <h2 class="text-2xl font-bold" data-i18n="trust.title">Trust & reliability</h2>
          <p class="mt-4 text-gray-600" data-i18n="trust.desc">Designed for researchers and families: fast, predictable, and respectful of your data. Most operations happen in your browser so you can work privately and quickly.</p>
          <ul class="mt-4 text-gray-600 list-disc list-inside">
            <li data-i18n="trust.b1">Local-first editing for responsive interactions</li>
            <li data-i18n="trust.b2">Export options so you control sharing</li>
            <li data-i18n="trust.b3">Lightweight server seed for easy demos</li>
            <li data-i18n="trust.b4">Deployable as static files for performance</li>
          </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm fade-in">
          <h3 class="font-semibold" data-i18n="trust.privacy.title">Privacy & control</h3>
          <p class="mt-2 text-gray-600" data-i18n="trust.privacy.desc">You choose when to share. The editor works offline and locally, and exports are only created when you ask for them.</p>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section id="contact" class="bg-gradient-to-r from-indigo-600 to-sky-600 text-white">
      <div class="max-w-4xl mx-auto px-4 py-12 text-center">
        <h2 class="text-3xl font-bold" data-i18n="cta.title">Ready to bring your family history to life?</h2>
        <p class="mt-2 max-w-2xl mx-auto" data-i18n="cta.desc">Try the interactive demo now or request a short walkthrough to see how the editor can speed your research.</p>
        <div class="mt-6 flex justify-center gap-4">
          <a href="/sample" class="px-6 py-3 bg-white text-indigo-600 rounded-md font-semibold" data-i18n="cta.demo">Open Demo</a>
          <a href="mailto:hello@example.com?subject=Family%20Tree%20Demo" class="px-6 py-3 border border-white/30 rounded-md" data-i18n="cta.walk">Request Walkthrough</a>
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

      <p class="mt-6 text-xs text-gray-400">© <span id="year"></span> Family Tree Builder — Build, edit and share clear family trees. Create polished charts for research, reunions, publications, and teaching. Learn more in the <a href="README.md" class="text-indigo-600">project README</a>.</p>
    </div>
  </footer>

  <script>
    // set year
    document.getElementById('year').textContent = new Date().getFullYear();

    // Translations object: add languages here. Primary is English (en).
    const TRANSLATIONS = {
      en: {
        'meta.title': 'Family Tree Builder — Visual Relationship Editor',
        'meta.desc': 'Build, visualize and edit complex family trees with auto-layout, interactive editing, and clean exports.',
        'og.title': 'Family Tree Builder — Visual Relationship Editor',
        'og.desc': 'Build, visualize and edit complex family trees with auto-layout and direct manipulation.',

        'nav.features': 'Features',
        'nav.demo': 'Demo',
        'nav.trust': 'Trust',
        'nav.contact': 'Get a Demo',

        'hero.kicker': 'Visual genealogy • interactive',
        'hero.title': 'Turn family stories into clear, beautiful family trees.',
        'hero.sub': 'Quickly map relationships, fix mistakes, and share an organized family history. Interactive editing, smart arrangement, and clean visual exports make research and storytelling effortless.',
        'cta.primary': 'Start Free Demo',
        'cta.secondary': 'See Live Demo',
        'hero.benefit1': 'Auto-layout — Clean hierarchical layouts (see familyTreeLayout)',
        'hero.benefit2': 'Interactive editing — Add people, spouses, collapse branches',
        'hero.benefit3': 'Export & share — Static JSON / images for catalogs',
        'hero.benefit4': 'Accessible UI — Keyboard & screen reader friendly',

        'problem.title': 'Why mapping family history is painful',
        'problem.desc': 'Manual charts get messy fast. When families have multiple marriages, adoptions, or missing records, diagrams become hard to read and even harder to correct. That slows research and breaks storytelling.',
        'solution.title': 'How this helps you',
        'solution.desc': 'Edit directly on the chart, let the layout organize the family, and collapse branches to focus on the story you care about. It’s faster to correct errors, easier to explain relationships, and simple to share polished visuals.',
        'solution.note': 'No steep learning curve — built for people who want clear results, not extra steps.',

        'features.title': 'Real features that save time',
        'features.subtitle': 'Every feature is designed to help you understand and share family stories faster — less fiddling, more clarity.',

        'feature.auto.title': 'Auto‑Arrange',
        'feature.auto.desc': 'Automatically organize family nodes into a clean, readable layout so you can focus on relationships instead of positioning.',
        'feature.spouse.title': 'Smart marriage handling',
        'feature.spouse.desc': 'Keep spouses visually together and ensure parentage stays accurate—even for complex, multiple-marriage families.',
        'feature.collapse.title': 'Focus with Collapse',
        'feature.collapse.desc': 'Hide distant branches to highlight the people and stories you care about, then expand when you’re ready.',
        'feature.edit.title': 'Direct visual editing',
        'feature.edit.desc': 'Click and edit on the chart: add people, adjust relationships, or drag nodes for instant updates—no menus, no guesswork.',
        'feature.export.title': 'Share & export',
        'feature.export.desc': 'Export clean JSON or polished images to share with relatives, publish in reports, or archive your research.',
        'feature.private.title': 'Fast, private interaction',
        'feature.private.desc': 'Most work happens in your browser for quick, responsive edits. Keep data local until you decide to share.',

        'how.title': 'How it works — 3 simple steps',
        'how.step1.title': '1. Start with your data',
        'how.step1.desc': 'Import a file or begin from the sample to see your family instantly.',
        'how.step2.title': '2. Let the editor organize it',
        'how.step2.desc': 'The layout arranges people into a clear chart while keeping relationships correct.',
        'how.step3.title': '3. Edit and share your story',
        'how.step3.desc': 'Make corrections, collapse branches, and export a clean image or data file to share with family.',

        'demo.title': 'Live preview & screenshots',
        'demo.desc': 'Explore the editor to see how nodes, spouses and branches behave — or upload your own data to try it live.',

        'usecases.title': 'Who benefits',
        'usecase.researchers.title': 'Genealogy Researchers',
        'usecase.researchers.desc': 'Map complex families faster and spot lineage questions at a glance.',
        'usecase.historians.title': 'Family Historians',
        'usecase.historians.desc': 'Create presentation-ready charts for reunions, publications, or family archives.',
        'usecase.educators.title': 'Community & educators',
        'usecase.educators.desc': 'Teach family-history concepts with clear visuals or collaborate on group projects.',

        'trust.title': 'Trust & reliability',
        'trust.desc': 'Designed for researchers and families: fast, predictable, and respectful of your data. Most operations happen in your browser so you can work privately and quickly.',
        'trust.b1': 'Local-first editing for responsive interactions',
        'trust.b2': 'Export options so you control sharing',
        'trust.b3': 'Lightweight server seed for easy demos',
        'trust.b4': 'Deployable as static files for performance',
        'trust.privacy.title': 'Privacy & control',
        'trust.privacy.desc': 'You choose when to share. The editor works offline and locally, and exports are only created when you ask for them.',

        'cta.title': 'Ready to bring your family history to life?',
        'cta.desc': 'Try the interactive demo now or request a short walkthrough to see how the editor can speed your research.',
        'cta.demo': 'Open Demo',
        'cta.walk': 'Request Walkthrough',

        'footer.desc': 'Build, edit and share clear family trees. Create polished charts for research, reunions, publications, and teaching. Learn more in the project README.'
      },
      vi: {
        'meta.title': 'Trình tạo cây gia đình — Trình chỉnh sửa mối quan hệ',
        'meta.desc': 'Xây dựng, trực quan hóa và chỉnh sửa cây gia đình phức tạp với bố cục tự động, chỉnh sửa tương tác và xuất dữ liệu.',
        'og.title': 'Trình tạo cây gia đình — Trình chỉnh sửa mối quan hệ',
        'og.desc': 'Xây dựng, trực quan hóa và chỉnh sửa cây gia đình với bố cục tự động và thao tác trực tiếp.',

        'nav.features': 'Tính năng',
        'nav.demo': 'Demo',
        'nav.trust': 'Độ tin cậy',
        'nav.contact': 'Nhận demo',

        'hero.kicker': 'Phả hệ trực quan • tương tác',
        'hero.title': 'Biến câu chuyện gia đình thành những cây gia đình rõ ràng, đẹp mắt.',
        'hero.sub': 'Nhanh chóng lập bản đồ quan hệ, sửa lỗi và chia sẻ lịch sử gia đình có tổ chức. Chỉnh sửa tương tác, sắp xếp thông minh và xuất hình ảnh đẹp.',
        'cta.primary': 'Bắt đầu Demo miễn phí',
        'cta.secondary': 'Xem Demo trực tiếp',
        'hero.benefit1': 'Bố cục tự động — Sắp xếp rõ ràng',
        'hero.benefit2': 'Chỉnh sửa tương tác — Thêm người, vợ/chồng, thu gọn nhánh',
        'hero.benefit3': 'Xuất & chia sẻ — JSON / ảnh',
        'hero.benefit4': 'Giao diện truy cập — Hỗ trợ bàn phím và trình đọc màn hình',

        'problem.title': 'Tại sao việc lập bản đồ lịch sử gia đình khó khăn',
        'problem.desc': 'Biểu đồ thủ công nhanh chóng trở nên lộn xộn. Khi gia đình có nhiều cuộc hôn nhân, nhận con nuôi hoặc thiếu hồ sơ, sơ đồ trở nên khó đọc và khó sửa.',
        'solution.title': 'Cách công cụ giúp bạn',
        'solution.desc': 'Chỉnh sửa trực tiếp trên biểu đồ, để công cụ sắp xếp gia đình và thu gọn nhánh để tập trung vào câu chuyện bạn quan tâm.',
        'solution.note': 'Không cần học khó — dành cho người muốn kết quả nhanh.',

        'features.title': 'Các tính năng thực sự giúp tiết kiệm thời gian',
        'features.subtitle': 'Mỗi tính năng giúp bạn hiểu và chia sẻ câu chuyện gia đình nhanh hơn — ít thao tác hơn, rõ ràng hơn.',

        'feature.auto.title': 'Tự động sắp xếp',
        'feature.auto.desc': 'Tự động sắp xếp các nút gia đình để bạn tập trung vào mối quan hệ.',
        'feature.spouse.title': 'Xử lý hôn nhân thông minh',
        'feature.spouse.desc': 'Giữ vợ/chồng gần nhau và đảm bảo quan hệ cha mẹ chính xác.',
        'feature.collapse.title': 'Thu gọn để tập trung',
        'feature.collapse.desc': 'Ẩn các nhánh xa để làm nổi bật những người bạn quan tâm.',
        'feature.edit.title': 'Chỉnh sửa trực quan',
        'feature.edit.desc': 'Nhấp để chỉnh sửa: thêm người, điều chỉnh quan hệ hoặc kéo nút.',
        'feature.export.title': 'Chia sẻ & xuất',
        'feature.export.desc': 'Xuất JSON sạch hoặc ảnh để chia sẻ hoặc lưu trữ.',
        'feature.private.title': 'Nhanh và riêng tư',
        'feature.private.desc': 'Hầu hết thao tác diễn ra trên trình duyệt của bạn để nhanh và bảo mật.',

        'how.title': 'Cách hoạt động — 3 bước đơn giản',
        'how.step1.title': '1. Bắt đầu với dữ liệu',
        'how.step1.desc': 'Nhập tệp hoặc dùng mẫu để xem gia đình ngay lập tức.',
        'how.step2.title': '2. Để trình chỉnh sửa sắp xếp',
        'how.step2.desc': 'Bố cục sắp xếp mọi người thành sơ đồ rõ ràng.',
        'how.step3.title': '3. Chỉnh sửa và chia sẻ',
        'how.step3.desc': 'Sửa lỗi, thu gọn nhánh và xuất ảnh hoặc dữ liệu để chia sẻ.',

        'demo.title': 'Xem trước & ảnh chụp màn hình',
        'demo.desc': 'Khám phá trình chỉnh sửa hoặc tải dữ liệu của bạn lên để thử trực tiếp.',

        'usecases.title': 'Ai được lợi',
        'usecase.researchers.title': 'Nhà nghiên cứu phả hệ',
        'usecase.researchers.desc': 'Lập bản đồ gia đình phức tạp nhanh hơn.',
        'usecase.historians.title': 'Nhà lưu trữ gia đình',
        'usecase.historians.desc': 'Tạo biểu đồ trình bày cho gặp mặt hoặc xuất bản.',
        'usecase.educators.title': 'Cộng đồng & giáo viên',
        'usecase.educators.desc': 'Dùng trực quan để giảng dạy hoặc hợp tác.',

        'trust.title': 'Độ tin cậy',
        'trust.desc': 'Thiết kế cho nhà nghiên cứu và gia đình: nhanh, ổn định và tôn trọng dữ liệu của bạn.',
        'trust.b1': 'Chỉnh sửa cục bộ cho tương tác mượt mà',
        'trust.b2': 'Tùy chọn xuất để bạn kiểm soát việc chia sẻ',
        'trust.b3': 'API mẫu nhẹ cho demo',
        'trust.b4': 'Triển khai tĩnh cho hiệu năng',
        'trust.privacy.title': 'Quyền riêng tư & kiểm soát',
        'trust.privacy.desc': 'Bạn quyết định khi nào chia sẻ. Trình chỉnh sửa hoạt động cục bộ và ngoại tuyến.',

        'cta.title': 'Sẵn sàng làm sống lại lịch sử gia đình?',
        'cta.desc': 'Thử demo tương tác hoặc yêu cầu hướng dẫn ngắn để tiết kiệm thời gian nghiên cứu.',
        'cta.demo': 'Mở Demo',
        'cta.walk': 'Yêu cầu hướng dẫn',

        'footer.desc': 'Xây dựng, chỉnh sửa và chia sẻ cây gia đình rõ ràng. Tìm hiểu thêm trong README dự án.'
      },
      es: {
        'meta.title': 'Creador de Árboles Familiares — Editor Visual',
        'meta.desc': 'Construye, visualiza y edita árboles familiares complejos con auto‑layout, edición interactiva y exportaciones limpias.',
        'og.title': 'Creador de Árboles Familiares — Editor Visual',
        'og.desc': 'Construye, visualiza y edita árboles familiares con auto‑layout y manipulación directa.',

        'nav.features': 'Características',
        'nav.demo': 'Demo',
        'nav.trust': 'Confianza',
        'nav.contact': 'Solicitar Demo',

        'hero.kicker': 'Genealogía visual • interactiva',
        'hero.title': 'Convierte las historias familiares en árboles claros y hermosos.',
        'hero.sub': 'Mapea relaciones, corrige errores y comparte una historia familiar organizada. Edición interactiva, orden inteligente y exportaciones limpias.',
        'cta.primary': 'Probar Demo Gratis',
        'cta.secondary': 'Ver Demo',
        'hero.benefit1': 'Auto‑layout — Diagramas jerárquicos claros',
        'hero.benefit2': 'Edición interactiva — Añade personas, cónyuges, colapsa ramas',
        'hero.benefit3': 'Exportar & compartir — JSON / imágenes',
        'hero.benefit4': 'Accesible — Teclado y lectores',

        'problem.title': 'Por qué es difícil mapear la historia familiar',
        'problem.desc': 'Los diagramas manuales se vuelven desordenados. Con múltiples matrimonios, adopciones o registros faltantes, los gráficos son difíciles de leer y corregir.',
        'solution.title': 'Cómo te ayuda',
        'solution.desc': 'Edita directamente en el diagrama, deja que el orden lo organice y colapsa ramas para enfocarte en la historia importante.',
        'solution.note': 'Sin curva de aprendizaje pronunciada — pensado para resultados rápidos.',

        'features.title': 'Características reales que ahorran tiempo',
        'features.subtitle': 'Cada característica está diseñada para ayudarte a entender y compartir historias familiares más rápido.',

        'feature.auto.title': 'Auto‑organización',
        'feature.auto.desc': 'Organiza automáticamente los nodos en una disposición legible.',
        'feature.spouse.title': 'Manejo de matrimonios',
        'feature.spouse.desc': 'Mantiene a los cónyuges juntos y la paternidad correcta.',
        'feature.collapse.title': 'Colapsar para enfocar',
        'feature.collapse.desc': 'Oculta ramas lejanas para resaltar lo importante.',
        'feature.edit.title': 'Edición visual directa',
        'feature.edit.desc': 'Haz clic para editar: añade personas, ajusta relaciones o arrastra nodos.',
        'feature.export.title': 'Compartir & exportar',
        'feature.export.desc': 'Exporta JSON limpio o imágenes para compartir o archivar.',
        'feature.private.title': 'Rápido y privado',
        'feature.private.desc': 'La mayor parte trabaja en tu navegador para ediciones rápidas y privadas.',

        'how.title': 'Cómo funciona — 3 pasos simples',
        'how.step1.title': '1. Empieza con tus datos',
        'how.step1.desc': 'Importa un archivo o usa la muestra para ver tu árbol.',
        'how.step2.title': '2. Deja que el editor lo organice',
        'how.step2.desc': 'El layout ordena a las personas en un diagrama claro.',
        'how.step3.title': '3. Edita y comparte',
        'how.step3.desc': 'Corrige, colapsa y exporta una imagen o archivo de datos.',

        'demo.title': 'Vista previa & capturas',
        'demo.desc': 'Explora el editor o sube tus datos para probarlo en vivo.',

        'usecases.title': 'Quién se beneficia',
        'usecase.researchers.title': 'Investigadores de genealogía',
        'usecase.researchers.desc': 'Mapea familias complejas con mayor rapidez.',
        'usecase.historians.title': 'Historiadores familiares',
        'usecase.historians.desc': 'Crea gráficos listos para presentaciones.',
        'usecase.educators.title': 'Comunidad & educadores',
        'usecase.educators.desc': 'Usa visuales claros para la enseñanza y colaboración.',

        'trust.title': 'Confianza y fiabilidad',
        'trust.desc': 'Diseñado para investigadores y familias: rápido, predecible y respetuoso con tus datos.',
        'trust.b1': 'Edición local para interacciones responsivas',
        'trust.b2': 'Opciones de exportación que controlas',
        'trust.b3': 'Semilla de servidor ligera para demos',
        'trust.b4': 'Desplegable como archivos estáticos para rendimiento',
        'trust.privacy.title': 'Privacidad y control',
        'trust.privacy.desc': 'Tú decides cuándo compartir. El editor funciona sin conexión y localmente.',

        'cta.title': '¿Listo para dar vida a tu historia familiar?',
        'cta.desc': 'Prueba el demo interactivo o solicita una breve demostración.',
        'cta.demo': 'Abrir Demo',
        'cta.walk': 'Solicitar Demostración',

        'footer.desc': 'Construye, edita y comparte árboles familiares claros. Más info en README.'
      }
    };

    // Update page language and text based on key
    function applyTranslations(lang) {
      const map = TRANSLATIONS[lang] || TRANSLATIONS.en;
      // update simple text nodes
      document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (map[key]) el.innerHTML = map[key];
      });
      // update possible alt attributes for images (if keys provided)
      document.querySelectorAll('img[data-i18n-alt]').forEach(img => {
        const key = img.getAttribute('data-i18n-alt');
        if (map[key]) img.alt = map[key];
      });
      // update meta tags
      const title = map['meta.title'] || map['og.title'];
      const desc = map['meta.desc'] || map['og.desc'];
      if (title) document.title = title;
      const md = document.querySelector('meta[name="description"]');
      if (md && desc) md.setAttribute('content', desc);
      const ogt = document.querySelector('meta[property="og:title"]');
      if (ogt && map['og.title']) ogt.setAttribute('content', map['og.title']);
      const ogd = document.querySelector('meta[property="og:description"]');
      if (ogd && map['og.desc']) ogd.setAttribute('content', map['og.desc']);

      // set html lang attribute
      document.documentElement.lang = lang;

      // persist
      try { localStorage.setItem('ftb_lang', lang); } catch (e) {}
    }

    // Initialize language selector
    const langSelect = document.getElementById('langSelect');
    if (langSelect) {
      const saved = (localStorage.getItem('ftb_lang') || 'en');
      langSelect.value = saved;
      applyTranslations(saved);
      langSelect.addEventListener('change', (e) => applyTranslations(e.target.value));
    } else {
      applyTranslations(localStorage.getItem('ftb_lang') || 'en');
    }

    // GSAP: enhanced animations and scroll interactions (re-attach if GSAP present)
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