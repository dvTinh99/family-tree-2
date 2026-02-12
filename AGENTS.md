# AGENTS.md

This is a full-stack family tree application with Laravel (PHP 8.2+) backend, Vue 3 + TypeScript frontend, and SQLite database.

## Build Commands

### Frontend (Node.js)

```bash
npm install           # Install dependencies
npm run dev           # Start Vite dev server (runs on port 5174)
npm run build         # Build for production
npm run lint          # Lint TypeScript/Vue files
npm run lint:fix      # Auto-fix linting issues
npm run format        # Format with Prettier (no semis, single quotes, trailing commas es5)
```

### Backend (PHP/Laravel)

```bash
composer install              # Install PHP dependencies
composer run dev              # Start all dev services (server, queue, logs, vite)
./vendor/bin/pint             # Fix PHP code style (PSR-12)
```

### Testing

```bash
composer test                                   # Run all tests
./vendor/bin/phpunit --testsuite=Unit          # Run specific suite
./vendor/bin/phpunit tests/Unit/UserTest.php   # Run single test file
./vendor/bin/phpunit --filter=testUserCanRegister  # Run single test
```

Tests use SQLite in-memory database (configured in phpunit.xml).

## Code Style

### PHP (Laravel)

**Naming:**

- Classes: `PascalCase` (e.g., `FamilyTreeController`)
- Methods/variables: `camelCase`
- Constants: `SCREAMING_SNAKE_CASE`
- Tables: `snake_case` plural (e.g., `family_nodes`)
- Foreign keys: `singular_table_name_id`

**Formatting:**

- Use `./vendor/bin/pint` for auto-formatting
- PSR-12 standard, no closing `?>` in pure PHP files
- Line length ~100 chars, use `declare(strict_types=1);`

**Imports:** Group by type (built-in → composer → app namespace)

**Error Handling:**

```php
try {
    // operations
} catch (JWTException $e) {
    Log::error('Operation failed', ['error' => $e->getMessage()]);
    return $this->responseError([], $e->getMessage());
}
```

### TypeScript/Vue

**Naming:**

- Components: `PascalCase.vue` (e.g., `PersonModal.vue`)
- Utilities: `kebab-case.ts`
- Interfaces/Types: `PascalCase` (e.g., `IUser`, `FamilyNode`)

**Imports:**

- Use `@/` alias (maps to `resources/js/`)
- Order: Vue → Router/Pinia → Components → Utils/Services → Types

**Formatting:**

- Prettier: no semicolons, single quotes, trailing commas `es5`, printWidth 100
- Strict TypeScript enabled

**Vue Components:**

```vue
<script setup lang="ts">
import { ref, computed } from 'vue'
import { useFamilyStore } from '@/store/family'
import type { INode } from '@/types/node'

interface Props {
  nodeId: string
}

const props = defineProps<Props>()
const emit = defineEmits(['update', 'delete'])
const isOpen = ref(false)
</script>
```

**Pinia Store:**

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

## Project Structure

```
app/
├── Http/Controllers/     # API controllers
├── Http/Requests/        # Form requests
├── Models/               # Eloquent models
├── Repositories/         # Data access layer
└── Services/             # Business logic

resources/js/
├── components/
│   ├── ui/              # Base UI (shadcn-vue)
│   ├── common/          # Shared components
│   ├── nodes/           # Vue Flow node components
│   └── edges/           # Vue Flow edge components
├── composables/         # Vue composables
├── pages/               # Page components
├── store/               # Pinia stores
├── types/               # TypeScript interfaces
├── utils/               # Utilities
└── router/              # Vue Router

tests/
├── Unit/                # Unit tests
└── Feature/             # Integration tests
```

## Key Libraries

- **Vue Flow**: Interactive graph visualization
- **JWT Auth**: Token-based authentication
- **Pinia + Persisted State**: State management
- **Tailwind CSS**: Styling
- **Vee-Validate**: Form validation

## Common Tasks

**New API endpoint:**

1. Create request in `app/Http/Requests/`
2. Add controller method
3. Add route in `routes/api.php`
4. Add repository/service method if needed

**New Vue page:**

1. Create component in `resources/js/pages/`
2. Add route in `resources/js/router/router.ts`
3. Create store if needed

**New UI component:**

1. Follow shadcn-vue pattern in `resources/js/components/ui/`
2. Export from index file
3. Update types

## Git Conventions

- Branches: `feature/description` or `fix/issue-description`
- Commits: imperative mood, concise
- PRs: include context and testing steps
