<template>
    <div class="min-h-screen bg-slate-100 flex items-center justify-center">

  <div class="w-full max-w-md px-6">
    <!-- Card -->
    <div class="rounded-2xl bg-white p-8 shadow-sm border border-slate-200">

      <!-- Header -->
      <div class="mb-6 text-center">
        <h1 class="text-2xl font-semibold text-slate-900">
          Sign in
        </h1>
        <p class="mt-1 text-sm text-slate-500">
          Access your family tree
        </p>
      </div>

      <!-- Form -->
      <form class="space-y-4">

        <!-- Email -->
        <div>
          <label class="block text-sm font-medium text-slate-700">
            Email address
          </label>
          <input
            type="email"
            placeholder="you@example.com"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                   text-sm focus:border-indigo-500 focus:ring-2
                   focus:ring-indigo-100 outline-none"
          />
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-medium text-slate-700">
            Password
          </label>
          <input
            type="password"
            placeholder="••••••••"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                   text-sm focus:border-indigo-500 focus:ring-2
                   focus:ring-indigo-100 outline-none"
          />
        </div>

        <!-- Remember -->
        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2 text-sm text-slate-600">
            <input
              type="checkbox"
              class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
            />
            Remember me
          </label>

          <a href="#" class="text-sm text-indigo-600 hover:underline">
            Forgot password?
          </a>
        </div>

        <!-- Button -->
        <button
          type="submit"
          class="mt-4 w-full rounded-lg bg-indigo-600 py-2.5
                 text-sm font-medium text-white
                 hover:bg-indigo-700 transition"
        >
          Sign in
        </button>
      </form>

      <!-- Footer -->
      <div class="mt-6 text-center text-sm text-slate-500">
        Don’t have an account?
        <a href="#" class="text-indigo-600 hover:underline">
          Sign up
        </a>
      </div>
    </div>

    <!-- Brand -->
    <p class="mt-6 text-center text-xs text-slate-400">
      © 2026 Family Tree
    </p>
  </div>

</div>
</template>
