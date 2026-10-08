<x-layouts.admin :title="'Comments'">
    <!-- Status Filter Pills -->
    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.comments.index') }}" class="btn-ghost text-xs {{ !request('status') ? 'bg-slate-900 text-white' : '' }}">
            All Comments
        </a>
        @foreach(['pending' => 'Pending Review', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $status => $label)
            <a href="{{ route('admin.comments.index', ['status' => $status]) }}" class="btn-ghost text-xs {{ request('status') === $status ? 'bg-slate-900 text-white' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Comments Table -->
    <div class="table-wrap">
        <table class="table-base">
            <thead>
                <tr>
                    <th>Comment Snippet</th>
                    <th>Author</th>
                    <th>Target Post</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                    <tr class="transition hover:bg-slate-50/70">
                        <td class="max-w-xs">
                            <p class="text-sm font-medium text-slate-800 leading-snug">{{ Str::limit($comment->comment, 120) }}</p>
                            <span class="text-[11px] text-slate-400 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                        </td>
                        <td>
                            <span class="font-heading font-bold text-slate-900 text-sm">{{ $comment->user->name }}</span>
                        </td>
                        <td class="max-w-xs">
                            <a href="{{ route('blog.show', $comment->post) }}" target="_blank" class="font-bold text-teal-700 hover:underline text-xs line-clamp-1">
                                {{ $comment->post->title }}
                            </a>
                        </td>
                        <td>
                            <span class="badge {{ $comment->status === 'approved' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200/60' : ($comment->status === 'rejected' ? 'bg-rose-50 text-rose-800 border border-rose-200/60' : 'bg-amber-50 text-amber-800 border border-amber-200/60') }}">
                                {{ ucfirst($comment->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1.5">
                                @if($comment->status !== 'approved')
                                    <form method="POST" action="{{ route('admin.comments.status', $comment) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn-ghost h-9 w-9 justify-center px-0 text-emerald-700 hover:bg-emerald-50" title="Approve Comment" aria-label="Approve Comment">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            <span class="sr-only">Approve Comment</span>
                                        </button>
                                    </form>
                                @endif

                                @if($comment->status !== 'rejected')
                                    <form method="POST" action="{{ route('admin.comments.status', $comment) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn-ghost h-9 w-9 justify-center px-0 text-amber-700 hover:bg-amber-50" title="Reject Comment" aria-label="Reject Comment">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            <span class="sr-only">Reject Comment</span>
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn-ghost h-9 w-9 justify-center px-0 text-rose-600 hover:bg-rose-50" data-confirm="Delete this comment?" title="Delete Comment" aria-label="Delete Comment">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Delete Comment</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <x-empty-state title="No comments found" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $comments->links() }}
    </div>
</x-layouts.admin>

