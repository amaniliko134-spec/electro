# M-Pesa (Safaricom Daraja) Integration Setup

This document explains how to enable M-Pesa (STK Push) for this Laravel project.

1) Install the PHP package (run locally):
```bash
cd "C:/Users/kioko/Desktop/project perple/sparkcart/backend"
composer require iankumu/mpesa
```

2) Publish the package configuration architecture:
```bash
php artisan mpesa:install
```

3) Add Daraja credentials to your backend `.env` file:
```env
MPESA_ENVIRONMENT=sandbox
MPESA_CONSUMER_KEY=3tuHKwVPBhOQKqtldtHMoHhlfCp3axYJUov5AlhXhG1BGhsW
MPESA_CONSUMER_SECRET=pEKY4tmhqWHM1SoUFl9Qy3gRTkwmGd7a6MVjNzXT0JZbGshRRcNZplbNiDbo7Ak
SAFARICOM_PASSKEY=bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919
MPESA_BUSINESS_SHORTCODE=174379
MPESA_CALLBACK_URL=https://ngrok-free.app
```

4) Usage notes
- Set your credentials to perform real Daraja integration.
- Enable live STK pushes by setting `MPESA_ENABLED=true` in your `.env`.
- For production, set `MPESA_ENVIRONMENT=production`, change your shortcode to your real Paybill/Till shortcode, and update all keys.
- This package reads `environment` from `MPESA_ENVIRONMENT`, `mpesa_consumer_key` from `MPESA_CONSUMER_KEY`, `mpesa_consumer_secret` from `MPESA_CONSUMER_SECRET`, `passkey` from `SAFARICOM_PASSKEY`, `shortcode` from `MPESA_BUSINESS_SHORTCODE`, and callback URL from `MPESA_CALLBACK_URL`.
- Your callback should point to your publicly accessible app URL with `/mpesa/callback`, for example `https://<your-ngrok-domain>/mpesa/callback`.
- The callback endpoint `/mpesa/callback` is already exempted from CSRF verification in `bootstrap/app.php`.
- Your current app routing already includes:
  - `POST /mpesa/pay/{id}`
  - `POST /mpesa/callback`

5) Testing STK Push
- Use the UI: click `Pay M-Pesa` on a product card, enter a valid MSISDN (2547XXXXXXXX) and send.
- If configured correctly, the package will perform an STK Push via Daraja and you should receive a prompt on the phone.

6) Callback endpoint
- The app exposes a callback endpoint at `/mpesa/callback` which will accept POST JSON payloads from Daraja/STK and append them to `storage/logs/mpesa_callbacks.log` for inspection.

7) Notes on testing via curl
- Example simulated callback (run locally):

```bash
curl -X POST http://127.0.0.1:8000/mpesa/callback -H "Content-Type: application/json" -d '{"Body":{"stkCallback":{"MerchantRequestID":"123","CheckoutRequestID":"abc","ResultCode":0,"ResultDesc":"The service request is processed successfully."}}}'
```

This should append the JSON payload to `storage/logs/mpesa_callbacks.log`.

6) Security
- Never commit your Daraja secrets to source control. Keep credentials in environment variables or a secret manager.

If you'd like, I can also:
- Add a `config/mpesa.php` stub.
- Wire the `mpesaPay` controller method to the package SDK (requires credentials).
