# Insider One Champions League

A football league simulator built for the Insider technical case. It generates a fixture for four teams, simulates matches based on team strength, tracks the league table with Premier League rules and predicts championship odds using a Monte Carlo simulation.

## Live Demo

- Frontend: https://insider-league.vercel.app/
- API: https://insider-league-production.up.railway.app/api/standings

## Tech Stack

- **Backend:** Laravel (PHP 8.4), PostgreSQL, PHPUnit
- **Frontend:** Vue 3, TypeScript, Pinia, Vite, Vitest
- **Infrastructure:** Docker, docker-compose

## Features

- Round-robin fixture generation (home & away, six weeks)
- Match simulation weighted by team strength where weaker teams still have a chance to win
- League standings with points, goal difference and Premier League tie-breakers
- Monte Carlo championship prediction (shown from week 4)
- Play next week, play all weeks and reset
- Unit tests on both backend and frontend

## Architecture

The core logic lives in framework-independent service classes which keeps it testable and easy to reason about:

- `FixtureGenerator` — builds the round-robin schedule
- `MatchSimulator` — produces a score from two team strengths
- `StandingsCalculator` — computes and orders the table from played matches
- `ChampionshipPredictor` — runs Monte Carlo simulations of the remaining matches
- `LeagueService` — coordinates these services and persists results

The frontend follows a container/presentational pattern. Pinia store holds the shared state and presentational components receive data via props and emit user events upward.

## Running with Docker

The whole stack (backend, frontend, database) runs with a single command:

```bash
docker-compose up --build
```

- Frontend: http://localhost:5173
- API: http://localhost:8000/api

## Running Manually

### Backend

```bash
cd backend
composer install
php artisan migrate --seed
php artisan serve
```

### Frontend

```bash
cd frontend
npm install
npm run dev
```

## Running Tests

### Backend

```bash
cd backend
php artisan test
```

### Frontend

```bash
cd frontend
npm run test:unit
```

## Notes & Assumptions

- The league has four fixed teams with predefined strengths. The fixture algorithm is written generically so the team count does not break it.
- Championship predictions are calculated at all times but only displayed from week 4 as described in the case.
- The match simulation is intentionally simple but reflects the brief. Stronger teams win more often while weaker teams still have a realistic chance to win.