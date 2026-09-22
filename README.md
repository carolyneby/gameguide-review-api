# GameGuide Review API

A Laravel REST API demonstrating backend fundamentals: Eloquent relationships, request validation, API resource shaping, and Sanctum authentication — built as a companion backend to my [GameGuide Review Console](https://gameguide-review-console.netlify.app) React dashboard.

**Live API:** [https://gameguide-api.thonky.com](https://gameguide-api.thonky.com) — try it: [gameguide-api.thonky.com/api/games](https://gameguide-api.thonky.com/api/games)

**Highlights:**
- RESTful API with resource controllers, form request validation, and typed JSON resources
- Token-based auth (Laravel Sanctum) protecting write access to sensitive endpoints
- Seeded, filterable data — games → guides → review notes
- Feature-tested with PHPUnit (7/7 passing)
- Containerized local development environment via Laravel Sail (Docker)
- Deployed on self-managed LAMP hosting (Linux/Apache/MySQL/PHP) under my own domain, not a managed PaaS

**Stack:** PHP 8.5 · Laravel 13 · MySQL · Sanctum · PHPUnit · Docker (Sail, local dev)

---

## Why this project exists

This project demonstrates core Laravel backend patterns: Eloquent relationships, database migrations/seeders, Form Request validation, API Resource response shaping, and Sanctum token authentication. The domain (games → guides → review notes) mirrors an editorial review workflow for walkthrough content on Thonky.com — the same kind of workflow built out in the [Review Notes WordPress plugin](https://github.com/carolyneby/review-notes-plugin), so the three projects together tell a consistent full-stack story: a WordPress plugin managing review status on the live site, a React console for browsing and managing that review queue, and this API as the backend that powers it.

## Stack

- Laravel 13
- MySQL (production) — SQLite or containerized MySQL supported for local development
- Laravel Sanctum (API token authentication)
- PHPUnit (feature tests)
- Docker / Laravel Sail (containerized local development)

## Domain model

```
Game (title, platform, release_year)
  └─ hasMany Guide (title, status: draft | in_review | published)
       └─ hasMany ReviewNote (body, author)
```

## Local development setup

```bash
composer install
cp .env.example .env
php artisan key:generate

# SQLite setup (local dev)
touch database/database.sqlite
# In .env, set: DB_CONNECTION=sqlite

php artisan migrate --seed
php artisan serve
```

A seeded reviewer account (`carolyn@example.com`) is created automatically for testing the Sanctum-protected endpoints.

## Local development with Docker

As an alternative to the setup above, this project also supports fully containerized local development via [Laravel Sail](https://laravel.com/docs/sail) (Docker), running the app alongside real MySQL and Redis services:

```bash
composer require laravel/sail --dev
php artisan sail:install   # select mysql and redis
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
```

The application is available at `http://localhost` (or a custom port set via `APP_PORT` in `.env`). Run tests inside the container with `./vendor/bin/sail artisan test`.

## Running tests

```bash
php artisan test
```

## API endpoints

| Method | Endpoint | Auth required | Description |
|---|---|---|---|
| GET | `/api/games` | No | List games with guide counts |
| POST | `/api/games` | No | Add a game |
| GET | `/api/games/{id}` | No | Show a game with its guides |
| DELETE | `/api/games/{id}` | No | Delete a game |
| GET | `/api/guides` | No | List guides (filterable by `game_id`, `status`) |
| POST | `/api/guides` | No | Create a guide |
| GET | `/api/guides/{id}` | No | Show a guide with game + review notes |
| PUT | `/api/guides/{id}` | No | Update a guide (e.g. change status) |
| DELETE | `/api/guides/{id}` | No | Delete a guide |
| POST | `/api/review-notes` | Yes (Sanctum) | Add a review note as the authenticated user |
| DELETE | `/api/review-notes/{id}` | Yes (Sanctum) | Delete a review note |

**Example: filtering guides awaiting review**
```
GET https://gameguide-api.thonky.com/api/guides?status=in_review
```

## Deployment notes

This API is deployed on self-managed LAMP hosting under my own domain (`gameguide-api.thonky.com`), rather than a managed platform like Render or Railway — set up via SSH, Composer, and a symlinked document root pointing at Laravel's `public/` directory, backed by a dedicated MySQL database. Docker/Sail is used for local development only; the live deployment remains traditional LAMP hosting, not containerized. In a production deployment serving real traffic, the game/guide write endpoints would also sit behind authentication — they're left open here to make the API easy to explore without needing a token for every request. The review-notes endpoints are protected to demonstrate Sanctum usage specifically.
