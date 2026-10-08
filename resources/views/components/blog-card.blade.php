<article class="group relative flex flex-col overflow-hidden rounded-2xl border border-[#CFC1AE] bg-[#F1E4D3] shadow-xs transition duration-300 hover:-translate-y-1.5 hover:border-[#654A32] hover:shadow-xl">
    <!-- Image Thumbnail -->
    <a href="{{ route('blog.show', $post) }}" class="relative block h-56 w-full overflow-hidden bg-[#E9D9C5]">
        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105">
        <div class="absolute inset-0 bg-[#30271F]/20"></div>
        @if($post->category)
            <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-[#FBF7F0]/90 px-3 py-1 text-xs font-bold text-[#30271F] shadow-md backdrop-blur-md transition group-hover:bg-[#FBF7F0] group-hover:text-[#654A32]">
                <span class="h-1.5 w-1.5 rounded-full bg-[#654A32]"></span>
                {{ $post->category->name }}
            </span>
        @endif
    </a>

    <!-- Card Content Body -->
    <div class="flex flex-1 flex-col justify-between p-6">
        <div>
            <!-- Meta Date & Time -->
            <div class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-[#A77B4F]">
                <span>{{ optional($post->published_at)->format('M d, Y') }}</span>
                <span class="text-[#CFC1AE]">•</span>
                <span>{{ $post->reading_time }} min read</span>
            </div>

            <!-- Title -->
            <h2 class="mt-3 text-xl font-bold font-heading leading-snug tracking-tight text-[#30271F] transition group-hover:text-[#654A32]">
                <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
            </h2>

            <!-- Excerpt -->
            <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-[#74685B]">
                {{ $post->excerpt }}
            </p>
        </div>

        <!-- Card Footer Author -->
        <div class="mt-6 flex items-center justify-between border-t border-[#CFC1AE]/60 pt-4">
            <div class="flex min-w-0 items-center gap-3">
                <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" class="h-9 w-9 rounded-full object-cover ring-2 ring-[#CFC1AE]">
                <div class="min-w-0 text-xs">
                    <p class="truncate font-bold text-[#30271F]">{{ $post->user->name }}</p>
                    <p class="text-[#74685B] font-medium">{{ number_format($post->views) }} views</p>
                </div>
            </div>
            <a href="{{ route('blog.show', $post) }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#654A32] transition hover:gap-2 hover:text-[#3C2C20]">
                Read Article
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</article>