# Agent Instructions: carnet-biblioteca

Compact guidance for maintaining this Laravel application.

## Core Stack & Conventions
- **PHP 8.5+**
- **Laravel 13**
- **Livewire 4 + Flux UI**
- **Pest 4** for testing

### Skills Activation
Activate domain-specific skills found in `.agents/skills/` (e.g., `laravel-best-practices`, `pest-testing`, `fluxui-development`) immediately upon starting relevant tasks.

## Commands & Workflow
- **Code Style (Required):** Run `vendor/bin/pint --format agent` after any PHP changes to auto-format.
- **Testing:** 
  - Use `php artisan test --compact` for execution.
  - Create new tests with `php artisan make:test --pest {Name}`.
- **Frontend Issues:** If UI changes don't show, check `npm run dev` or `composer run dev`. If Vite fails, run `npm run build`.
- **Artisan:**
  - Always use `--no-interaction`.
  - Use single quotes for `php artisan tinker --execute '...'`.
  - Filter `php artisan route:list` with flags like `--method=GET` to manage output size.

## Project Quirks
- **Database:** Favor factories over manual model instantiation in tests.
- **Structure:** Do not introduce new base directories. Reuse existing components before creating new ones.
- **Documentation:** Only create if explicitly requested.
