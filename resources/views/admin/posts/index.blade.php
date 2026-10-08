<x-layouts.admin :title="'Posts'">
    <!-- Top Action & Filter Toolbar -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <form class="flex flex-wrap items-center gap-2.5">
            <div class="relative">
                <input name="q" value="{{ request('q') }}" class="input h-11 w-64 bg-white pl-9" placeholder="Search posts...">
                <svg class="absolute left-3 top-3 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <select name="category" class="input h-11 w-48 bg-white text-xs font-semibold">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="status" class="input h-11 w-40 bg-white text-xs font-semibold">
                <option value="">Any status</option>
                <option value="published" @selected(request('status') === 'published')>Published</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
            </select>
            <button class="btn-ghost h-11">Filter</button>
        </form>
        <a href="{{ route('admin.posts.create') }}" class="btn-primary h-11">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Create New Post
        </a>
    </div>

    <!-- Posts Table -->
    <div class="table-wrap">
        <table class="table-base">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr class="transition hover:bg-slate-50/70">
                        <td>
                            <div class="flex items-center gap-3.5">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="h-14 w-20 rounded-xl object-cover shadow-xs border border-slate-200/80">
                                <div>
                                    <p class="font-heading font-bold text-slate-900 leading-snug line-clamp-1">{{ $post->title }}</p>
                                    <p class="mt-0.5 text-xs font-medium text-slate-400">{{ optional($post->published_at)->format('M d, Y') ?? 'Draft' }} &bull; {{ $post->reading_time }} min read</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($post->category)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                                    {{ $post->category->name }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400 font-medium">Uncategorized</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <span class="badge {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200/60' : 'bg-amber-50 text-amber-800 border border-amber-200/60' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                                @if($post->is_featured)
                                    <span class="badge bg-teal-50 text-teal-800 border border-teal-200/60">&#9733; Featured</span>
                                @endif
                            </div>
                        </td>
                        <td class="font-semibold text-slate-700">{{ number_format($post->views) }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-1.5">
                                @if($post->status === 'published' && $post->published_at && $post->published_at->lte(now()))
                                    <a class="btn-ghost h-9 w-9 justify-center px-0 text-sky-700 hover:bg-sky-50" href="{{ route('blog.show', $post) }}" target="_blank" rel="noopener" title="View Post" aria-label="View Post">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="sr-only">View Post</span>
                                    </a>
                                @endif

                                <a class="btn-ghost h-9 w-9 justify-center px-0 text-teal-700 hover:bg-teal-50" href="{{ route('admin.posts.edit', $post) }}" title="Edit Post" aria-label="Edit Post">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span class="sr-only">Edit Post</span>
                                </a>

                                <form method="POST" action="{{ route('admin.posts.publish', $post) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn-ghost h-9 w-9 justify-center px-0 {{ $post->status === 'published' ? 'text-slate-600 hover:bg-slate-100' : 'text-emerald-700 hover:bg-emerald-50' }}" title="{{ $post->status === 'published' ? 'Unpublish Post' : 'Publish Post' }}" aria-label="{{ $post->status === 'published' ? 'Unpublish Post' : 'Publish Post' }}">
                                        @if($post->status === 'published')
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/></svg>
                                            <span class="sr-only">Unpublish Post</span>
                                        @else
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2 2 4-5.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/></svg>
                                            <span class="sr-only">Publish Post</span>
                                        @endif
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.posts.feature', $post) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn-ghost h-9 w-9 justify-center px-0 text-amber-700 hover:bg-amber-50" title="{{ $post->is_featured ? 'Remove Featured' : 'Mark Featured' }}" aria-label="{{ $post->is_featured ? 'Remove Featured' : 'Mark Featured' }}">
                                        <svg class="h-4 w-4 {{ $post->is_featured ? 'fill-amber-400' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                        <span class="sr-only">{{ $post->is_featured ? 'Remove Featured' : 'Mark Featured' }}</span>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn-ghost h-9 w-9 justify-center px-0 text-rose-600 hover:bg-rose-50" data-confirm="Delete this post?" title="Delete Post" aria-label="Delete Post">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Delete Post</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <x-empty-state title="No posts found" message="Create the first article for the blog." />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $posts->links() }}
    </div>
</x-layouts.admin>

