<a href="{{ route('categories.show', $category) }}" class="group relative overflow-hidden rounded-2xl border border-[#CFC1AE] bg-[#F1E4D3] p-6 shadow-xs transition duration-300 hover:-translate-y-1 hover:border-[#654A32] hover:shadow-xl">
    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="absolute inset-0 h-full w-full object-cover opacity-15 transition duration-700 ease-out group-hover:scale-110 group-hover:opacity-25">
    <div class="absolute inset-0 bg-[#F1E4D3]/90"></div>
    <div class="relative flex min-h-[120px] flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#654A32] font-heading text-lg font-black text-[#FBF7F0] shadow-md shadow-[#654A32]/30 transition group-hover:scale-105">
                {{ Str::of($category->name)->substr(0, 1)->upper() }}
            </span>

            <span class="inline-flex items-center gap-1 rounded-full bg-[#E9D9C5] px-2.5 py-1 text-xs font-bold text-[#654A32]">
                <span class="h-1.5 w-1.5 rounded-full bg-[#654A32]"></span>
                {{ $category->published_posts_count ?? $category->posts_count ?? 0 }} articles
            </span>
        </div>
        <div class="mt-4">
            <h3 class="font-heading text-xl font-bold text-[#30271F] transition group-hover:text-[#654A32]">{{ $category->name }}</h3>
            @if($category->description)
                <p class="mt-1 line-clamp-1 text-xs font-medium text-[#74685B]">{{ $category->description }}</p>
            @endif
        </div>
    </div>
</a>