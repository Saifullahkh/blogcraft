@php
    use Illuminate\Support\Str;

    $pageTitle = isset($title) ? $title.' | '.$siteName : $siteName;
    $pageDescription = $metaDescription ?? ($siteSettings['website_description'] ?? 'A modern editorial blog for sharp ideas, stories, and practical guides.');
    $assetUrl = function (?string $path, ?string $fallback = null): ?string {
        $path = str_replace('\\', '/', trim((string) ($path ?: $fallback)));

        if ($path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, ['/storage/', 'storage/'])) {
            return asset(ltrim($path, '/'));
        }

        if (Str::startsWith($path, 'public/')) {
            $path = Str::after($path, 'public/');
        }

        return asset('storage/'.ltrim($path, '/'));
    };

    $faviconUrl = $assetUrl($siteSettings['favicon'] ?? null);
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @isset($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endisset
    @if($faviconUrl)<link rel="icon" href="{{ $faviconUrl }}">@endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-shell bg-[#F5EBDD] text-[#30271F] antialiased selection:bg-[#654A32] selection:text-[#FBF7F0]">
    <!-- Main Header Bar -->
    <header class="sticky top-0 z-50 border-b border-[#CFC1AE] bg-[#FBF7F0]/90 shadow-xs shadow-[#30271F]/5 backdrop-blur-xl transition-all duration-300">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3.5 sm:px-6 lg:px-8">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="group flex items-center gap-3 font-extrabold text-[#30271F] transition" aria-label="{{ $siteName }}">
                <img src="{{ asset('storage/logo1.png') }}" alt="{{ $siteName }}" class="h-10 w-10 rounded-xl object-contain transition duration-200 group-hover:scale-105">
            </a>

            <!-- Navigation Links -->
            <nav class="hidden items-center gap-1 rounded-2xl border border-[#CFC1AE] bg-[#E9D9C5]/60 p-1.5 text-sm font-bold text-[#74685B] backdrop-blur-md lg:flex">
                <a class="nav-link {{ request()->routeIs('home') ? 'bg-[#FBF7F0] text-[#30271F] shadow-xs' : '' }}" href="{{ route('home') }}">Home</a>
                <a class="nav-link {{ request()->routeIs('blog.*') ? 'bg-[#FBF7F0] text-[#30271F] shadow-xs' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                <a class="nav-link {{ request()->routeIs('about') ? 'bg-[#FBF7F0] text-[#30271F] shadow-xs' : '' }}" href="{{ route('about') }}">About</a>
                <a class="nav-link {{ request()->routeIs('contact.*') ? 'bg-[#FBF7F0] text-[#30271F] shadow-xs' : '' }}" href="{{ route('contact.create') }}">Contact</a>
            </nav>


            <!-- Header Right Section -->
            <div class="hidden items-center gap-3 lg:flex">
                <!-- Search Form -->
                <form action="{{ route('search') }}" class="relative group">
                    <input name="q" value="{{ request('q') }}" placeholder="Search articles..." class="h-10 w-56 rounded-xl border border-slate-200 bg-slate-50/90 pl-4 pr-10 text-sm font-medium outline-none shadow-xs transition-all duration-300 placeholder:text-slate-400 focus:w-64 focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/15">
                    <button class="absolute right-2.5 top-1/2 -translate-y-1/2 rounded-lg p-1 text-slate-400 transition hover:text-teal-600" aria-label="Search">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>

                <!-- Auth Buttons / User Dropdown -->
                @auth
                    <div class="relative" data-dropdown>
                        <button type="button" class="flex items-center gap-2.5 rounded-xl border border-slate-200/90 bg-white px-3 py-1.5 text-sm font-bold text-slate-800 shadow-xs transition duration-200 hover:border-slate-300 hover:bg-slate-50" data-dropdown-button aria-expanded="false">
                            <span class="relative">
                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full object-cover ring-2 ring-teal-500/30">
                                <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                            </span>
                            <span class="max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 hidden w-60 rounded-2xl border border-slate-200/90 bg-white p-2 shadow-2xl backdrop-blur-xl">
                            <div class="border-b border-slate-100 px-3 py-2">
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Signed in as</p>
                                <p class="truncate text-sm font-bold text-slate-900">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="mt-1 space-y-0.5">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>My Profile</span>
                                </a>
                                <a class="dropdown-item" href="{{ route('profile.comments') }}">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    <span>My Comments</span>
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a class="dropdown-item bg-teal-50/80 text-teal-800" href="{{ route('admin.dashboard') }}">
                                        <svg class="h-4 w-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                        <span>Admin Dashboard</span>
                                    </a>
                                @endif
                            </div>
                            <div class="mt-1 border-t border-slate-100 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item w-full text-left text-rose-600 hover:bg-rose-50 hover:text-rose-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a class="btn-ghost" href="{{ route('login') }}">Login</a>
                    <a class="btn-primary" href="{{ route('register') }}">Get Started</a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button type="button" class="group relative grid h-11 w-11 place-items-center rounded-2xl border border-[#CFC1AE] bg-[#FBF7F0] text-[#30271F] shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-[#654A32] hover:bg-[#E9D9C5] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-[#A77B4F]/20 active:translate-y-0 lg:hidden" data-mobile-button aria-label="Open menu" aria-expanded="false" aria-controls="mobile-navigation">
                <span class="sr-only" data-mobile-label>Open menu</span>
                <span class="absolute inset-1 rounded-xl bg-[#E9D9C5]/60 opacity-0 transition-opacity duration-200 group-hover:opacity-100"></span>
                <svg class="relative h-5 w-5 transition duration-200" data-mobile-icon-open fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg class="relative hidden h-5 w-5 transition duration-200" data-mobile-icon-close fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div id="mobile-navigation" class="hidden border-t border-[#CFC1AE] bg-[#FBF7F0]/98 px-5 py-6 shadow-2xl lg:hidden" data-mobile-menu>
            <form action="{{ route('search') }}" class="mb-5">
                <div class="relative">
                    <input name="q" value="{{ request('q') }}" placeholder="Search articles..." class="input pr-10">
                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-teal-600" aria-label="Search">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>
            <div class="grid gap-2 text-base font-bold text-slate-800">
                <a href="{{ route('home') }}" class="rounded-xl px-4 py-2.5 hover:bg-teal-50 hover:text-teal-700">Home</a>
                <a href="{{ route('blog.index') }}" class="rounded-xl px-4 py-2.5 hover:bg-teal-50 hover:text-teal-700">Blog</a>
                <a href="{{ route('about') }}" class="rounded-xl px-4 py-2.5 hover:bg-teal-50 hover:text-teal-700">About</a>
                <a href="{{ route('contact.create') }}" class="rounded-xl px-4 py-2.5 hover:bg-teal-50 hover:text-teal-700">Contact</a>
                <hr class="my-2 border-slate-100">
                @auth
                    <a href="{{ route('profile.edit') }}" class="rounded-xl px-4 py-2.5 hover:bg-teal-50 hover:text-teal-700">My Profile</a>
                    <a href="{{ route('profile.comments') }}" class="rounded-xl px-4 py-2.5 hover:bg-teal-50 hover:text-teal-700">My Comments</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="rounded-xl bg-teal-50 px-4 py-2.5 text-teal-800">Admin Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button class="w-full rounded-xl bg-rose-50 px-4 py-2.5 text-left font-bold text-rose-700">Logout</button>
                    </form>
                @else
                    <div class="grid gap-2 pt-2">
                        <a href="{{ route('login') }}" class="btn-ghost w-full justify-center">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary w-full justify-center">Get Started</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <x-alert />
    <main class="flex-1">{{ $slot }}</main>
    <x-footer />
</body>
</html>

