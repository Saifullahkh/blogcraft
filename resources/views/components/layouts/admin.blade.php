<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title.' | Admin' : 'Admin' }} | {{ $siteName }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full overflow-hidden bg-slate-100 text-slate-950 antialiased">
    <div class="h-screen overflow-hidden lg:flex">
        <x-admin-sidebar />
        <div class="flex h-screen min-w-0 flex-1 flex-col overflow-hidden">
            <header class="shrink-0 border-b border-white/70 bg-white/85 px-4 py-3 shadow-sm shadow-slate-900/5 backdrop-blur-xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <button class="rounded-lg border border-slate-200 bg-white p-2 shadow-sm lg:hidden" data-admin-menu-button aria-label="Open sidebar">☰</button>
                    <div>
                        <p class="section-kicker">Administration</p>
                        <h1 class="text-xl font-bold text-slate-950">{{ $title ?? 'Dashboard' }}</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <a class="btn-ghost" href="{{ route('home') }}">View Site</a>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn-primary">Logout</button></form>
                    </div>
                </div>
            </header>
            <div class="shrink-0">
                <x-alert />
            </div>
            <main class="flex-1 overflow-y-auto px-4 py-6 sm:px-6 lg:px-8">{{ $slot }}</main>
        </div>
    </div>
</body>
</html>