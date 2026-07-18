Local STK Push testing (Sandbox)

Prerequisites
- PHP CLI installed and available in PATH
- Composer dependencies installed (run `composer install` in `backend`)
- ngrok (or a publicly deployed HTTPS endpoint)

Steps
1. Start the Laravel development server:

```powershell
cd backend
php artisan serve --host=127.0.0.1 --port=8000
```

2. Expose the local server with ngrok (in a separate terminal):

```powershell
ngrok http 8000
```

Copy the HTTPS forwarding URL (e.g. `https://abcd1234.ngrok.io`).

3. Update callback URLs in `backend/.env`:

- `MPESA_STK_CALLBACKURL=https://<your-ngrok-id>.ngrok.io/mpesa/callback`
- `MPESA_CALLBACK_URL=https://<your-ngrok-id>.ngrok.io/mpesa/callback`

Reload config if necessary or restart the dev server.

4. Run the quick STK test script:

```powershell
cd backend
php test_stkpush.php
```

5. Watch logs for callback entries:

- `storage/logs/laravel.log`
- `storage/logs/mpesa_callbacks.log`

Notes
- Keep `MPESA_ENABLED=true` and `MPESA_ENVIRONMENT=sandbox` when testing.
- When moving to production, set `MPESA_ENVIRONMENT=production`, ensure `MPESA_ENABLED=true`, and replace sandbox keys with production Daraja credentials.
