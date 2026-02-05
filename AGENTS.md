# AGENTS.md

This document provides guidelines for AI agents working on this Family Tree project.

## Project Overview

This is a full-stack family tree application with:

- **Backend**: Laravel (PHP 8.2+) with JWT authentication
- **Frontend**: Vue 3 + TypeScript with Vite
- **Database**: SQLite (default) or other Laravel-supported databases
- **State Management**: Pinia
- **UI Components**: Custom Vue components with Tailwind CSS

## Build Commands

### Frontend (Node.js)

```bash
# Install dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build

# Lint TypeScript/Vue files
npm run lint

# Auto-fix linting issues
npm run lint:fix

# Format code with Prettier
npm run format
```

### Backend (PHP/Laravel)

```bash
# Install PHP dependencies
composer install

# Start Laravel server (requires npm run dev)
composer run dev

# Run all dev services (server, queue, logs, vite)
composer run dev

# Run tests
composer test

# Fix PHP code style
./vendor/bin/pint
```

### Docker

```bash
# Start all services
docker-compose up -d

# View logs
docker-compose logs -f
```

## Testing

### PHP Tests

```bash
# Run all tests
composer test

# Run specific test suite
./vendor/bin/phpunit --testsuite=Unit
./vendor/bin/phpunit --testsuite=Feature

# Run single test file
./vendor/bin/phpunit tests/Unit/UserTest.php

# Run single test
./vendor/bin/phpunit --filter=testUserCanRegister
```

### Test Database

Tests use SQLite in-memory database (configured in `phpunit.xml`). No migration needed.

## Code Style

### General Principles

- Follow existing patterns in the codebase
- Keep functions small and focused
- Use meaningful names for variables, functions, and files
- Avoid magic numbers; use constants or config values
- Handle errors gracefully with appropriate logging

### PHP (Laravel)

**Naming Conventions:**

- Classes: `PascalCase` (e.g., `User`, `FamilyTreeController`)
- Methods: `camelCase` (e.g., `getUser()`, `createFamily()`)
- Variables: `camelCase` (e.g., `$userName`, `$familyTree`)
- Constants: `SCREAMING_SNAKE_CASE`
- Database tables: `snake_case` plural (e.g., `users`, `family_nodes`)
- Foreign keys: `singular_table_name_id` (e.g., `user_id`)

**Formatting:**

- Use Laravel Pint for automatic formatting: `./vendor/bin/pint`
- PSR-12 coding standard
- No closing PHP tag `?>` in pure PHP files
- Line length: ~100 characters max
- Use strict types: `declare(strict_types=1);`

**Imports:**

- Use fully qualified class names or imports
- Group imports by type: built-in, composer, app namespace

**Error Handling:**

- Use `try/catch` blocks for external operations
- Log exceptions with `Log::debug()` or `Log::error()`
- Return consistent response format using controller helpers

**Example:**

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();

            if (auth()->attempt($credentials)) {
                return $this->responseSuccess([
                    'user' => auth()->user(),
                ], 'Login successful');
            }

            return $this->responseError([
                'message' => 'Invalid credentials',
            ], 401);
        } catch (\Exception $e) {
            Log::error('Login failed', ['error' => $e->getMessage()]);

            return $this->responseError([], 'An error occurred');
        }
    }
}
```

### TypeScript/Vue

**Naming Conventions:**

- Components: `PascalCase` (e.g., `PersonModal.vue`, `FamilyTree.vue`)
- Files: `kebab-case` for utilities, `PascalCase` for components
- Variables/ Functions: `camelCase` (e.g., `userData`, `handleSubmit()`)
- Constants: `SCREAMING_SNAKE_CASE` or `camelCase` for local
- Interfaces/Types: `PascalCase` (e.g., `IUser`, `FamilyNode`)

**Imports:**

- Use `@/` alias for internal imports (maps to `resources/js/`)
- Order: Vue imports → Router/Pinia → Components → Utils/Services → Types

**Formatting:**

- Prettier configuration in `.prettierrc`:
  - No semicolons
  - Single quotes
  - Trailing commas: `es5`
  - Print width: 100
- Run `npm run format` to auto-format

**TypeScript:**

- Enable strict mode in `tsconfig.json`
- Use explicit types for function parameters and return values
- Use interfaces for object shapes, types for unions/primitives
- Avoid `any`; use `unknown` when type is uncertain

**Vue Components:**

- Use `<script setup lang="ts">` for new components
- Define props with TypeScript interfaces
- Use composition API with reactive state
- Emit events with explicit payload types

**Example:**

```typescript
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'
import type { IUser } from '@/types/user'

interface LoginPayload {
  email: string
  password: string
}

export default defineComponent({
  name: 'LoginPage',
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()

    const email = ref('')
    const password = ref('')
    const isLoading = ref(false)

    const isFormValid = computed(() => email.value.includes('@') && password.value.length >= 6)

    async function handleSubmit(): Promise<void> {
      if (!isFormValid.value) return

      isLoading.value = true
      try {
        const payload: LoginPayload = {
          email: email.value,
          password: password.value,
        }

        await authStore.login(payload)
        router.push({ name: 'home' })
      } catch (error) {
        console.error('Login failed:', error)
      } finally {
        isLoading.value = false
      }
    }

    return {
      email,
      password,
      isLoading,
      isFormValid,
      handleSubmit,
    }
  },
})
```

**Store (Pinia):**

```typescript
export const useAuthStore = defineStore(
  'auth',
  () => {
    const user = ref<IUser | null>(null)
    const accessToken = ref('')

    async function login(credentials: LoginPayload): Promise<void> {
      const response = await api.post('/auth/login', credentials)
      accessToken.value = response.data.access_token
      user.value = response.data.user
    }

    return { user, accessToken, login }
  },
  { persist: true }
)
```

### Git Conventions

- Branch naming: `feature/description` or `fix/issue-description`
- Commit messages: imperative mood, concise description
- Pull requests: include context and testing steps

## Project Structure

```
├── app/
│   ├── Http/Controllers/    # API controllers
│   ├── Models/              # Eloquent models
│   ├── Repositories/        # Data access layer
│   ├── Services/            # Business logic
│   └── Http/Requests/       # Form requests
├── resources/js/
│   ├── components/
│   │   ├── ui/             # Base UI components (shadcn-vue style)
│   │   ├── common/         # Shared components
│   │   ├── nodes/          # Vue Flow node components
│   │   └── edges/          # Vue Flow edge components
│   ├── composables/         # Vue composables
│   ├── pages/              # Page components
│   ├── store/              # Pinia stores
│   ├── types/              # TypeScript interfaces
│   ├── utils/              # Utility functions
│   └── router/             # Vue Router config
├── routes/                  # Laravel route files
└── tests/
    ├── Unit/               # Unit tests
    └── Feature/            # Integration tests
```

## Key Libraries

- **Vue Flow**: Interactive graph visualization for family trees
- **JWT Auth**: Token-based authentication
- **Pinia + Persisted State**: Client-side state management
- **Tailwind CSS**: Utility-first styling

## Common Tasks

**Adding a new API endpoint:**

1. Create request class in `app/Http/Requests/`
2. Create controller method or update existing
3. Add route in `routes/api.php`
4. Add repository/service method if needed

**Adding a new Vue page:**

1. Create Vue component in `resources/js/pages/`
2. Add route in `resources/js/router/router.ts`
3. Create store if needed in `resources/js/store/`

**Adding UI component:**

1. Follow shadcn-vue pattern in `resources/js/components/ui/`
2. Export index file for easy imports
3. Update types if needed
