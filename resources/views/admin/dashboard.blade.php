<x-layouts.admin :title="'Dashboard'">
    <!-- Command Center Hero Banner -->
    <section class="mb-8 overflow-hidden rounded-3xl bg-slate-950 p-6 text-white shadow-xl sm:p-8 relative">
        <div class="relative z-10 flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-teal-500/20 px-3.5 py-1.5 text-xs font-black uppercase tracking-widest text-teal-300 backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-teal-400 animate-pulse"></span>
                    Live Overview
                </span>
                <h2 class="mt-4 font-heading text-3xl font-extrabold leading-tight text-white sm:text-4xl">Content Command Center</h2>
                <p class="mt-2.5 max-w-2xl text-base text-slate-300">Track publishing metrics, user activity, moderation queues, and editorial performance from one central workspace.</p>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="btn-primary h-12 px-5 text-sm shadow-lg shadow-teal-500/20">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Write New Post
            </a>
        </div>
    </section>

    <!-- Stat Grid with Dynamic SVG Icons -->
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        @foreach($stats as $label => $value)
            @php
                $iconSvg = match($label) {
                    'posts' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
                    'categories' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                    'comments' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
                    'users' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                    default => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'
                };
            @endphp
            <div class="card p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ str_replace('_', ' ', $label) }}</p>
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-teal-50 text-teal-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconSvg }}"/></svg>
                    </div>
                </div>
                <p class="mt-3 font-heading text-3xl font-extrabold text-slate-950">{{ number_format($value) }}</p>
                <div class="mt-4 h-1.5 w-full overflow-hidden rounded-full bg-slate-100">
                    <div class="h-1.5 w-3/4 rounded-full bg-teal-600"></div>
                </div>
            </div>
        @endforeach

    </div>

    <!-- Quick Activity Panels -->
    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <!-- Recent Posts -->
        <section class="card p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h2 class="font-heading text-lg font-bold text-slate-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Recent Articles
                </h2>
                <a href="{{ route('admin.posts.index') }}" class="text-xs font-bold text-teal-700 hover:underline flex items-center gap-1">
                    View All
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($recentPosts as $post)
                    <a class="flex items-center justify-between rounded-xl border border-slate-100 p-3.5 transition hover:border-teal-200 hover:bg-teal-50/50" href="{{ route('admin.posts.edit', $post) }}">
                        <div class="min-w-0 pr-3">
                            <p class="font-bold text-slate-900 line-clamp-1 text-sm">{{ $post->title }}</p>
                            <p class="mt-0.5 text-xs text-slate-400 font-medium">By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="badge shrink-0 {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-800' : 'bg-amber-50 text-amber-800' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </a>
                @empty
                    <x-empty-state title="No recent posts" />
                @endforelse
            </div>
        </section>

        <!-- Recent Comments -->
        <section class="card p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h2 class="font-heading text-lg font-bold text-slate-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    Recent Reader Comments
                </h2>
                <a href="{{ route('admin.comments.index') }}" class="text-xs font-bold text-teal-700 hover:underline flex items-center gap-1">
                    View All
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($recentComments as $comment)
                    <div class="rounded-xl border border-slate-100 p-3.5 bg-slate-50/50">
                        <p class="text-xs font-medium text-slate-700 leading-relaxed italic">"{{ Str::limit($comment->comment, 110) }}"</p>
                        <div class="mt-2 flex items-center justify-between text-[11px] font-bold text-slate-400">
                            <span>{{ $comment->user->name }}</span>
                            <span class="text-teal-700 line-clamp-1 max-w-[180px]">{{ $comment->post->title }}</span>
                        </div>
                    </div>
                @empty
                    <x-empty-state title="No recent comments" />
                @endforelse
            </div>
        </section>

        <!-- Most Viewed Articles -->
        <section class="card p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h2 class="font-heading text-lg font-bold text-slate-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    Top Performing Stories
                </h2>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($mostViewedPosts as $post)
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 p-3.5">
                        <span class="font-bold text-slate-900 text-xs line-clamp-1">{{ $post->title }}</span>
                        <span class="inline-flex items-center gap-1 text-xs font-extrabold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200/50 shrink-0">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ number_format($post->views) }}
                        </span>
                    </div>
                @empty
                    <x-empty-state title="No pageviews recorded yet" />
                @endforelse
            </div>
        </section>

        <!-- New Registered Users -->
        <section class="card p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h2 class="font-heading text-lg font-bold text-slate-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    New Registered Members
                </h2>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-teal-700 hover:underline flex items-center gap-1">
                    Manage All
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($recentUsers as $user)
                    <div class="flex items-center gap-3.5 rounded-xl border border-slate-100 p-3">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-9 w-9 rounded-full object-cover shadow-xs border border-slate-200">
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-bold text-slate-900 text-xs">{{ $user->name }}</p>
                            <p class="truncate text-[11px] text-slate-400 font-medium">{{ $user->email }}</p>
                        </div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                @empty
                    <x-empty-state title="No new members" />
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.admin>