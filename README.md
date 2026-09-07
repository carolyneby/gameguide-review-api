# GameGuide Review API

*A Laravel REST API demonstrating backend fundamentals: Eloquent relationships, request validation, API resource shaping, and Sanctum authentication — built as a companion backend to my [GameGuide Review Console](https://cohort-review-console.netlify.app) React dashboard.*

**Highlights:**
- RESTful API with resource controllers, form request validation, and typed JSON resources
- Token-based auth (Laravel Sanctum) protecting write access to sensitive endpoints
- Seeded, filterable data — games → guides → review notes
- Feature-tested with PHPUnit

**Stack:** PHP 8 · Laravel 11 · SQLite · Sanctum · PHPUnit

---

## Why this project exists

This project demonstrates core Laravel backend patterns: Eloquent relationships, database migrations/seeders, Form Request validation, API Resource response shaping, and Sanctum token authentication. The domain (games → guides → review notes) mirrors an editorial review workflow for walkthrough content on [Thonky.com](https://thonky.com) — the same kind of workflow built out in the [Review Notes WordPress plugin](https://github.com/carolyneby/review-notes-plugin), so the three projects together tell a consistent full-stack story: a WordPress plugin managing review status on the live site, a React console for browsing and managing that review queue, and this API as the backend that could power it.

## Stack

- Laravel 11
- SQLite (zero-config local development)
- Laravel Sanctum (API token authentication)
- PHPUnit (feature tests)

## Domain model

```
Game (title, platform, release_year)
  └─ hasMany Guide (title, status: draft | in_review | published)
       └─ hasMany ReviewNote (body, author)
```

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate

# SQLite setup
touch database/database.sqlite
# In .env, set: DB_CONNECTION=sqlite

php artisan migrate --seed
php artisan serve
```

A seeded reviewer account (`carolyn@example.com`) is created automatically for testing the Sanctum-protected endpoints.

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
| POST | `/api/review-notes` | **Yes (Sanctum)** | Add a review note as the authenticated user |
| DELETE | `/api/review-notes/{id}` | **Yes (Sanctum)** | Delete a review note |

## Example: filtering guides awaiting review

```
GET /api/guides?game_id=1&status=in_review
```

## Notes

In a production deployment, the game/guide write endpoints would also sit behind authentication — they're left open here to make the API easy to explore without needing a token for every request. The review-notes endpoints are protected to demonstrate Sanctum usage specifically.
