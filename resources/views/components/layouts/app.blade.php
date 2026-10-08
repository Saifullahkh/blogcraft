@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $pageTitle = isset($title) ? $title.' | '.$siteName : $siteName;
    $pageDescription = $metaDescription ?? ($siteSettings['website_description'] ?? 'A modern editorial blog for sharp ideas, stories, and practical guides.');
    $logo = $siteSettings['logo'] ?? null;
    $logoUrl = $logo ? (Str::startsWith($logo, 'http') ? $logo : Storage::disk('public')->url($logo)) : null;
    $favicon = $siteSettings['favicon'] ?? null;
    $faviconUrl = $favicon ? (Str::startsWith($favicon, 'http') ? $favicon : Storage::disk('public')->url($favicon)) : null;
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @isset($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endisset
    @if($faviconUrl)<link rel="icon" href="{{ $faviconUrl }}">@endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-shell text-slate-950 antialiased">
    <header class="sticky top-0 z-40 border-b border-white/70 bg-white/80 shadow-sm shadow-slate-900/5 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center ">
               <img src="{{ asset('storage/logo1.png') }}" alt="{{ $siteName }}" class="h-16 w-50">
            </a>
            <nav class="hidden items-center gap-1 rounded-lg p-1 text-xl font-semibold text-slate-600 lg:flex">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
                <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                <a class="nav-link" href="{{ route('about') }}">About</a>
                <a class="nav-link" href="{{ route('contact.create') }}">Contact</a>
            </nav>
            <div class="hidden items-center gap-4 lg:flex">
            @auth
                <div class="relative" data-dropdown>
                    <button type="button" 
                            class="group inline-flex items-center gap-3 rounded-full bg-white p-1.5 pr-4 text-sm font-medium text-slate-700 shadow-sm transition-all duration-200 hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/20" 
                            data-dropdown-button>
                        <img src="{{ auth()->user()->avatar_url }}" 
                            alt="{{ auth()->user()->name }}" 
                            class="h-8 w-8 rounded-full object-cover ring-2 ring-slate-100 transition-all group-hover:ring-slate-200">
                        <span>{{ Str::limit(auth()->user()->name, 16) }}</span>
                        <!-- Optional Dropdown Chevron Icon -->
                        <svg class="h-4 w-4 text-slate-400 transition-transform duration-200 group-hover:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="dropdown-menu absolute right-0 mt-2 hidden w-60 transform overflow-hidden rounded-xl bg-white p-1.5  transition-all">
                        <div class="px-3 py-2 border-b border-slate-100 mb-1">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Account</p>
                            <p class="text-xs font-medium text-slate-600 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <a class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900" 
                        href="{{ route('profile.edit') }}">
                            My Profile
                        </a>
                        
                        <a class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900" 
                        href="{{ route('profile.comments') }}">
                            My Comments
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-indigo-600 transition hover:bg-indigo-50" 
                            href="{{ route('admin.dashboard') }}">
                                Admin Dashboard
                            </a>
                        @endif

                        <div class="my-1 border-t border-slate-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-red-600 transition hover:bg-red-50">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a class="btn-ghost" 
                href="{{ route('login') }}">
                    Login
                </a>
                <a class="btn-primary " 
                href="{{ route('register') }}">
                    Register
                </a>
            @endauth
        </div>
            <button type="button" class="group relative grid h-11 w-11 place-items-center rounded-2xl border border-slate-200 bg-white text-slate-800 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-teal-500/15 active:translate-y-0 lg:hidden" data-mobile-button aria-label="Open menu" aria-expanded="false" aria-controls="mobile-navigation">
                <span class="sr-only" data-mobile-label>Open menu</span>
                <span class="absolute inset-1 rounded-xl bg-slate-100 opacity-0 transition-opacity duration-200 group-hover:opacity-100"></span>
                <svg class="relative h-5 w-5 transition duration-200" data-mobile-icon-open fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg class="relative hidden h-5 w-5 transition duration-200" data-mobile-icon-close fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>
        <div id="mobile-navigation" class="hidden border-t border-slate-200 bg-white/95 px-4 py-4 shadow-lg lg:hidden" data-mobile-menu>
            <form action="{{ route('search') }}" class="mb-4">
                <input name="q" value="{{ request('q') }}" placeholder="Search articles" class="input">
            </form>
            <div class="grid gap-2 text-sm font-semibold">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('blog.index') }}">Blog</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('contact.create') }}">Contact</a>
                @auth
                    <a href="{{ route('profile.edit') }}">My Profile</a>
                    @if(auth()->user()->isAdmin())<a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>@endif
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-left font-semibold">Logout</button></form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </header>
    <main>{{ $slot }}</main>
    <div class="fixed bottom-4 right-4 z-50 flex flex-col items-end gap-3 sm:bottom-6 sm:right-6" data-chatbot>
        <section id="ai-chatbot-panel" class="hidden w-[calc(100vw-2rem)] max-w-sm overflow-hidden rounded-2xl border border-[#CFC1AE] bg-[#FBF7F0] shadow-2xl shadow-[#30271F]/20" data-chatbot-panel aria-label="AI chatbot">
            <div class="flex items-center justify-between gap-3 border-b border-[#CFC1AE] bg-[#654A32] px-4 py-3 text-[#FBF7F0]">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-[#FBF7F0]/15">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5M7 19l-3 2V6a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H9l-2 2z" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-bold leading-tight">AI Blog Assistant</p>
                        <p class="text-xs text-[#F1E4D3]">Ask about posts, topics, or contact.</p>
                    </div>
                </div>
                <button type="button" class="grid h-9 w-9 place-items-center rounded-full text-[#FBF7F0] transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/40" data-chatbot-close aria-label="Close chat">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>

            <div class="max-h-[22rem] min-h-72 space-y-3 overflow-y-auto bg-white/60 px-4 py-4" data-chatbot-messages>
                <div class="max-w-[85%] rounded-2xl rounded-bl-sm bg-[#F1E4D3] px-4 py-3 text-sm leading-6 text-[#30271F]">
                    Hi! Main aapka AI assistant hun. Aap blog posts, categories, ya website info ke bare me pooch sakte hain.
                </div>
            </div>

            <div class="border-t border-[#CFC1AE] bg-[#FBF7F0] px-4 py-3">
                <div class="mb-3 flex flex-wrap gap-2">
                    <button type="button" class="rounded-full border border-[#CFC1AE] px-3 py-1.5 text-xs font-semibold text-[#654A32] transition hover:border-[#654A32] hover:bg-[#E9D9C5]" data-chatbot-suggestion="Latest posts dikhao">Latest posts</button>
                    <button type="button" class="rounded-full border border-[#CFC1AE] px-3 py-1.5 text-xs font-semibold text-[#654A32] transition hover:border-[#654A32] hover:bg-[#E9D9C5]" data-chatbot-suggestion="Mujhe blog topics suggest karo">Topic ideas</button>
                </div>
                <form class="flex items-end gap-2" data-chatbot-form data-chatbot-endpoint="{{ route('chatbot.message') }}">
                    <label class="sr-only" for="chatbot-message">Message</label>
                    <textarea id="chatbot-message" rows="1" class="input max-h-28 resize-none py-3" placeholder="Type your question..." data-chatbot-input></textarea>
                    <button type="submit" class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-[#654A32] text-[#FBF7F0] shadow-md shadow-[#654A32]/20 transition hover:bg-[#3C2C20] focus:outline-none focus:ring-4 focus:ring-[#A77B4F]/30" data-chatbot-submit aria-label="Send message">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </button>
                </form>
            </div>
        </section>

        <button type="button" class="group grid h-14 w-14 place-items-center rounded-full bg-[#654A32] text-[#FBF7F0] shadow-xl shadow-[#30271F]/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#3C2C20] focus:outline-none focus:ring-4 focus:ring-[#A77B4F]/30" data-chatbot-toggle aria-label="Open AI chat" aria-expanded="false" aria-controls="ai-chatbot-panel">
            <svg class="h-6 w-6 transition" data-chatbot-icon-open fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5M7 19l-3 2V6a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H9l-2 2z" />
            </svg>
            <svg class="hidden h-6 w-6 transition" data-chatbot-icon-close fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>
    </div>
    <x-footer />
</body>
</html>
