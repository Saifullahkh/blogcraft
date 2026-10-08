<x-layouts.app :title="request('q') ? 'Search Results' : 'Blog Archive'">
    <!-- Blog Archive Header Banner -->
    <section class="relative overflow-hidden bg-[#3C2C20] py-20 text-[#FBF7F0]">
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <span class="inline-flex items-center gap-2 rounded-full border border-[#A77B4F]/40 bg-[#A77B4F]/15 px-3.5 py-1.5 text-xs font-extrabold uppercase tracking-widest text-[#CFC1AE] backdrop-blur-md">
                Editorial Archive
            </span>
            <h1 class="mt-4 font-heading text-4xl font-extrabold leading-tight sm:text-5xl lg:text-6xl">
                @if(request('q'))
                    Search results for <span class="text-[#A77B4F]">"{{ request('q') }}"</span>
                @else
                    Articles, guides & field notes.
                @endif
            </h1>
            <p class="mt-4 max-w-2xl text-lg text-[#E9D9C5]">
                Explore our curated library of published articles. Filter by topic, tag, or search keywords.
            </p>

            <!-- Advanced Filter Bar -->
            <form class="mt-10 grid gap-3 rounded-2xl border border-[#A77B4F]/30 bg-[#FBF7F0]/10 p-3.5 backdrop-blur-xl shadow-2xl md:grid-cols-12" action="{{ route('blog.index') }}">
                <div class="md:col-span-4">
                    <input class="input h-12" name="q" value="{{ request('q') }}" placeholder="Search by title or text...">
                </div>
                <div class="md:col-span-3">
                    <select class="input h-12 font-semibold" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <select class="input h-12 font-semibold" name="tag">
                        <option value="">All Tags</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->slug }}" @selected(request('tag') === $tag->slug)>#{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <select class="input h-12 font-semibold" name="sort">
                        <option value="latest" @selected(request('sort') === 'latest')>Latest First</option>
                        <option value="oldest" @selected(request('sort') === 'oldest')>Oldest First</option>
                        <option value="popular" @selected(request('sort') === 'popular')>Most Viewed</option>
                    </select>
                </div>
                <div class="md:col-span-1">
                    <button class="btn-primary h-12 w-full justify-center px-0">Filter</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Posts Grid Section -->
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
            <x-empty-state title="No articles found" message="Try adjusting your search criteria or removing active filters." />
        @endif
    </section>
</x-layouts.app>