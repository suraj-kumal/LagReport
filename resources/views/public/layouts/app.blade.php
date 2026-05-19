<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO meta tags --}}
    <title>@yield('seo_title', config('app.name'))</title>
    <meta name="description" content="@yield('seo_description', '')">
    <meta name="keywords"    content="@yield('seo_keywords', '')">

    {{-- Open Graph --}}
    <meta property="og:title"       content="@yield('seo_title', config('app.name'))">
    <meta property="og:description" content="@yield('seo_description', '')">
    <meta property="og:image"       content="@yield('og_image', '')">
    <meta property="og:type"        content="article">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif'],
                        mono: ['IBM Plex Mono', 'Courier New', 'monospace'],
                    },
                    colors: {
                        swiss: {
                            blue: '#0057FF',
                            'blue-dark': '#0040CC',
                            black: '#0A0A0A',
                            gray: '#6B6B6B',
                            'gray-light': '#D4D4D4',
                            'gray-pale': '#F2F2F2',
                            white: '#FFFFFF',
                        }
                    },
                    fontSize: {
                        '2xs': ['0.65rem', { lineHeight: '1rem', letterSpacing: '0.1em' }],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; }
        body { -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }
        img { display: block; max-width: 100%; height: auto; }

        /* Swiss grid rule lines */
        .rule { display: block; width: 100%; height: 1px; background: #0A0A0A; }
        .rule-blue { background: #0057FF; }
        .rule-light { background: #D4D4D4; }

        /* Tracking utility */
        .tracking-swiss { letter-spacing: 0.12em; }
        .tracking-tight-swiss { letter-spacing: -0.03em; }

        /* Swiss hover — underline from left */
        .swiss-link {
            position: relative;
            display: inline-block;
        }
        .swiss-link::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 0;
            height: 1px;
            background: #0057FF;
            transition: width 0.2s ease;
        }
        .swiss-link:hover::after { width: 100%; }
        .swiss-link:hover { color: #0057FF; }

        /* Blue accent bar on cards */
        .card-accent::before {
            content: '';
            display: block;
            width: 100%;
            height: 3px;
            background: #0057FF;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-white text-swiss-black font-sans">

    {{-- ── TOP RULE ── --}}
    <span class="rule rule-blue" style="height:3px;"></span>

    {{-- ── HEADER ── --}}
    <header class="border-b border-swiss-black sticky top-0 z-50 bg-white">
        <div class="max-w-screen-xl mx-auto px-6">

            {{-- Top bar: site name + label --}}
            <div class="flex items-center justify-between h-14 border-b border-swiss-gray-light">
                <a href="{{ route('news.index') }}" class="flex items-center gap-3">
                    {{-- Swiss grid mark --}}
                    <div class="w-7 h-7 bg-swiss-blue flex items-center justify-content-center flex-shrink-0" style="display:flex;align-items:center;justify-content:center;">
                        <span class="block w-3 h-3 bg-white"></span>
                    </div>
                    <span class="text-swiss-black font-sans font-bold text-xl tracking-tight-swiss uppercase">
                        {{ config('app.name') }}
                    </span>
                </a>
                <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray border border-swiss-gray-light px-2 py-1">
                    Tech Journal
                </span>
            </div>

            {{-- Nav row: category labels --}}
            <div class="flex items-center gap-6 h-10">
                <a href="{{ route('news.index') }}" class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray hover:text-swiss-blue transition-colors duration-150">Home</a>
                <span class="rule-light" style="width:1px;height:16px;background:#D4D4D4;display:inline-block;"></span>
                <a href="{{ route('news.index') }}" class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray hover:text-swiss-blue transition-colors duration-150">Latest</a>
            </div>
        </div>
    </header>

    {{-- ── MAIN ── --}}
    <main class="max-w-screen-xl mx-auto px-6 py-10 min-h-screen">
        @yield('content')
    </main>

    {{-- ── FOOTER ── --}}
    <span class="rule"></span>
    <footer class="bg-swiss-black text-white">
        <div class="max-w-screen-xl mx-auto px-6 py-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-5 h-5 bg-swiss-blue flex items-center justify-content-center" style="display:flex;align-items:center;justify-content:center;">
                    <span class="block w-2 h-2 bg-white"></span>
                </div>
                <span class="font-bold text-sm uppercase tracking-tight-swiss">{{ config('app.name') }}</span>
            </div>
            <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">
                &copy; {{ date('Y') }} — All rights reserved
            </span>
        </div>
    </footer>

</body>
</html>
