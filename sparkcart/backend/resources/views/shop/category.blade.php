<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category - Baraka Solar Shop</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <script src="{{ asset('js/shop.js') }}" defer></script>
    <style>
        :root {
            color-scheme: dark;
            --bg: #070309;
            --bg-alt: #12090f;
            --text: #f8f4ff;
            --muted: rgba(248, 244, 255, 0.72);
            --border: rgba(255, 255, 255, 0.08);
            --accent: #ff2b3b;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top right, rgba(255, 43, 59, 0.12), transparent 20%),
                linear-gradient(180deg, var(--bg) 0%, var(--bg-alt) 100%);
            color: var(--text);
        }
        a { color: inherit; text-decoration: none; }
        .site-nav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(8, 8, 24, 0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 43, 59, 0.14);
        }
        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
            padding: 0.85rem 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .nav-left { display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; }
        .nav-logo { display: inline-flex; gap: 0.75rem; align-items: center; font-weight: 900; }
        .nav-logo img { width: 36px; height: 36px; border-radius: 10px; object-fit: cover; }
        .nav-links { display: flex; gap: 0.7rem; flex-wrap: wrap; }
        .nav-links a,
        .category-tab {
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.04);
            font-size: 0.85rem;
            font-weight: 700;
            transition: transform 0.18s ease, background 0.18s ease;
        }
        .nav-links a:hover,
        .category-tab:hover,
        .nav-links a.active,
        .category-tab.active {
            background: rgba(255, 43, 59, 0.18);
            border-color: rgba(255, 43, 59, 0.25);
            transform: translateY(-1px);
        }
        .category-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
            justify-content: center;
            padding: 0.75rem 1rem 0.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .filter-notice {
            text-align: center;
            color: var(--muted);
            font-size: 0.85rem;
            margin: 0 1rem 1rem;
        }
        .category-header {
            max-width: 1200px;
            margin: 0 auto 1.2rem;
            padding: 0 1rem;
        }
        .category-header h1 {
            font-size: clamp(2rem, 3vw, 3rem);
            margin: 0 0 0.5rem;
        }
        .category-header p {
            color: var(--muted);
            max-width: 48rem;
            line-height: 1.6;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
            max-width: 1200px;
            margin: 0 auto 2rem;
            padding: 0 1rem;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.15rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }
        .card img {
            width: 100%;
            display: block;
            object-fit: cover;
            height: 200px;
        }
        .card-body {
            padding: 1rem;
            flex: 1;
        }
        .card-body h2 {
            font-size: 1.02rem;
            margin: 0 0 0.65rem;
        }
        .product-price {
            font-size: 1rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 0.75rem;
        }
        .card-footer {
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }
        .btn,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: none;
            padding: 0.75rem 1rem;
            font-weight: 700;
            cursor: pointer;
        }
        .btn { background: linear-gradient(135deg, #ff2b3b, #ff7a72); color: #fff; }
        .btn-secondary { background: rgba(255,255,255,0.08); color: #fff; }
        .hero-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 0.75rem;
        }
        .page-footer {
            text-align: center;
            color: var(--muted);
            font-size: 0.8rem;
            padding: 1rem;
        }

        .page-loader {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.65);
            z-index: 999;
        }

        .page-loader.active {
            display: flex;
        }

        .page-loader-ring {
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.12);
            border-top-color: #ff2b3b;
            animation: page-loader-rotate 1s linear infinite;
            box-shadow: 0 0 0 4px rgba(255, 43, 59, 0.08);
        }

        .page-loader-label {
            margin-top: 1rem;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            opacity: 0.95;
        }

        @keyframes page-loader-rotate {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 640px) {
            .nav-container { flex-direction: column; align-items: stretch; }
            .nav-left { width: 100%; justify-content: space-between; }
            .nav-links { justify-content: center; }
        }
    </style>
</head>
<body>
    @php use Illuminate\Support\Str; @endphp
    <nav class="site-nav">
        <div class="nav-container">
            <div class="nav-left">
                <a href="{{ route('shop.index') }}" class="nav-logo">
                    <img src="{{ asset('images/logo/images.jpg') }}" alt="Baraka Solar Shop Logo" onerror="this.style.display='none'">
                    <span>Baraka Solar Shop</span>
                </a>
                <div class="nav-links">
                    <a href="{{ route('shop.index') }}">Home</a>
                    <a href="{{ route('shop.index') }}">Products</a>
                    <a href="#support">Support</a>
                </div>
            </div>
            <a href="{{ route('shop.index') }}" class="btn-secondary">Back to full shop</a>
        </div>
        <div class="category-tabs" aria-label="Category navigation">
            @foreach(collect($categories ?? [])->mapWithKeys(fn($category) => [$category->slug => $category->name]) as $slug => $label)
                <a href="{{ route('shop.category', ['slug' => $slug]) }}" class="category-tab{{ isset($selectedCategorySlug) && $selectedCategorySlug === $slug ? ' active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>
        <div class="filter-notice">
            Showing all products in <strong>{{ $selectedCategoryName ?? 'this category' }}</strong>
        </div>
    </nav>

    <div id="page-loader" class="page-loader" aria-hidden="true">
        <div class="page-loader-ring"></div>
        <div class="page-loader-label">Loading</div>
    </div>

    <section class="category-header">
        <h1>{{ $selectedCategoryName ?? 'Category' }}</h1>
        <p>Browse every item available for this category. Click a product to view details, add to cart, or pay with M-Pesa.</p>
    </section>

    @if(empty($products) || count($products) === 0)
        <div class="page-footer">
            No products were found in this category yet. <a href="{{ route('shop.index') }}" class="hero-link">Return to the main shop</a>
        </div>
    @else
        <div class="grid-container">
            @foreach($products as $product)
                <article class="card">
                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h2>{{ $product->name }}</h2>
                        <div class="product-price">Ksh {{ number_format($product->price, 2) }}</div>
                        <p style="color: var(--muted); font-size:0.9rem; line-height:1.5;">{{ Str::limit($product->description, 120) }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn-secondary">Details</a>
                        <button type="button" class="btn" data-nav-url="{{ route('product.show', ['id' => $product->id]) }}">Buy now</button>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    <footer class="page-footer">
        Baraka Solar Shop — category powered shopping for smarter solar purchases.
    </footer>
    <script>
        function hidePageLoader() {
            const loader = document.getElementById('page-loader');
            if (!loader) return;
            loader.classList.remove('active');
            document.body.style.pointerEvents = '';
            document.body.style.cursor = '';
            loader.setAttribute('aria-hidden', 'true');
        }

        function showPageLoader() {
            const loader = document.getElementById('page-loader');
            if (!loader) return;
            loader.classList.add('active');
            document.body.style.pointerEvents = 'none';
            document.body.style.cursor = 'progress';
            loader.setAttribute('aria-hidden', 'false');
        }

        function navigateWithLoader(url) {
            if (!url) return;
            showPageLoader();
            requestAnimationFrame(() => {
                setTimeout(() => {
                    window.location.href = url;
                }, 35);
            });
        }

        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                hidePageLoader();
            }
        });
        window.addEventListener('load', hidePageLoader);

        document.querySelectorAll('a[href]').forEach(link => {
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) return;
            if (link.target === '_blank' || link.hasAttribute('download')) return;
            if (href.startsWith('/')) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateWithLoader(link.href);
                });
            }
        });

        document.querySelectorAll('[data-nav-url]').forEach(navItem => {
            navItem.addEventListener('click', function(e) {
                const url = this.getAttribute('data-nav-url');
                if (url) {
                    e.preventDefault();
                    navigateWithLoader(url);
                }
            });
        });
    </script>
</body>
</html>
