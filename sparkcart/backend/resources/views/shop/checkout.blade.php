<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Baraka Solar Shop</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
</head>
<body>
    <div class="checkout-shell" style="min-height:100vh; padding:2rem; background:#070309; color:#f8f4ff;">
        <header style="display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:2rem;">
            <div>
                <h1>Checkout</h1>
                <p style="color:#c9c0c8; max-width:40rem;">Review your basket and complete payment with M-Pesa. If you are not already signed in, please register or login first.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="btn btn-secondary" style="height:fit-content;">Continue shopping</a>
        </header>

        <div style="display:grid; gap:1.5rem; max-width:980px; margin:auto;">
            <section class="card">
                <h2 class="section-title">Order summary</h2>
                @if(empty($cart) || count($cart) === 0)
                    <p>Your cart is empty. Add products to continue.</p>
                @else
                    <div style="display:grid; gap:1rem;">
                        @foreach($cart as $item)
                            <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1rem; border-radius:18px; background:rgba(255,255,255,0.04);">
                                <div>
                                    <strong>{{ $item['name'] }}</strong>
                                    <div style="color:#94a3b8;">Qty: {{ $item['quantity'] }} • Ksh {{ number_format($item['price'], 2) }}</div>
                                </div>
                                <div style="font-weight:700;">Ksh {{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1.5rem; padding:1rem; border-radius:18px; background:rgba(255,255,255,0.08);">
                        <span style="font-weight:700;">Total</span>
                        <span style="font-size:1.35rem; font-weight:800;">Ksh {{ number_format($cartTotal, 2) }}</span>
                    </div>
                @endif
            </section>

            <section class="card">
                <h2 class="section-title">Customer</h2>
                @if(!empty($customerUser))
                    <p><strong>{{ $customerUser['name'] ?? auth()->user()->name }}</strong></p>
                    <p>{{ $customerUser['email'] ?? auth()->user()->email }}</p>
                    <p>{{ $customerUser['phone'] }}</p>
                @else
                    <p>Please sign in or create an account before completing checkout.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">Open shop</a>
                @endif
            </section>
        </div>
    </div>
</body>
</html>
