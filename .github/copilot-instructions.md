# Copilot Instructions

## Project Overview

This is a Laravel 12 backend for a Telegram Bot that summarizes YouTube videos using AI.
The bot receives YouTube URLs via Telegram, extracts transcripts and metadata (Supadata SDK),
processes them with OpenAI, and sends summaries back to users.

**Tech stack:** PHP 8.4, Laravel 12, PostgreSQL, Redis, Laravel Horizon (queues), Pest (testing).

## Architecture

The project follows an event-driven, service-oriented architecture:

- **Handlers** — Chain of Responsibility pattern for routing Telegram webhook updates
  (`YoutubeUrlHandler → StartCommandHandler → CallbackHandler → TextHandler`).
- **Services** — Business logic layer; all database mutations wrapped in transactions.
- **Jobs** — Async processing via Laravel queues (e.g., `ProcessYoutubeVideo`, `AskQuestionAboutYoutubeVideo`).
- **Events & Listeners** — Decouple processing outcomes from side effects (notifications, state updates).
- **DTOs** — Spatie Laravel Data objects for type-safe data transfer between layers.
- **Value Objects** — Immutable domain primitives with validation (e.g., `YoutubeUrl`, `YoutubeVideoId`).
- **Enums** — Typed enums for state management (e.g., `State`).
- **Telegram entities** — Full Telegram Bot API entity classes in `app/Telegram/Entities/`.
- **Supadata SDK** — Internal SDK in `app/Supadata/` for YouTube metadata and transcript extraction.

## Coding Conventions

### Strict PHP

- Every file MUST start with `declare(strict_types=1);`.
- All classes MUST be `final` unless abstract.
- Use `readonly` properties and constructor promotion wherever possible.
- Prefer `private` visibility over `protected` (`protected_to_private` rule is active).
- Use strict comparison operators (`===`, `!==`) exclusively.
- Use `mb_*` string functions instead of plain string functions.

### Class Structure

Follow this element ordering within classes (enforced by Pint):

1. Traits (`use` statements)
2. Cases (for enums)
3. Constants (public → protected → private)
4. Properties (public → protected → private)
5. Constructor / Destructor
6. Magic methods
7. PHPUnit/Pest methods
8. Abstract methods
9. Public static methods → Public methods
10. Protected static methods → Protected methods
11. Private static methods → Private methods

### Naming & Style

- Use Laravel naming conventions (PascalCase classes, camelCase methods, snake_case DB columns).
- Fully qualify all imports — no inline FQCN, always `use` at the top.
- No superfluous `else`/`elseif` — return early instead.
- No multiple statements per line.
- Use `DateTimeImmutable` over `DateTime`.

### Value Objects & DTOs

- Value objects use private constructors with static factory methods (e.g., `fromString()`).
- DTOs extend `Spatie\LaravelData\Data` with typed properties.
- Both must be immutable (`readonly`).

### Exception Handling

- Business exceptions extend `BusinessException` (abstract), carry `chatId` context.
- Business exceptions implement `ShouldntReport` to avoid noisy error tracking.
- Let infrastructure exceptions (DB, network) propagate for Sentry reporting.

## Testing

- Use **Pest** testing framework (not PHPUnit directly).
- Test files go in `tests/` directory.

## Quality Tools

Run all checks with: `composer test`

| Tool     | Command                  | Purpose                  |
|----------|--------------------------|--------------------------|
| Pint     | `composer lint`          | Code style (Laravel preset + strict rules) |
| Rector   | `composer refactor`      | Code modernization       |
| PHPStan  | `composer test:types`    | Static analysis (level 6) |
| Pest     | `php artisan test`       | Unit & feature tests     |

## Infrastructure

- **Docker**: PHP 8.4-FPM + Nginx + Supervisor + Cron.
- **Database**: PostgreSQL (primary), Redis (cache, queues, sessions).
- **Queues**: Laravel Horizon manages Redis-backed queues.
- **Monitoring**: Sentry for error tracking.
- **Makefile**: Use `make up`, `make down`, `make restart`, `make app-console` for Docker operations.

## Key Patterns to Follow

1. **New Telegram handler** → extend `Handler`, implement `handle()`, add to chain in `TelegramController`.
2. **New async task** → create a Job (`ShouldQueue`), dispatch from service/listener.
3. **New domain entity** → create Model + Migration + DTO + Service.
4. **New external integration** → create a dedicated SDK directory under `app/` with entities, enums, and services.
5. **Database changes** → always wrap multi-model writes in `DB::transaction()`.
