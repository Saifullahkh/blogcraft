<x-layouts.app :title="'Home'" :meta-description="$siteSettings['website_description'] ?? 'Discover thoughtful articles and practical guides.'">
    @php
    $heroPost = $featuredPosts->first() ?? $latestPosts->first();
    $heroImage = $heroPost?->featured_image_url ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1600&q=80';
@endphp

    <!-- Editorial Hero Canvas -->
    <section class="editorial-hero relative isolate overflow-hidden bg-[#30271F]">
        <img src="{{ $heroImage }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-25" aria-hidden="true">
        <div class="absolute inset-0 bg-[#30271F]/82"></div>
        <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-[#30271F] to-transparent"></div>

        <div class="relative z-10 mx-auto grid min-h-[500px] max-w-7xl items-end gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[minmax(0,1fr)_28rem] lg:px-8 lg:py-20">
            <div class="max-w-3xl text-[#FBF7F0]">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#A77B4F]/45 bg-[#FBF7F0]/10 px-3.5 py-1.5 text-xs font-extrabold uppercase tracking-widest text-[#E9D9C5] backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-[#A77B4F] animate-pulse"></span>
                    Modern Ideas &bull; Carefully Curated
                </span>

                <h1 class="mt-6 max-w-4xl font-heading text-4xl font-extrabold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                    Read sharper stories for work, craft & curiosity.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-[#E9D9C5]">
                    {{ $siteSettings['website_description'] ?? 'A professional blog platform with curated articles, practical insights, and community discussion.' }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('blog.index') }}" class="btn-primary">Browse All Posts</a>
                    <a href="{{ route('about') }}" class="inline-flex items-center justify-center rounded-xl border border-[#CFC1AE]/45 bg-[#FBF7F0]/10 px-5 py-2.5 text-sm font-bold text-[#FBF7F0] backdrop-blur-md transition hover:bg-[#FBF7F0]/20">About Us</a>
                </div>
            </div>

            <div class="self-end">
                <div class="group block overflow-hidden rounded-2xl border border-[#CFC1AE]/70 bg-[#FBF7F0] text-[#30271F] shadow-2xl shadow-[#30271F]/30 transition-all duration-300 hover:-translate-y-2 hover:shadow-[#30271F]/40">
                    <div class="relative aspect-[4/3] overflow-hidden bg-[#E9D9C5]">
                        <img src="{{ $heroImage }}" alt="{{ $heroPost?->title ?? $siteName }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#30271F]/80 to-transparent p-5 text-[#FBF7F0]">
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-[#FBF7F0]/30 bg-[#FBF7F0]/15 px-3 py-1 text-xs font-bold backdrop-blur-md">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#A77B4F]"></span>
                                Featured Story
                            </span>
                        </div>
                    </div>
                </div>''
            </div>
        </div>
    </section>
    <!-- Editor's Picks Section -->
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="mb-12 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <span class="section-kicker">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Featured Articles
                </span>
                <h2 class="section-heading">Editor's Choice</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="btn-ghost">View All Articles &rarr;</a>
        </div>
        @if($featuredPosts->isNotEmpty())
            <div class="grid gap-8 md:grid-cols-3">
                @foreach($featuredPosts as $post)
                    <x-blog-card :post="$post" />
                @endforeach
            </div>
        @else
            <x-empty-state title="No featured posts yet" message="Publish and feature posts from the admin dashboard." />
        @endif
    </section>

    <!-- Latest Articles Banner Section -->
    <section class="border-y border-[#CFC1AE] bg-[#E9D9C5]/40 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 max-w-2xl">
                <span class="section-kicker">Latest Articles</span>
                <h2 class="section-heading">Fresh From The Publication</h2>
                <p class="mt-4 text-base leading-relaxed text-[#74685B]">Newly published stories with crisp summaries, author context, and quick reading time.</p>
            </div>
            @if($latestPosts->isNotEmpty())
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($latestPosts as $post)
                        <x-blog-card :post="$post" />
                    @endforeach
                </div>
            @else
                <x-empty-state title="No posts published" message="Published articles will show here." />
            @endif
        </div>
    </section>

    <!-- Categories & Popular Posts Grid -->
    <section class="mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-[1fr_22rem] lg:px-8">
        <div>
            <div class="mb-8">
                <span class="section-kicker">Explore Topics</span>
                <h2 class="section-heading">Popular Categories</h2>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                @forelse($categories as $category)
                    <x-category-card :category="$category" />
                @empty
                    <x-empty-state title="No categories" />
                @endforelse
            </div>
        </div>

        <!-- Trending Sidebar -->
        <div>
            <div class="mb-8">
                <span class="section-kicker">Trending</span>
                <h2 class="section-heading">Most Viewed</h2>
            </div>
            <div class="grid gap-4">
                @forelse($popularPosts as $index => $post)
                    <a href="{{ route('blog.show', $post) }}" class="card group flex items-center gap-4 p-4 transition duration-300 hover:-translate-y-1">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E9D9C5] font-heading text-lg font-black text-[#654A32]">
                            0{{ $index + 1 }}
                        </span>
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="h-16 w-20 shrink-0 rounded-xl object-cover">
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] font-extrabold uppercase tracking-wider text-[#A77B4F]">{{ number_format($post->views) }} views</p>
                            <h3 class="mt-1 line-clamp-2 font-heading text-sm font-bold leading-snug text-[#30271F] group-hover:text-[#654A32]">{{ $post->title }}</h3>
                            <p class="mt-1 text-xs text-[#74685B] font-medium">{{ $post->reading_time }} min read</p>
                        </div>
                    </a>
                @empty
                    <x-empty-state title="No trending posts" />
                @endforelse
            </div>
        </div>
    </section>

    <!-- Newsletter CTA Banner -->
    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-[#3C2C20] p-8 text-[#FBF7F0] shadow-2xl shadow-[#30271F]/30 lg:grid lg:grid-cols-12 lg:gap-8 lg:p-14">
            <div class="lg:col-span-7">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#A77B4F]/40 bg-[#A77B4F]/15 px-3.5 py-1.5 text-xs font-extrabold uppercase tracking-widest text-[#CFC1AE]">
                    Weekly Dispatch
                </span>
                <h2 class="mt-4 font-heading text-3xl font-extrabold leading-tight sm:text-4xl lg:text-5xl">
                    Get the best stories delivered directly to your inbox.
                </h2>
                <p class="mt-4 max-w-xl text-base leading-relaxed text-[#E9D9C5]">
                    Join our reader community. Receive one concise email every week with curated articles, zero clutter.
                </p>
            </div>

            <form method="POST" action="{{ route('newsletter.store') }}" class="mt-8 flex flex-col justify-center gap-3 lg:col-span-5 lg:mt-0">
                @csrf
                <input name="email" type="email" required class="h-13 w-full rounded-xl border border-[#CFC1AE] bg-[#FBF7F0] px-4 text-[#30271F] placeholder:text-[#74685B] outline-none focus:ring-4 focus:ring-[#A77B4F]/30" placeholder="Enter your email address...">
                <button class="btn-primary h-13 rounded-xl text-base font-bold">Subscribe Free</button>
            </form>
        </div>
    </section>
</x-layouts.app>
