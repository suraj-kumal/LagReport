<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Admin') — {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal:        #0f7b6c;
            --teal-hover:  #0a6358;
            --teal-light:  #e4f5f2;
            --teal-dark:   #042e28;

            --n50:  #f8f7f4;
            --n100: #efefeb;
            --n200: #ddddd8;
            --n300: #c4c4be;
            --n400: #9a9a94;
            --n600: #5a5a55;
            --n800: #2c2c28;
            --n900: #181815;

            --danger:       #c0392b;
            --danger-light: #fdf0ef;
            --success:      #1a7a4a;
            --success-light:#edf7f2;
            --warning:      #b45309;
            --warning-light:#fef9ec;

            --font: 'DM Sans', system-ui, sans-serif;
            --sidebar-w: 220px;
            --header-h: 56px;
            --radius: 8px;
        }

        html { font-size: 15px; }

        body {
            font-family: var(--font);
            background: var(--n50);
            color: var(--n800);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }

        /* ── LAYOUT SHELL ── */
        .admin-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .admin-sidebar {
            width: var(--sidebar-w);
            background: var(--n900);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 50;
        }

        .sidebar-brand {
            height: var(--header-h);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .brand-mark {
            width: 28px;
            height: 28px;
            background: var(--teal);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-mark svg {
            width: 14px;
            height: 14px;
            stroke: #fff;
            stroke-width: 2.5;
            stroke-linecap: round;
            fill: none;
        }

        .brand-name {
            font-size: 0.9rem;
            font-weight: 500;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-label {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 0.75rem 0.5rem 0.35rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.55rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            color: rgba(255,255,255,0.55);
            transition: all 0.15s;
        }

        .nav-link svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.07);
            color: #fff;
        }

        .nav-link.active {
            background: var(--teal);
            color: #fff;
        }

        .sidebar-footer {
            padding: 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .logout-form { margin: 0; }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.55rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-family: var(--font);
            color: rgba(255,255,255,0.45);
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
            text-align: left;
        }

        .logout-btn svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            flex-shrink: 0;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.07);
            color: #fff;
        }

        /* ── MAIN CONTENT ── */
        .admin-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-topbar {
            height: var(--header-h);
            background: #fff;
            border-bottom: 1px solid var(--n200);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .page-title {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--n800);
        }

        .admin-body {
            padding: 2rem;
            flex: 1;
        }

        /* ── FLASH MESSAGES ── */
        .flash {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        .flash svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            fill: none;
            flex-shrink: 0;
        }

        .flash-success {
            background: var(--success-light);
            color: var(--success);
            border: 1px solid #a7d9bc;
        }

        .flash-error {
            background: var(--danger-light);
            color: var(--danger);
            border: 1px solid #f0b8b3;
        }

        /* ── SHARED COMPONENTS ── */
        .card {
            background: #fff;
            border: 1px solid var(--n200);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--n100);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .card-title {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--n800);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.84rem;
            font-weight: 500;
            font-family: var(--font);
            cursor: pointer;
            transition: all 0.15s;
            border: 1px solid transparent;
            text-decoration: none;
            line-height: 1.4;
        }

        .btn svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .btn-primary {
            background: var(--teal);
            color: #fff;
            border-color: var(--teal);
        }

        .btn-primary:hover { background: var(--teal-hover); border-color: var(--teal-hover); }

        .btn-ghost {
            background: transparent;
            color: var(--n600);
            border-color: var(--n200);
        }

        .btn-ghost:hover { background: var(--n100); color: var(--n800); }

        .btn-danger {
            background: transparent;
            color: var(--danger);
            border-color: #f0b8b3;
        }

        .btn-danger:hover { background: var(--danger-light); }

        .btn-sm {
            padding: 0.3rem 0.7rem;
            font-size: 0.78rem;
        }

        /* ── FORM ELEMENTS ── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--n600);
            margin-bottom: 0.4rem;
        }

        .form-label .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 0.55rem 0.75rem;
            border: 1px solid var(--n200);
            border-radius: 6px;
            font-size: 0.875rem;
            font-family: var(--font);
            color: var(--n800);
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(15,123,108,0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 90px;
            line-height: 1.6;
        }

        .form-hint {
            font-size: 0.78rem;
            color: var(--n400);
            margin-top: 0.3rem;
        }

        .form-error {
            font-size: 0.78rem;
            color: var(--danger);
            margin-top: 0.3rem;
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .form-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--teal);
            cursor: pointer;
        }

        .form-checkbox span {
            font-size: 0.875rem;
            color: var(--n800);
        }

        .form-section {
            border: 1px solid var(--n200);
            border-radius: var(--radius);
            padding: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .form-section-title {
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--n400);
            margin-bottom: 1rem;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-top: 1rem;
            border-top: 1px solid var(--n100);
            margin-top: 1.5rem;
        }

        /* ── VALIDATION ERRORS ── */
        .error-list {
            background: var(--danger-light);
            border: 1px solid #f0b8b3;
            border-radius: var(--radius);
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
        }

        .error-list ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .error-list li {
            font-size: 0.84rem;
            color: var(--danger);
        }

        /* ── TABLE ── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .data-table th {
            text-align: left;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--n400);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--n200);
            white-space: nowrap;
        }

        .data-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--n100);
            color: var(--n800);
            vertical-align: middle;
        }

        .data-table tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover td { background: var(--n50); }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 500;
        }

        .badge-success { background: var(--success-light); color: var(--success); }
        .badge-neutral { background: var(--n100); color: var(--n400); }
        .badge-teal    { background: var(--teal-light); color: var(--teal); }

        .table-actions {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* ── MOBILE RESPONSIVE ── */
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.4rem;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
        }

        .hamburger-btn svg {
            width: 20px;
            height: 20px;
            stroke: var(--n800);
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .mobile-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 40;
        }

        .mobile-backdrop.open {
            display: block;
        }

        @media (max-width: 767px) {
            html { font-size: 14px; }

            .hamburger-btn {
                display: flex;
            }

            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-content {
                margin-left: 0;
            }

            .admin-topbar {
                padding: 0 1rem;
            }

            .admin-body {
                padding: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 1rem 1.25rem;
            }

            .card-header .btn {
                width: 100%;
                justify-content: center;
                margin-top: 0.75rem;
            }

            .table-actions {
                flex-wrap: wrap;
                gap: 0.25rem;
            }

            .table-actions .btn {
                flex: 1;
                min-width: 70px;
                padding: 0.3rem 0.5rem;
                font-size: 0.72rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="admin-shell">

    {{-- ── Sidebar ── --}}
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <div class="brand-mark">
                <svg viewBox="0 0 24 24"><path d="M12 2v20M2 12h20"/></svg>
            </div>
            <span class="brand-name">{{ config('app.name') }}</span>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-label">Content</span>
            <a href="{{ route('admin.news.index') }}"
               class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h10"/></svg>
                News Articles
            </a>
            <a href="{{ route('admin.media.index') }}"
               class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                Media
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main ── --}}
    <div class="admin-content">
        <div class="admin-topbar">
            <button type="button" class="hamburger-btn" id="hamburger-toggle" aria-label="Toggle menu">
                <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <span class="page-title">@yield('page_title', 'Dashboard')</span>
        </div>

        <main class="admin-body">
            @if(session('success'))
                <div class="flash flash-success">
                    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="flash flash-error">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>

{{-- Mobile menu backdrop --}}
<div class="mobile-backdrop" id="mobile-backdrop"></div>

<script>
    const hamburgerBtn = document.getElementById('hamburger-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    const backdrop = document.getElementById('mobile-backdrop');

    function toggleMobileMenu() {
        sidebar.classList.toggle('open');
        backdrop.classList.toggle('open');
    }

    function closeMobileMenu() {
        sidebar.classList.remove('open');
        backdrop.classList.remove('open');
    }

    hamburgerBtn.addEventListener('click', toggleMobileMenu);
    backdrop.addEventListener('click', closeMobileMenu);

    // Close menu when clicking on a nav link
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });
</script>

@stack('scripts')
</body>
</html>
