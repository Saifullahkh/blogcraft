<x-layouts.admin :title="'Contact Messages'">
    <div class="table-wrap">
        <table class="table-base">
            <thead>
                <tr>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Received Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr class="transition hover:bg-slate-50/70">
                        <td>
                            <p class="font-heading font-bold text-slate-900 leading-snug">{{ $message->name }}</p>
                            <p class="text-xs text-slate-500 font-medium">{{ $message->email }}</p>
                        </td>
                        <td class="font-medium text-slate-800">{{ $message->subject }}</td>
                        <td>
                            <span class="badge {{ $message->status === 'new' ? 'bg-amber-50 text-amber-800 border border-amber-200/60' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($message->status) }}
                            </span>
                        </td>
                        <td class="text-xs font-medium text-slate-500">{{ $message->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-1.5">
                                <a class="btn-ghost h-9 w-9 justify-center px-0 text-teal-700 hover:bg-teal-50" href="{{ route('admin.contact-messages.show', $message) }}" title="Open Message" aria-label="Open Message">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="sr-only">Open Message</span>
                                </a>
                                <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn-ghost h-9 w-9 justify-center px-0 text-rose-600 hover:bg-rose-50" data-confirm="Delete this message?" title="Delete Message" aria-label="Delete Message">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Delete Message</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <x-empty-state title="No contact messages found" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $messages->links() }}
    </div>
</x-layouts.admin>

