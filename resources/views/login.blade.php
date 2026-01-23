<!doctype html>
<html lang="{{ app()->getLocale() ?? 'en' }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Sign in — Family Tree</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.webp">

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style> body { font-family: 'Inter', system-ui, -apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial; } </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-white to-emerald-50 flex items-center justify-center p-6">
  <main class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Left: Visual / branding -->
    <section class="hidden md:flex flex-col justify-center rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-200 text-white p-10 shadow-lg">
      <div class="flex items-center gap-3 mb-6">
        <div class="bg-white/10 p-2 rounded">
          <!-- small tree icon -->
          <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" aria-hidden><path d="M12 2v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M8 8c-2 0-4 2-4 4 0 2 2 4 4 4h8c2 0 4-2 4-4 0-2-2-4-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div>
          <h1 class="text-lg font-semibold">Family Tree Builder</h1>
          <p class="text-sm text-emerald-100/90">Design, visualize and preserve your family's story.</p>
        </div>
      </div>

      <div class="grow flex items-center">
        <figure class="w-full">
          <img src="{{ asset('images/demo.webp') }}" alt="Interactive family tree preview" class="w-full rounded-xl shadow-inner object-cover h-64" onerror="this.src='{{ asset('images/graph.svg') }}'">
          <figcaption class="mt-3 text-sm text-emerald-100/80">Interactive editor — add people, spouses and branches</figcaption>
        </figure>
      </div>

      <div class="mt-6 text-sm text-emerald-100/80">
        <ul class="space-y-1">
          <li>• Auto-layout tuned for parents & spouses</li>
          <li>• Collapse branches for focus</li>
          <li>• Export PNG / PDF for sharing</li>
        </ul>
      </div>
    </section>

    <!-- Right: Form -->
    <section class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
      <div class="max-w-md mx-auto">
        <header class="flex items-center justify-between mb-6">
          <div>
            <h2 class="text-2xl font-bold text-slate-900">Welcome back</h2>
            <p class="mt-1 text-sm text-slate-500">Sign in to manage your family tree</p>
          </div>
          <img src="images/logo.webp" alt="logo" class="h-8 w-8" onerror="this.style.display='none'">
        </header>

        @if(session('status'))
          <div class="mb-4 rounded-md bg-green-50 px-4 py-2 text-sm text-emerald-800">{{ session('status') }}</div>
        @endif

        @if($errors->any())
          <div class="mb-4">
            <ul class="space-y-1 text-sm text-red-700">
              @foreach($errors->all() as $error)
                <li class="flex items-start gap-2">
                  <svg class="h-5 w-5 text-red-500 mt-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.68-1.36 3.445 0l6.518 11.59A1.5 1.5 0 0 1 17.518 17H2.482a1.5 1.5 0 0 1-1.702-2.311L8.257 3.1zM11 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" clip-rule="evenodd"/></svg>
                  <span>{{ $error }}</span>
                </li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
          @csrf

          <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
            <input id="email" name="email" type="email" autocomplete="email" required autofocus
              value="{{ old('email') }}"
              class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400" />
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <div class="mt-1 relative">
              <input id="password" name="password" type="password" autocomplete="current-password" required
                class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400" />
              <button type="button" aria-label="Toggle password visibility" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500">
                <svg id="pw-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </button>
            </div>
            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-600">
              <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
              Remember me
            </label>
            <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:underline">Forgot password?</a>
          </div>

          <div>
            <button type="submit" class="w-full rounded-lg bg-emerald-600 py-2.5 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-200">Sign in</button>
          </div>

          <div class="relative my-3">
            <div class="absolute inset-0 flex items-center" aria-hidden><div class="w-full border-t border-slate-200"></div></div>
            <div class="relative flex justify-center text-sm"><span class="px-2 bg-white text-slate-400">Or continue with</span></div>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('social.redirect', 'google') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm hover:bg-slate-50">
              <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="h-4 w-4" />
              Google
            </a>
            <a href="{{ route('social.redirect', 'github') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm hover:bg-slate-50">
              <img src="https://www.svgrepo.com/show/349527/github.svg" alt="GitHub" class="h-4 w-4" />
              GitHub
            </a>
          </div>

          <p class="mt-4 text-center text-sm text-slate-500">Don't have an account?
            <a href="{{ route('register') }}" class="text-emerald-600 font-medium hover:underline">Create one</a>
          </p>

          <div class="mt-4 text-center">
            <a href="{{ url('/sample') }}" class="inline-flex items-center gap-2 text-sm text-emerald-600 hover:underline">
              Try Demo <span class="text-slate-400">— explore sample trees</span>
            </a>
          </div>
        </form>

        <footer class="mt-6 text-center text-xs text-slate-400">© <span id="year"></span> Family Tree</footer>
      </div>
    </section>
  </main>

  <script>
    // set year
    document.getElementById('year')?.replaceWith(document.createTextNode(new Date().getFullYear().toString()))

    function togglePassword(){
      const input = document.getElementById('password')
      const eye = document.getElementById('pw-eye')
      if (!input) return
      if (input.type === 'password') {
        input.type = 'text'
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.591-4.13M6.12 6.12A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.07 5.57M3 3l18 18"/>';
      } else {
        input.type = 'password'
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
      }
    }
  </script>
</body>
</html>