<div class="rounded-lg border border-slate-200 bg-white p-4">
    <div class="flex items-start gap-3">
        <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="h-10 w-10 rounded-full object-cover">
        <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-center gap-2">
                <h4 class="font-semibold">{{ $comment->user->name }}</h4>
                <span class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p class="mt-2 text-sm leading-6 text-slate-700">{{ $comment->comment }}</p>
            @auth
                <form method="POST" action="{{ route('comments.store', $comment->post) }}" class="mt-3 hidden" data-reply-form="{{ $comment->id }}">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea name="comment" rows="3" class="input" placeholder="Write a reply"></textarea>
                    <button class="btn-primary mt-2">Reply</button>
                </form>
                <button class="mt-2 text-sm font-semibold text-teal-700" data-reply-button="{{ $comment->id }}">Reply</button>
            @endauth
            @if($comment->approvedReplies->isNotEmpty())
                <div class="mt-4 grid gap-3 border-l border-slate-200 pl-4">
                    @foreach($comment->approvedReplies as $reply)
                        <x-comment :comment="$reply" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
