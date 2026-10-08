<x-layouts.admin :title="$tag->exists ? 'Edit Tag' : 'Create Tag'">
    <form method="POST" action="{{ $tag->exists ? route('admin.tags.update', $tag) : route('admin.tags.store') }}" class="mx-auto max-w-xl card p-6">@csrf @if($tag->exists) @method('PUT') @endif
        <div><label class="label">Name</label><input name="name" data-slug-source="#tag-slug" value="{{ old('name', $tag->name) }}" class="input" required></div>
        <div class="mt-4"><label class="label">Slug</label><input id="tag-slug" name="slug" value="{{ old('slug', $tag->slug) }}" class="input" required></div>
        <div class="mt-6 flex gap-3"><button class="btn-primary">Save Tag</button><a href="{{ route('admin.tags.index') }}" class="btn-ghost">Cancel</a></div>
    </form>
</x-layouts.admin>
