<aside class="fixed inset-y-0 left-0 z-40 hidden w-72 overflow-y-auto bg-[#3C2C20] p-5 text-[#FBF7F0] shadow-2xl lg:static lg:block lg:h-screen lg:shrink-0" data-admin-sidebar>
    <a href="{{ route('admin.dashboard') }}" class="mb-3 flex items-center ">
        <img src="{{ asset('storage/logo.png') }}" alt="">
    </a>

    <nav class="space-y-1 text-xs font-bold uppercase tracking-wider">
        <p class="px-3 pb-2 text-[10px] text-[#CFC1AE]">Main Menu</p>
        @foreach([
            'admin.dashboard' => ['Dashboard', route('admin.dashboard'), 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            'admin.posts.index' => ['Posts', route('admin.posts.index'), 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
            'admin.categories.index' => ['Categories', route('admin.categories.index'), 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
            'admin.tags.index' => ['Tags', route('admin.tags.index'), 'M7 20l4-16m2 16l4-16M6 9h14M4 15h14'],
            'admin.comments.index' => ['Comments', route('admin.comments.index'), 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
            'admin.users.index' => ['Users', route('admin.users.index'), 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            'admin.contact-messages.index' => ['Contact Messages', route('admin.contact-messages.index'), 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            'admin.media.index' => ['Media', route('admin.media.index'), 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
            'admin.settings.edit' => ['Settings', route('admin.settings.edit'), 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
            'profile.edit' => ['Profile', route('profile.edit'), 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ] as $routeName => [$label, $url, $svgPath])
            @php($active = request()->routeIs($routeName))
            <a href="{{ $url }}" class="flex items-center gap-3 rounded-xl px-3.5 py-3 font-bold transition-all duration-200 {{ $active ? 'bg-[#654A32] text-[#FBF7F0] shadow-lg shadow-[#654A32]/30' : 'text-[#CFC1AE] hover:bg-white/10 hover:text-[#FBF7F0]' }}">

                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $svgPath }}"/></svg>
                <span>{{ $label }}</span>
            </a>
        @endforeach
    </nav>
</aside>