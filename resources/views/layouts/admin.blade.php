<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F5EBDD] font-sans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title.' | Admin Portal' : 'Admin Portal' }} | {{ $siteName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full overflow-hidden bg-[#F5EBDD] font-sans text-[#30271F] antialiased">
    <div class="h-screen overflow-hidden lg:flex">
        <!-- Admin Navigation Sidebar -->
        <x-admin-sidebar />

        <!-- Main Content Area -->
        <div class="min-w-0 flex-1 flex h-screen flex-col overflow-hidden">
            <!-- Glassmorphic Admin Header Bar -->
            <header class="z-30 shrink-0 border-b border-[#CFC1AE] bg-[#FBF7F0]/90 px-4 py-4 shadow-xs backdrop-blur-xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <button class="rounded-xl border border-[#CFC1AE] bg-[#FBF7F0] p-2.5 shadow-xs transition hover:bg-[#E9D9C5] lg:hidden" data-admin-menu-button aria-label="Open sidebar">
                            <svg class="h-5 w-5 text-[#30271F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <div>
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-extrabold uppercase tracking-widest text-[#A77B4F]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#654A32]"></span>
                                Control Panel
                            </span>
                            <h1 class="font-heading text-xl font-bold tracking-tight text-[#30271F] sm:text-2xl">{{ $title ?? 'Dashboard' }}</h1>
                        </div>
                    </div>


                    <div class="flex items-center gap-3">
                        <a class="btn-ghost text-xs" href="{{ route('home') }}" target="_blank">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            View Website
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn-primary py-2 text-xs">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Alerts Banner -->
            <div class="shrink-0">
                <x-alert />
            </div>

            <!-- Dynamic Admin Content View -->
            <main class="flex-1 overflow-y-auto px-4 py-8 sm:px-6 lg:px-8">
                <div class="max-w-7xl w-full mx-auto">
                {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>