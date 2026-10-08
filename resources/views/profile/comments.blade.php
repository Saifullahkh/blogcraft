<x-layouts.app :title="'My Comments'">
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8"><p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Account</p><h1 class="mt-2 text-3xl font-bold tracking-tight">My Comments</h1></div>
        <div class="grid gap-4">
            @forelse($comments as $comment)
                <div class="card p-5"><div class="flex flex-wrap items-center justify-between gap-3"><a href="{{ route('blog.show', $comment->post) }}" class="font-semibold">{{ $comment->post->title }}</a><span class="badge {{ $comment->status === 'approved' ? 'bg-emerald-50 text-emerald-800' : ($comment->status === 'rejected' ? 'bg-rose-50 text-rose-800' : 'bg-amber-50 text-amber-800') }}">{{ ucfirst($comment->status) }}</span></div><p class="mt-3 text-sm leading-6 text-slate-600">{{ $comment->comment }}</p><p class="mt-2 text-xs text-slate-500">{{ $comment->created_at->format('M d, Y') }}</p></div>
            @empty
                <x-empty-state title="No comments yet" message="Your article comments will appear here." />
            @endforelse
        </div>
        <div class="mt-8">{{ $comments->links() }}</div>
    </section>
</x-layouts.app>
