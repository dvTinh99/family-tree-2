<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ __('messages.meta.title') }}</title>
    <meta name="description" content="{{ __('messages.meta.desc') }}" />
    <meta name="keywords"
        content="family tree, genealogy, visual editor, auto layout, relationship editor, tree visualization" />
    <link rel="canonical" href="/" />

    <!-- Open Graph -->
    <meta property="og:title" content="{{ __('messages.og.title') }}" />
    <meta property="og:description" content="{{ __('messages.og.desc') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="/" />
    <meta property="og:image" content="/preview.png" />

    <link rel="icon" type="image/x-icon" href="/images/logo.webp">

    <!-- Tailwind via CDN (no build tools) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- GSAP for smooth animations; ScrollTrigger plugin -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    <link rel="stylesheet" href="landing.css">
</head>

<body class="bg-white text-slate-900 leading-relaxed">

    <header class="bg-white/60 backdrop-blur sticky top-0 z-50 border-b">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3" aria-label="Family Tree Builder Home">
                <div id="logo" class="w-9 h-9">
                    <img src="images/logo.webp" alt="">
                </div>
                <span class="font-semibold">Family Tree Builder</span>
            </a>

            <nav aria-label="Top" class="flex items-center gap-4">
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-slate-700" aria-expanded="false" aria-controls="mobile-menu" aria-label="Open menu">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden>
                        <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <!-- Desktop nav -->
                <ul class="hidden md:flex gap-4 items-center text-sm">
                    <li><a href="#features" class="text-slate-700 hover:text-black">{{ __('messages.nav.features') }}</a></li>
                    <li><a href="#demo" class="text-slate-700 hover:text-black">{{ __('messages.nav.demo') }}</a></li>
                    <li><a href="#trust" class="text-slate-700 hover:text-black">{{ __('messages.nav.trust') }}</a></li>
                    <li><a href="#contact" class="px-3 py-2 rounded-md border bg-white hover:bg-gray-100">{{ __('messages.nav.contact') }}</a></li>
                    <li><a href="/login" class="px-3 py-2 rounded-md bg-emerald-600 text-white hover:bg-emerald-700">Login</a></li>
                </ul>

                <label for="langSelect" class="sr-only">Language</label>
                <select id="langSelect" aria-label="Select language" class="ml-4 border rounded-md px-2 py-1 text-sm hidden sm:inline">
                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                    <option value="vi" {{ app()->getLocale() === 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                    <option value="es" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>Español</option>
                </select>
            </nav>
        </div>

        <!-- Mobile menu panel -->
        <div id="mobile-menu" class="md:hidden hidden bg-white/95 backdrop-blur border-t">
            <div class="px-4 py-3 space-y-2">
                <a href="#features" class="block text-slate-700 py-2">Features</a>
                <a href="#demo" class="block text-slate-700 py-2">Demo</a>
                <a href="#trust" class="block text-slate-700 py-2">Trust</a>
                <a href="#contact" class="block text-slate-700 py-2">Contact</a>
                <a href="/login" class="block w-full text-center px-3 py-2 rounded-md bg-emerald-600 text-white">Login</a>
            </div>
        </div>
    </header>

    <main>

        <!-- Hero -->
        <section class="max-w-6xl mx-auto px-4 py-16 grid gap-8 grid-cols-1 md:grid-cols-2 items-center">
            <div>
                <p class="kicker">{{ __('messages.hero.kicker') }}</p>
                <h1 class="mt-4 text-2xl md:text-5xl font-extrabold tracking-tight hero-title">
                    {{ __('messages.hero.title') }}</h1>
                <p class="mt-4 text-lg text-gray-600 max-w-xl hero-sub">{{ __('messages.hero.sub') }}</p>

                <div class="mt-6 flex flex-col sm:flex-row gap-3 items-center">
                    <a href="#demo"
                        class="cta-primary w-full sm:w-auto px-5 py-3 rounded-md shadow hover:shadow-lg transition hero-cta">{{ __('messages.cta.primary') }}</a>
                    <a href="#features"
                        class="w-full sm:w-auto px-4 py-3 rounded-md border hover:bg-emerald-50 text-center">{{ __('messages.cta.secondary') }}</a>
                </div>

                <ul class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
                    <li>{!! __('messages.hero.benefit1') !!}</li>
                    <li>{!! __('messages.hero.benefit2') !!}</li>
                    <li>{!! __('messages.hero.benefit3') !!}</li>
                    <li>{!! __('messages.hero.benefit4') !!}</li>
                </ul>
            </div>

            <div class="hero-visual p-2 md:p-4 fade-in" aria-hidden="true">
                <!-- Placeholder screenshot; replace with real screenshot or embed iframe / demo -->
                <img src="/images/demo.webp" alt="Interactive family tree preview"
                    class="w-full rounded-md shadow-sm h-56 md:h-auto object-cover" />
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
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5"
                                d="M19.7165 20.3624C21.143 19.5846 22 18.5873 22 17.5C22 16.3475 21.0372 15.2961 19.4537 14.5C17.6226 13.5794 14.9617 13 12 13C9.03833 13 6.37738 13.5794 4.54631 14.5C2.96285 15.2961 2 16.3475 2 17.5C2 18.6525 2.96285 19.7039 4.54631 20.5C6.37738 21.4206 9.03833 22 12 22C15.1066 22 17.8823 21.3625 19.7165 20.3624Z"
                                fill="#1C274C" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5 8.51464C5 4.9167 8.13401 2 12 2C15.866 2 19 4.9167 19 8.51464C19 12.0844 16.7658 16.2499 13.2801 17.7396C12.4675 18.0868 11.5325 18.0868 10.7199 17.7396C7.23416 16.2499 5 12.0844 5 8.51464ZM12 11C13.1046 11 14 10.1046 14 9C14 7.89543 13.1046 7 12 7C10.8954 7 10 7.89543 10 9C10 10.1046 10.8954 11 12 11Z"
                                fill="#1C274C" />
                        </svg>
                    </div>
                    <h3 class="font-semibold">{{ __('messages.feature.auto.title') }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.auto.desc') }}</p>
                </article>

                <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
                    <div class="feature-icon mb-3" aria-hidden>
                        <svg width="40" height="40" viewBox="0 -22.71 350.877 350.877"
                            xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <style>
                                    .a {
                                        fill: #a98a75;
                                    }

                                    .b {
                                        fill: #ffffff;
                                    }

                                    .c {
                                        fill: #241a18;
                                    }

                                    .d {
                                        fill: #211715;
                                    }

                                    .e {
                                        fill: #febe69;
                                    }

                                    .f {
                                        fill: #85807f;
                                    }
                                </style>
                            </defs>
                            <!-- large svg kept as-is -->
                        </svg>
                    </div>
                    <h3 class="font-semibold">{{ __('messages.feature.spouse.title') }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.spouse.desc') }}</p>
                </article>

                <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
                    <div class="feature-icon mb-3" aria-hidden>
                        <svg fill="#000000" width="40" height="40" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M29.5 7c-1.381 0-2.5 1.12-2.5 2.5 0 0.284 0.058 0.551 0.144 0.805l-6.094 5.247c-0.427-0.341-0.961-0.553-1.55-0.553-0.68 0-1.294 0.273-1.744 0.713l-4.774-2.39c-0.093-1.296-1.162-2.323-2.482-2.323-1.38 0-2.5 1.12-2.5 2.5 0 0.378 0.090 0.732 0.24 1.053l-4.867 5.612c-0.273-0.102-0.564-0.166-0.873-0.166-1.381 0-2.5 1.119-2.5 2.5s1.119 2.5 2.5 2.5c1.381 0 2.5-1.119 2.5-2.5 0-0.332-0.068-0.649-0.186-0.939l4.946-5.685c0.236 0.073 0.48 0.124 0.74 0.124 0.727 0 1.377-0.316 1.834-0.813l4.669 2.341c0.017 1.367 1.127 2.471 2.497 2.471 1.381 0 2.5-1.119 2.5-2.5 0-0.044-0.011-0.086-0.013-0.13l6.503-5.587c0.309 0.137 0.649 0.216 1.010 0.216 1.381 0 2.5-1.119 2.5-2.5s-1.119-2.5-2.5-2.5z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-semibold">{{ __('messages.feature.collapse.title') }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.collapse.desc') }}</p>
                </article>

                <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
                    <div class="feature-icon mb-3" aria-hidden>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2l3 8H9l3-8z" stroke="#10b981" stroke-width="1.6" />
                        </svg>
                    </div>
                    <h3 class="font-semibold">{{ __('messages.feature.edit.title') }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.edit.desc') }}</p>
                </article>

                <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
                    <div class="feature-icon mb-3" aria-hidden>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M21 8v8" stroke="#10b981" stroke-width="1.6" />
                        </svg>
                    </div>
                    <h3 class="font-semibold">{{ __('messages.feature.export.title') }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ __('messages.feature.export.desc') }}</p>
                </article>

                <article class="p-5 bg-white rounded-lg shadow-sm fade-in feature-card">
                    <div class="feature-icon mb-3" aria-hidden>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M12 20v-6" stroke="#10b981" stroke-width="1.6" />
                        </svg>
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
                    <img src="images/demo.webp"
                        alt="Family tree editor preview screenshot" class="w-full rounded-md demo-img" />
                    <figcaption class="text-xs text-gray-500 mt-2">Editor preview — add nodes and relations
                    </figcaption>
                </figure>
                <figure class="bg-white p-3 rounded-lg shadow-sm fade-in">
                    <img src="images/demo.webp" alt="Auto layout example"
                        class="w-full rounded-md demo-img" />
                    <figcaption class="text-xs text-gray-500 mt-2">Auto layout handling spouses and parents
                    </figcaption>
                </figure>
                <figure class="bg-white p-3 rounded-lg shadow-sm fade-in">
                    <img src="images/demo.webp"
                        alt="Collapsed branches preview" class="w-full rounded-md demo-img" />
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
        <section id="contact" class="bg-gradient-to-r from-emerald-500 to-emerald-300 text-white">
            <div class="max-w-4xl mx-auto px-4 py-12 text-center">
                <h2 class="text-3xl font-bold">{{ __('messages.cta.title') }}</h2>
                <p class="mt-2 max-w-2xl mx-auto">{{ __('messages.cta.desc') }}</p>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="/sample"
                        class="px-6 py-3 bg-white text-emerald-600 rounded-md font-semibold">{{ __('messages.cta.demo') }}</a>
                    <a href="mailto:hello@example.com?subject=Family%20Tree%20Demo"
                        class="px-6 py-3 border border-white/30 rounded-md">{{ __('messages.cta.walk') }}</a>
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

            <p class="mt-6 text-xs text-gray-400">© <span id="year"></span> Family Tree Builder —
                {{ __('messages.footer.desc') }}</p>
        </div>
    </footer>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('mobile-menu-button')
        const menu = document.getElementById('mobile-menu')
        if (btn && menu) {
          btn.addEventListener('click', () => {
            const present = menu.classList.toggle('hidden') // returns true if hidden after toggle
            // aria-expanded should reflect whether menu is open
            btn.setAttribute('aria-expanded', String(!present))
          })
        }

        // quick reveal for .fade-in elements (helps mobile when GSAP hasn't run)
        document.querySelectorAll('.fade-in').forEach((el) => {
          el.style.transition = 'opacity .45s ease, transform .45s ease'
          el.style.opacity = '1'
          el.style.transform = 'none'
        })
      })
    </script>

    <script src="landing.js"></script>
</body>

</html>