<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #0f172a;
            color: #e2e8f0;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        a {
            color: #93c5fd;
            text-decoration: none;
        }
        .page-shell {
            max-width: 1080px;
            margin: 0 auto;
            padding: 24px;
        }
        .top-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            margin-bottom: 24px;
        }
        .top-nav a {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(148,163,184,0.2);
            border-radius: 9999px;
            padding: 10px 16px;
            color: #e2e8f0;
            transition: background .15s ease;
        }
        .top-nav a:hover {
            background: rgba(255,255,255,0.14);
        }
        .card {
            background: rgba(15,23,42,0.96);
            border: 1px solid rgba(148,163,184,0.16);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
        }
        .section-title {
            margin-bottom: 16px;
            font-size: 1.3rem;
            font-weight: 700;
            color: #f8fafc;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.95rem;
            color: #cbd5e1;
        }
        .form-control {
            width: 100%;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(148,163,184,0.24);
            color: #e2e8f0;
            font-size: 1rem;
        }
        .form-control:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124,58,237,0.18);
        }
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #7c3aed;
            color: white;
            border: none;
            border-radius: 9999px;
            padding: 12px 22px;
            cursor: pointer;
            font-weight: 600;
            transition: transform .15s ease, background .15s ease;
        }
        .button:hover {
            transform: translateY(-1px);
            background: #6d28d9;
        }
        .alert {
            border-radius: 16px;
            border: 1px solid rgba(34,197,94,0.35);
            background: rgba(22,163,74,0.08);
            color: #d1fae5;
            padding: 16px 18px;
            margin-bottom: 22px;
        }
        .grid-2 {
            display: grid;
            gap: 24px;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="top-nav">
            <div>
                <a href="{{ url('/') }}">Return to Shop</a>
            </div>
            <div>
                <a href="{{ route('admin.settings') }}">Admin Settings</a>
            </div>
        </div>

        @yield('content')
    </div>
</body>
</html>
