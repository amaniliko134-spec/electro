<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Baraka Solar Shop</title>
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
</head>
<body>
    <div style="min-height:100vh; padding:2rem; background:#070309; color:#f8f4ff;">
        <header style="display:flex; justify-content:space-between; gap:1rem; align-items:center; margin-bottom:2rem;">
            <div>
                <h1>Welcome, {{ $customerUser['name'] ?? auth()->user()->name }}</h1>
                <p style="color:#94a3b8;">Manage your account and continue shopping with faster checkout.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="btn btn-secondary">Back to store</a>
        </header>

        <div style="display:grid; gap:1.5rem; max-width:900px; margin:auto;">
            <div class="card">
                <h2 class="section-title">Account details</h2>
                <p><strong>Email:</strong> {{ $customerUser['email'] ?? auth()->user()->email }}</p>
                <p><strong>Phone:</strong> {{ $customerUser['phone'] ?? 'Not available' }}</p>
                <p><strong>Status:</strong> {{ $customerUser['guest'] ? 'Guest shopper' : 'Registered customer' }}</p>
            </div>
            <div class="card">
                <h2 class="section-title">Next steps</h2>
                <ul style="list-style:none; padding:0; display:grid; gap:0.9rem;">
                    <li style="background:rgba(255,255,255,0.04); padding:1rem; border-radius:18px;">Browse back to the catalog and add new items.</li>
                    <li style="background:rgba(255,255,255,0.04); padding:1rem; border-radius:18px;">Open checkout to complete payment.</li>
                    <li style="background:rgba(255,255,255,0.04); padding:1rem; border-radius:18px;">Contact support if you need help with M-Pesa payment.</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
