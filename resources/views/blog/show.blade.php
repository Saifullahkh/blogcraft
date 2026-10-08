<x-layouts.app :title="$post->seo_title" :meta-description="$post->seo_description" :og-image="$post->featured_image_url">
    <article class="bg-[#F5EBDD]">
        <!-- Article Header Section -->
        <header class="border-b border-[#CFC1AE] bg-[#FBF7F0] py-14">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs Navigation -->
                <nav class="mb-8 flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#74685B]">
                    <a href="{{ route('home') }}" class="transition hover:text-[#654A32]">Home</a>
                    <span>/</span>
                    <a href="{{ route('blog.index') }}" class="transition hover:text-[#654A32]">Blog</a>
                    @if($post->category)
                        <span>/</span>
                        <a href="{{ route('categories.show', $post->category) }}" class="text-[#654A32] transition hover:underline">{{ $post->category->name }}</a>
                    @endif
                </nav>

                <!-- Article Meta Pill -->
                <div class="flex flex-wrap items-center gap-3 text-xs font-extrabold uppercase tracking-widest text-[#A77B4F]">
                    @if($post->category)
                        <span class="rounded-full bg-[#E9D9C5] px-3 py-1 text-[#654A32]">{{ $post->category->name }}</span>
                    @endif
                    <span>{{ optional($post->published_at)->format('M d, Y') }}</span>
                    <span>•</span>
                    <span>{{ $post->reading_time }} min read</span>
                    <span>•</span>
                    <span>{{ number_format($post->views) }} views</span>
                </div>

                <!-- Article Main Title -->
                <h1 class="mt-4 font-heading text-4xl font-extrabold tracking-tight text-[#30271F] sm:text-5xl lg:text-6xl leading-[1.15]">
                    {{ $post->title }}
                </h1>

                <!-- Lead Excerpt -->
                <p class="mt-6 text-xl leading-relaxed text-[#74685B] font-medium">
                    {{ $post->excerpt }}
                </p>

                <!-- Author Profile Header snippet -->
                <div class="mt-8 flex items-center gap-4 border-t border-[#CFC1AE] pt-6">
                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" class="h-14 w-14 rounded-full object-cover ring-4 ring-[#CFC1AE] shadow-md">
                    <div>
                        <p class="font-heading text-base font-bold text-[#30271F]">{{ $post->user->name }}</p>
                        <p class="text-xs font-medium text-[#74685B]">{{ $post->user->bio ?: 'Editorial Contributor' }}</p>
                    </div>
                </div>
            </div>

            <!-- Featured Image Hero -->
            <div class="mx-auto mt-10 max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-3xl shadow-2xl shadow-[#30271F]/10 border border-[#CFC1AE]">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="h-[420px] w-full object-cover sm:h-[520px]">
                </div>
            </div>
        </header>

        <!-- Main Article Content Layout -->
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[minmax(0,1fr)_20rem] lg:px-8">
            <!-- Reader Left Column -->
            <div class="min-w-0">
                <!-- Article Body -->
                <div class="article-content rounded-3xl border border-[#CFC1AE] bg-[#FBF7F0] p-8 sm:p-12 shadow-xs">
                    {!! $post->content !!}
                </div>

                <!-- Article Tags -->
                @if($post->tags->isNotEmpty())
                    <div class="mt-8 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#74685B]">Tags:</span>
                        @foreach($post->tags as $tag)
                            <a href="{{ route('tags.show', $tag) }}" class="badge bg-[#E9D9C5] text-[#654A32] hover:bg-[#654A32] hover:text-[#FBF7F0] transition-all">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Author Bio Box -->
                <div class="mt-10 grid gap-5 rounded-2xl border border-[#CFC1AE] bg-[#FBF7F0] p-6 shadow-xs sm:grid-cols-[auto_1fr] sm:p-8">
                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" class="h-16 w-16 rounded-2xl object-cover ring-2 ring-[#CFC1AE] shadow-md">
                    <div>
                        <h3 class="font-heading text-lg font-bold text-[#30271F]">Written by {{ $post->user->name }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-[#74685B]">
                            {{ $post->user->bio ?: 'This author shares practical ideas and carefully edited stories for the publication.' }}
                        </p>
                    </div>
                </div>

                <!-- Previous / Next Post Cards -->
                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    @if($previousPost)
                        <a href="{{ route('blog.show', $previousPost) }}" class="card p-5 transition hover:-translate-y-1">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#74685B]">← Previous Article</span>
                            <p class="mt-2 font-heading font-bold text-[#30271F] line-clamp-2">{{ $previousPost->title }}</p>
                        </a>
                    @else
                        <div></div>
                    @endif
                    @if($nextPost)
                        <a href="{{ route('blog.show', $nextPost) }}" class="card p-5 text-right transition hover:-translate-y-1 sm:text-right">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#74685B]">Next Article →</span>
                            <p class="mt-2 font-heading font-bold text-[#30271F] line-clamp-2">{{ $nextPost->title }}</p>
                        </a>
                    @endif
                </div>

                <!-- Comments & Discussion Section -->
                <section class="mt-16 rounded-3xl border border-[#CFC1AE] bg-[#FBF7F0] p-8 sm:p-10 shadow-xs">
                    <div class="flex items-center justify-between border-b border-[#CFC1AE] pb-6">
                        <h2 class="font-heading text-2xl font-bold tracking-tight text-[#30271F]">Discussion & Comments</h2>
                        <span class="rounded-full bg-[#E9D9C5] px-3 py-1 text-xs font-bold text-[#654A32]">{{ $comments->count() }} Comments</span>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-6 rounded-2xl border border-[#CFC1AE] bg-[#F1E4D3]/70 p-5">
                            @csrf
                            <label class="label">Leave a comment</label>
                            <textarea name="comment" rows="4" class="input bg-[#FBF7F0]" placeholder="Share your perspective on this story..."></textarea>
                            <button class="btn-primary mt-3">Post Comment</button>
                        </form>
                    @else
                        <div class="mt-6 rounded-2xl bg-[#E9D9C5] p-5 text-center">
                            <p class="text-sm font-semibold text-[#30271F]">
                                Want to join the conversation? <a href="{{ route('login') }}" class="font-bold underline text-[#654A32]">Log in</a> to publish a comment.
                            </p>
                        </div>
                    @endauth

                    <div class="mt-8 space-y-4">
                        @forelse($comments as $comment)
                            <x-comment :comment="$comment" />
                        @empty
                            <x-empty-state title="No comments yet" message="Be the first to start the conversation on this article." />
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Sticky Sidebar Widgets -->
            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <!-- Share Widget Card -->
                <div class="card p-6">
                    <h3 class="font-heading text-base font-bold text-[#30271F]">Share Article</h3>
                    <div class="mt-4 grid gap-2.5">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post)) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn-ghost justify-center text-xs">
                            Share on X / Twitter
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $post)) }}" target="_blank" class="btn-ghost justify-center text-xs">
                            Share on LinkedIn
                        </a>
                    </div>
                </div>

                <!-- Related Posts Widget Card -->
                <div class="card p-6">
                    <h3 class="font-heading text-base font-bold text-[#30271F]">Related Reading</h3>
                    <div class="mt-4 space-y-4">
                        @forelse($relatedPosts as $related)
                            <a href="{{ route('blog.show', $related) }}" class="group block">
                                <p class="text-xs font-bold text-[#A77B4F]">{{ optional($related->published_at)->format('M d, Y') }}</p>
                                <h4 class="mt-1 font-heading text-sm font-bold text-[#30271F] transition group-hover:text-[#654A32] leading-snug line-clamp-2">
                                    {{ $related->title }}
                                </h4>
                            </a>
                        @empty
                            <p class="text-xs text-[#74685B]">No related posts found.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </article>

    <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'BlogPosting', 'headline' => $post->title, 'description' => $post->seo_description, 'image' => $post->featured_image_url, 'author' => ['@type' => 'Person', 'name' => $post->user->name], 'datePublished' => optional($post->published_at)->toAtomString(), 'dateModified' => $post->updated_at->toAtomString(), 'mainEntityOfPage' => route('blog.show', $post)], JSON_UNESCAPED_SLASHES) !!}</script>
</x-layouts.app>
