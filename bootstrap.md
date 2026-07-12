# Boilerworks Laravel + Vue -- Bootstrap

> Laravel 12 + Inertia.js v3 + Vue 3 Composition API. Server-driven SPA with
> session-based auth, group-based permissions, forms engine, and workflow engine.

## Architecture

```
Browser
  +-- Vue 3 (Composition API) via Inertia.js
        |-- Pages: server-driven routing (no client-side router)
        |-- Components: reusable Vue components
        |-- Composables: shared stateful logic
        +-- useForm(): Inertia form handling
              |
              v (Inertia protocol)
        Laravel 12 (Eloquent, Middleware, Service Providers)
              |-- Laravel Queues (Redis driver)
              |-- Postgres 16 (data)
              |-- Redis 7 (cache, sessions, queue broker)
              +-- MinIO (S3-compatible storage)
```

## Conventions

### Models
- All business models use `HasAuditTrail`, `HasUuid`, `SoftDeletes` traits
- `HasAuditTrail` auto-sets `created_by`/`updated_by` from `auth()->id()`
- `HasUuid` generates UUID on create, overrides `getRouteKeyName()` to `uuid`
- Never expose integer primary keys — use `uuid` for URLs and API responses
- `protected $hidden = ['id']` on all models

### Controllers
- Auth check via `$this->middleware(['auth'])` in constructor
- Permission check via `$this->middleware('permission:resource.action')` in constructor
- Return `Inertia::render()` for reads, `redirect()->route()` for mutations
- Form requests for validation (authorize returns true — permissions handled by middleware)

### Vue Pages
- `<script setup lang="ts">` — always TypeScript
- `useForm()` for form submissions
- `AppLayout` wraps all authenticated pages
- `Can` component for frontend permission guards
- Flash messages via `FlashMessages` component

### Auth
- Session-based auth via Laravel's built-in `auth` middleware
- Sessions stored in Redis, delivered as httpOnly cookies
- No JWTs, no Sanctum — pure session auth
- Roles: admin (all permissions), editor (create/edit), viewer (read-only)

### Permissions
- Spatie Laravel Permission — group-based, never user-based
- Roles own permissions; users get roles
- Permission middleware on every controller
- Frontend: `Can` component checks `page.props.auth.permissions`

### Filament Admin
- Filament v5 panel at `/admin` (`AdminPanelProvider`, id `admin`)
- Access restricted to the admin role via `User::canAccessPanel()`
- Resources in `app/Filament/Resources` (Users, Items, Categories, FormDefinitions, WorkflowDefinitions), auto-discovered
- Filament is for back-office admin only — end-user UI stays in Inertia/Vue pages

### Feature Toggles
- `config/features.php` — env-based booleans
- Routes conditionally loaded in `AppServiceProvider`
- Shared to frontend via `HandleInertiaRequests` middleware

### Testing
- Pest PHP for feature tests
- Real database (RefreshDatabase trait)
- Test both allowed and denied permission cases
- Assert against database state and Inertia page components

### Docker
- `make up` starts everything: PHP-FPM + Nginx, Vite, Postgres, Redis, MinIO, Mailpit, queue worker
- Health check at `/up`, status at `/status`
- Ports: App 8000, Vite 5173, Postgres 5432, Redis 6379, MinIO 9000/9001, Mailpit 8025 (SMTP 1025)

### Linting
- PHP: Laravel Pint (PSR-12 preset)
- Vue/TS: ESLint + Prettier
- Run `make lint` to check, `make lint-fix` to auto-fix

### Seed Users
| Email | Password | Role |
|-------|----------|------|
| admin@boilerworks.dev | password | admin |
| editor@boilerworks.dev | password | editor |
| viewer@boilerworks.dev | password | viewer |
