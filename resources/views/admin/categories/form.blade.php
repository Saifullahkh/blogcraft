<x-layouts.admin :title="$category->exists ? 'Edit Category' : 'Create Category'">
    <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" enctype="multipart/form-data" class="mx-auto max-w-3xl card p-6">@csrf @if($category->exists) @method('PUT') @endif
        <div class="grid gap-4 sm:grid-cols-2"><div><label class="label">Name</label><input name="name" data-slug-source="#category-slug" value="{{ old('name', $category->name) }}" class="input" required></div><div><label class="label">Slug</label><input id="category-slug" name="slug" value="{{ old('slug', $category->slug) }}" class="input" required></div></div>
        <div class="mt-4"><label class="label">Description</label><textarea name="description" rows="4" class="input">{{ old('description', $category->description) }}</textarea></div>
        <div class="mt-4"><label class="label">Image</label>@if($category->image)<img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="mb-3 h-36 w-full rounded-lg object-cover">@endif<input name="image" type="file" accept="image/*" class="input"></div>
        <label class="mt-4 flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="status" value="1" @checked(old('status', $category->status))> Active</label>
        <div class="mt-6 flex gap-3"><button class="btn-primary">Save Category</button><a href="{{ route('admin.categories.index') }}" class="btn-ghost">Cancel</a></div>
    </form>
</x-layouts.admin>
