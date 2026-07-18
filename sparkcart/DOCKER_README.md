Quick Docker dev setup

This Compose file runs three services for local development:
- `backend` — PHP/Laravel served by `php artisan serve` on port 8000
- `frontend` — Vite dev server on port 5173
- `db` — MySQL 8.0

Quick start (requires Docker Engine & Docker Compose):

1. Copy Laravel environment file and update DB settings (if needed):

```powershell
cd "C:\Users\kioko\Desktop\project perple\sparkcart\backend"
copy .env.example .env
```

2. Start services:

```powershell
cd "C:\Users\kioko\Desktop\project perple\sparkcart"
docker compose up --build
```

3. (Optional) Run migrations from the backend container once the DB is ready:

```powershell
docker compose exec backend sh -c "composer install && php artisan migrate"
```

Open the app in your browser:
- Backend: http://127.0.0.1:8000
- Frontend: http://127.0.0.1:5173
