<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Iankumu\Mpesa\Facades\Mpesa;
use App\Models\Payment;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $query = Product::with('category')->latest();
        if (!empty($searchQuery)) {
            $query->where('name', 'like', '%' . $searchQuery . '%')
                ->orWhere('description', 'like', '%' . $searchQuery . '%');
        }

        $products = $query->get();
        $searchProducts = Product::with('category')->get();
        $categories = Category::orderBy('name')->get();
        $cart = session()->get('cart', []);
        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
            $cartCount += $item['quantity'];
        }

        return view('shop.index', compact('products', 'searchProducts', 'categories', 'cart', 'cartTotal', 'cartCount', 'searchQuery'));
    }

    public function getProductDetails($id)
    {
        $product = Product::with('category')->find($id);
        if (! $product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json(['success' => true, 'product' => $product]);
    }

    public function show(Request $request, $id)
    {
        $productDetail = Product::with('category')->find($id);
        if (! $productDetail) {
            return redirect()->route('shop.index');
        }

        $searchQuery = $request->input('search');
        $query = Product::with('category')->latest();
        if (! empty($searchQuery)) {
            $query->where('name', 'like', '%' . $searchQuery . '%')
                ->orWhere('description', 'like', '%' . $searchQuery . '%');
        }

        $products = $query->get();
        $searchProducts = Product::with('category')->get();
        $cart = session()->get('cart', []);
        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
            $cartCount += $item['quantity'];
        }

        return view('shop.index', compact('products', 'searchProducts', 'cart', 'cartTotal', 'cartCount', 'searchQuery', 'productDetail'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image_path' => $product->image_path,
            ];
        }

        session()->put('cart', $cart);

        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
            $cartCount += $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2),
            'cart_items' => $cart,
        ]);
    }

    public function updateQuantity(Request $request, $id)
    {
        $quantity = intval($request->input('quantity', 1));
        $cart = session()->get('cart', []);

        if (! isset($cart[$id])) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        if ($quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
            $cartCount += $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2),
            'cart_items' => $cart,
        ]);
    }

    public function removeFromCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
            $cartCount += $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2),
            'cart_items' => $cart,
        ]);
    }

    public function handleRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => ['required', 'string', 'max:20', 'regex:/^[\+0-9\s\-\(\)]{9,20}$/'],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'This email address is already registered. Did you forget your password?',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'The passwords you entered do not match.',
        ]);

        $phone = $this->formatPhoneNumber($request->input('phone'));
        if (! preg_match('/^254[0-9]{9}$/', $phone)) {
            return response()->json(['success' => false, 'message' => 'Please enter a valid M-Pesa phone number.'], 422);
        }

        try {
            $user = \App\Models\User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $phone,
                'password' => \Illuminate\Support\Facades\Hash::make($request->input('password')),
            ]);

            auth()->login($user);

            session()->put('customer_user', [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'guest' => false,
            ]);

            $redirect = $request->input('intended_route') ?: route('dashboard');

            return response()->json(['success' => true, 'message' => 'Registration completed', 'redirect' => $redirect]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['success' => false, 'message' => 'Unable to create account. Please try again.'], 500);
        }
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
            $cartCount += $item['quantity'];
        }

        $customerUser = session()->get('customer_user');
        return view('shop.checkout', compact('cart', 'cartTotal', 'cartCount', 'customerUser'));
    }

    public function dashboard(Request $request)
    {
        $customerUser = session()->get('customer_user');
        return view('shop.dashboard', compact('customerUser'));
    }

    public function handleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $identifier = $request->input('email');
        if (!filter_var($identifier, FILTER_VALIDATE_EMAIL) && !preg_match('/^(?:07|01|254)\d{8}$/', preg_replace('/[^0-9]/', '', $identifier))) {
            return response()->json(['success' => false, 'message' => 'Please enter a valid email address or Kenyan phone number.']);
        }

        session()->put('customer_user', [
            'name' => 'Baraka Customer',
            'email' => $identifier,
            'guest' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Login successful']);
    }

    public function handleGuestCheckout(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'email' => 'nullable|string|max:255',
        ]);

        session()->put('customer_user', [
            'name' => 'Guest Shopper',
            'email' => $request->input('email') ?: 'guest+' . uniqid() . '@barakasolar.local',
            'phone' => $this->formatPhoneNumber($request->input('phone')),
            'guest' => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Guest checkout enabled']);
    }

    private function formatPhoneNumber($phone)
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (strpos($clean, '254') === 0) {
            return $clean;
        }
        if (strpos($clean, '0') === 0) {
            return '254' . substr($clean, 1);
        }
        return $clean;
    }

    public function handleLogout()
    {
        session()->forget('customer_user');
        return redirect()->route('shop.index');
    }

    public function mpesaPay(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $rawPhone = $request->input('phone');
        $phone = preg_replace('/[^0-9]/', '', $rawPhone);
        if (strpos($phone, '0') === 0) {
            $phone = '254' . substr($phone, 1);
        } elseif (strpos($phone, '7') === 0) {
            $phone = '254' . $phone;
        }

        if (! preg_match('/^2547[0-9]{8}$/', $phone)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid phone number format. Use a valid Kenyan number.',
            ], 422);
        }

        // Allow frontend to pass an explicit amount (for single-item quick-buy)
        $amount = $request->input('amount');
        $productId = $request->input('product_id');

        $cart = session()->get('cart', []);

        if (empty($amount)) {
            $amount = 0;
            foreach ($cart as $item) {
                $amount += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
            }
        }

        // If cart is empty but a product_id is given, add that product as a single-item purchase
        if (($amount <= 0 || empty($cart)) && $productId) {
            $product = Product::find($productId);
            if ($product) {
                $cart[$productId] = [
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                    'image_path' => $product->image_path,
                ];
                session()->put('cart', $cart);
                $amount = $product->price;
            }
        }

        if ($amount <= 0) {
            $amount = 1; // Fallback minimal amount
        }

        $accountReference = '9906877'; // Your unique bank payment identifier (STEVEN)
        $transactionDesc  = 'Sparkcart Checkout Payment';
        $callbackUrl = config('mpesa.callbacks.callback_url') ?: url('/mpesa/callback');

        if (! config('mpesa.enabled')) {
            return response()->json([
                'success' => true,
                'message' => 'M-Pesa STK push simulated. Configure Daraja credentials and enable `MPESA_ENABLED` to perform live payments.',
                'phone' => $phone,
                'amount' => number_format($amount, 2),
            ]);
        }

        try {
            $response = Mpesa::stkpush(
                $phone,
                $amount,
                $accountReference,
                $callbackUrl,
                Mpesa::PAYBILL
            );

            if (! $response->successful()) {
                throw new \Exception('M-Pesa request failed: ' . $response->body());
            }

            return response()->json([
                'success' => true,
                'message' => 'STK Push prompt triggered successfully on your mobile screen!',
                'data' => $response->json(),
            ]);
        } catch (\Throwable $e) {
            Log::error('MPESA STK error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Daraja API Connection failure: ' . $e->getMessage(),
            ], 500);
        }
    }

    protected function getMpesaBaseUrl(): string
    {
        return config('mpesa.environment') === 'production'
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    protected function getMpesaAccessToken(): string
    {
        return Cache::remember('mpesa_access_token', 55 * 60, function () {
            $response = Http::withBasicAuth(
                config('mpesa.mpesa_consumer_key'),
                config('mpesa.mpesa_consumer_secret')
            )->get($this->getMpesaBaseUrl() . '/oauth/v1/generate?grant_type=client_credentials');

            if (! $response->successful()) {
                throw new \Exception('Failed to retrieve M-Pesa access token: ' . $response->body());
            }

            return $response->json()['access_token'];
        });
    }

    public function mpesaCallback(Request $request)
    {
        $payload = $request->all();

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/mpesa_callbacks.log'),
        ])->info(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        // Attempt to extract STK callback details (safely handle different structures)
        $stk = $payload['Body']['stkCallback'] ?? null;
        $data = [];
        if ($stk && is_array($stk)) {
            $merchantRequestId = $stk['MerchantRequestID'] ?? null;
            $checkoutRequestId = $stk['CheckoutRequestID'] ?? null;
            $resultCode = $stk['ResultCode'] ?? null;
            $resultDesc = $stk['ResultDesc'] ?? null;

            $amount = null;
            $phoneNumber = null;
            $accountReference = null;
            $transactionDesc = null;

            if (! empty($stk['CallbackMetadata']['Item']) && is_array($stk['CallbackMetadata']['Item'])) {
                foreach ($stk['CallbackMetadata']['Item'] as $item) {
                    $name = $item['Name'] ?? null;
                    $value = $item['Value'] ?? null;
                    if (! $name) continue;
                    switch (strtolower($name)) {
                        case 'amount': $amount = $value; break;
                        case 'mpesa receipt number': $transactionDesc = $value; break;
                        case 'phone number': $phoneNumber = $value; break;
                        case 'transaction amount': $amount = $value; break;
                        case 'transaction receipt': $transactionDesc = $value; break;
                        case 'account balance': break;
                        case 'billing reference number': $accountReference = $value; break;
                        case 'account reference': $accountReference = $value; break;
                    }
                }
            }

            // Persist a Payment record for reconciliation and debugging
            try {
                Payment::create([
                    'merchant_request_id' => $merchantRequestId,
                    'checkout_request_id' => $checkoutRequestId,
                    'result_code' => $resultCode,
                    'result_desc' => $resultDesc,
                    'status' => ($resultCode === 0) ? 'success' : 'failed',
                    'phone_number' => $phoneNumber,
                    'amount' => $amount,
                    'account_reference' => $accountReference,
                    'transaction_desc' => $transactionDesc,
                    'callback_payload' => $payload,
                    'received_at' => now(),
                ]);
            } catch (\Throwable $e) {
                Log::error('Failed to persist MPESA callback: ' . $e->getMessage());
            }
        } else {
            // Save raw payload when structure is different
            try {
                Payment::create([
                    'callback_payload' => $payload,
                    'status' => 'unknown',
                    'received_at' => now(),
                ]);
            } catch (\Throwable $e) {
                Log::error('Failed to persist MPESA callback (raw): ' . $e->getMessage());
            }
        }

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Callback data logged and persisted.',
        ]);
    }
}
