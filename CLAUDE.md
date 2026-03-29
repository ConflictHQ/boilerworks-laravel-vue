# Claude -- Boilerworks Laravel + Vue

Primary conventions doc: [`bootstrap.md`](bootstrap.md)

Read it before writing any code.

## Stack

- **Backend**: Laravel 12 (PHP 8.3)
- **Frontend**: Vue 3 (Composition API) via Inertia.js v3
- **ORM**: Eloquent (PostgreSQL 16)
- **Auth**: Session-based (Laravel's built-in auth, no Sanctum)
- **Authorization**: Spatie Laravel Permission (group-based roles)
- **Admin**: Filament v5 (admin role only, at `/admin`)
- **Jobs**: Laravel Queues (Redis driver)
- **Cache/Sessions**: Redis 7
- **CSS**: Tailwind CSS 4
- **Build**: Vite 7

## Quick Reference

| Service | URL |
|---------|-----|
| App | http://localhost:8000 |
| Health | http://localhost:8000/up |
| Status | http://localhost:8000/status |
| Admin | http://localhost:8000/admin |
| Vite HMR | http://localhost:5173 |
| Mailpit | http://localhost:8025 |
| MinIO | http://localhost:9001 |

## Commands

```bash
make up          # Start all services
make down        # Stop all services
make seed        # Seed database
make fresh       # Fresh migrate + seed
make lint        # Run all linters
make lint-fix    # Fix lint issues
make test        # Run tests
make coverage    # Run tests with coverage
make console     # Laravel tinker
make logs        # Tail logs
make shell       # Shell into backend
```

## Structure

```
app/
  Enums/             # FormStatus, WorkflowStatus
  Http/Controllers/  # Auth, Dashboard, Item, Category, FormDefinition, FormSubmission, WorkflowDefinition, WorkflowInstance
  Http/Middleware/    # HandleInertiaRequests
  Http/Requests/     # Form requests per resource
  Jobs/              # WorkflowActionJob
  Models/            # User, Item, Category, FormDefinition, FormSubmission, WorkflowDefinition, WorkflowInstance, TransitionLog
  Rules/             # ValidFormSubmission
  Services/          # WorkflowTransitionService, ConditionEvaluator
  Traits/            # HasAuditTrail, HasUuid
resources/js/
  Components/        # Can, FlashMessages, Pagination, FieldRenderer, DynamicForm, FormBuilder, WorkflowBuilder
  Layouts/           # AppLayout
  Pages/             # Auth, Dashboard, Items, Categories, Forms, Workflows
```

## Rules

- Traits: HasAuditTrail, HasUuid, SoftDeletes on all business models
- UUID for route model binding (never expose integer IDs)
- Soft delete via `->delete()` (SoftDeletes handles `deleted_at`)
- Spatie permissions on every controller (middleware in constructor)
- `auth` middleware (not `auth:sanctum`)
- Inertia::render() for all responses, no Blade views (except app.blade.php)
- Vue Composition API with `<script setup lang="ts">`
- Feature toggles in config/features.php
