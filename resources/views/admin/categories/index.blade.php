<x-layouts.admin :title="'Categories'">
    <!-- Toolbar -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <form class="flex items-center gap-2.5">
            <div class="relative">
                <input name="q" value="{{ request('q') }}" class="input h-11 w-64 bg-white pl-9" placeholder="Search categories...">
                <svg class="absolute left-3 top-3 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button class="btn-ghost h-11">Search</button>
        </form>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary h-11">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            New Category
        </a>
    </div>

    <!-- Table -->
    <div class="table-wrap">
        <table class="table-base">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Posts</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="transition hover:bg-slate-50/70">
                        <td>
                            <div class="flex items-center gap-3.5">
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-12 w-16 rounded-xl object-cover shadow-xs border border-slate-200/80">
                                <span class="font-heading font-bold text-slate-900">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="text-xs font-mono text-slate-500">{{ $category->slug }}</td>
                        <td>
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-700">
                                <span class="h-2 w-2 rounded-full bg-teal-500"></span>
                                {{ $category->posts_count }} articles
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $category->status ? 'bg-emerald-50 text-emerald-800 border border-emerald-200/60' : 'bg-slate-100 text-slate-600' }}">
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1.5">
                                @if($category->status)
                                    <a class="btn-ghost h-9 w-9 justify-center px-0 text-sky-700 hover:bg-sky-50" href="{{ route('categories.show', $category) }}" target="_blank" rel="noopener" title="View Category" aria-label="View Category">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="sr-only">View Category</span>
                                    </a>
                                @endif

                                <a class="btn-ghost h-9 w-9 justify-center px-0 text-teal-700 hover:bg-teal-50" href="{{ route('admin.categories.edit', $category) }}" title="Edit Category" aria-label="Edit Category">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span class="sr-only">Edit Category</span>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn-ghost h-9 w-9 justify-center px-0 text-rose-600 hover:bg-rose-50" data-confirm="Delete this category?" title="Delete Category" aria-label="Delete Category">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Delete Category</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <x-empty-state title="No categories found" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $categories->links() }}
    </div>
</x-layouts.admin>

