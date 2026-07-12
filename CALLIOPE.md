# Calliope — Boilerworks Laravel + Vue
<!-- Agent shim for https://github.com/calliopeai/calliope-cli -->

Primary conventions doc: [`bootstrap.md`](bootstrap.md)

Read it before writing any code.

---

## Project-specific notes

- Laravel 12 (PHP 8.3) + Inertia.js v3 + Vue 3 Composition API (`<script setup lang="ts">`); Tailwind CSS 4, Vite 7; Filament v5 admin at `/admin` (admin role only).
- Eloquent business models use `HasAuditTrail`, `HasUuid`, `SoftDeletes`; UUID route model binding with `$hidden = ['id']` — never expose integer primary keys.
- Session-based auth (Laravel built-in, no Sanctum; sessions in Redis, httpOnly cookies); Spatie group-based permissions on every controller (middleware in constructor); frontend guards via the `Can` component.
- `Inertia::render()` for reads, `redirect()->route()` for mutations; form requests authorize `true` (permissions handled by middleware).
- Forms + workflow engines (`WorkflowTransitionService`, `ConditionEvaluator`); feature toggles in `config/features.php`.
- Make targets: `make up`, `make fresh`, `make seed`, `make test`, `make lint` / `make lint-fix`; app :8000, Vite HMR :5173.
