<x-layouts.app :title="'Tag: ' . $tag->name">
    <!-- Tag Hero Header -->
    <section class="bg-[#FBF7F0] py-16 border-b border-[#CFC1AE]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <span class="inline-flex items-center gap-2 rounded-full bg-[#E9D9C5] px-3.5 py-1.5 text-xs font-extrabold uppercase tracking-widest text-[#654A32]">
                Tagged Topic
            </span>
            <h1 class="mt-4 font-heading text-4xl font-extrabold tracking-tight text-[#30271F] sm:text-5xl lg:text-6xl">
                #{{ $tag->name }}
            </h1>
            <p class="mt-4 max-w-3xl text-lg text-[#74685B]">
                Browse all published articles tagged with #{{ $tag->name }}.
            </p>
            <div class="mt-6 flex items-center gap-4 text-xs font-bold uppercase tracking-wider text-[#74685B]">
                <span>{{ $posts->total() }} published articles</span>
            </div>
        </div>
    </section>

    <!-- Tag Posts Grid -->
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        @if($posts->count())
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                    <x-blog-card :post="$post" />
                @endforeach
            </div>
            <div class="mt-12 flex justify-center">
                {{ $posts->links() }}
            </div>
        @else
            <x-empty-state title="No posts for this tag" />
        @endif
    </section>
</x-layouts.app>
