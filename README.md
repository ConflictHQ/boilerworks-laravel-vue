# Boilerworks Laravel + Vue

> Laravel 12 + Inertia.js + Vue 3 full-stack template with session auth,
> group-based permissions, forms engine, workflow engine, and Boilerworks
> dark admin theme.

## Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.3) |
| Frontend | Vue 3 (Composition API) via Inertia.js v3 |
| Database | PostgreSQL 16 |
| Cache/Sessions | Redis 7 |
| Queue | Laravel Queues (Redis driver) |
| Auth | Session-based (httpOnly cookies) |
| Authorization | Spatie Laravel Permission |
| CSS | Tailwind CSS 4 |
| Build | Vite 7 |
| Tests | Pest PHP |

## Features

- Server-driven SPA via Inertia.js (no client-side router)
- Session-based auth with login, register, logout
- Group-based RBAC: admin, editor, viewer roles with granular permissions
- Items + Categories CRUD with data tables, pagination, flash messages
- Forms engine: JSON schema builder, dynamic form renderer, server-side validation
- Workflow engine: state machine with conditions, async action dispatch, audit trail
- Filament v5 admin panel at `/admin` (admin role only)
- Feature toggles (env-based, conditionally loaded routes)
- Boilerworks dark admin theme with sidebar navigation
- Docker Compose: PHP-FPM + Nginx, Vite HMR, Postgres, Redis, MinIO, Mailpit, queue worker
- CI pipeline: PHP lint, JS lint, tests, security audit, build check

## Getting Started

### Prerequisites

- Docker and Docker Compose
- Make (optional, for convenience commands)

### Quick Start

```bash
# Clone the repo
git clone git@github.com:ConflictHQ/boilerworks-laravel-vue.git
cd boilerworks-laravel-vue

# Copy environment file
cp .env.example .env

# Start all services
make up

# Run migrations and seed
make fresh

# Open in browser
open http://localhost:8000
```

### Seed Users

| Email | Password | Role |
|-------|----------|------|
| admin@boilerworks.dev | password | admin |
| editor@boilerworks.dev | password | editor |
| viewer@boilerworks.dev | password | viewer |

## Endpoints

| URL | Description |
|-----|-------------|
| http://localhost:8000 | Application |
| http://localhost:8000/up | Health check |
| http://localhost:8000/status | Status page (JSON) |
| http://localhost:5173 | Vite HMR dev server |
| http://localhost:8025 | Mailpit (email viewer) |
| http://localhost:9001 | MinIO console |

## Commands

```bash
make up          # Start Docker services
make down        # Stop Docker services
make fresh       # Fresh migrate + seed
make seed        # Run seeders
make lint        # Run all linters
make lint-fix    # Auto-fix lint issues
make test        # Run Pest tests
make coverage    # Run tests with coverage report
make console     # Laravel tinker
make logs        # Tail container logs
make shell       # Shell into backend container
```

## Documentation

- [bootstrap.md](bootstrap.md) -- Conventions and patterns
- [CLAUDE.md](CLAUDE.md) -- Agent shim
- [CALLIOPE.md](CALLIOPE.md) -- Agent shim (Calliope harness)
- [CONTRIBUTING.md](CONTRIBUTING.md) -- Contribution guide
- [SECURITY.md](SECURITY.md) -- Security policy

---

Boilerworks is a [CONFLICT](https://weareconflict.com) brand. CONFLICT is a registered trademark of CONFLICT LLC.
