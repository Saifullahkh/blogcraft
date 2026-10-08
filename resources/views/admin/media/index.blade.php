<x-layouts.admin :title="'Media'">
    @if($files->isNotEmpty())
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($files as $file)
                <div class="card overflow-hidden">
                    <a href="{{ $file['url'] }}" target="_blank" rel="noopener" title="Open Media">
                        <img src="{{ $file['url'] }}" alt="{{ $file['path'] }}" class="h-40 w-full object-cover">
                    </a>

                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold" title="{{ $file['path'] }}">
                                    {{ $file['path'] }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ number_format($file['size'] / 1024, 1) }} KB
                                </p>
                            </div>

                            <div class="flex shrink-0 items-center gap-1.5">
                                <a class="btn-ghost h-9 w-9 justify-center px-0 text-sky-700 hover:bg-sky-50" href="{{ $file['url'] }}" target="_blank" rel="noopener" title="Open Media" aria-label="Open Media">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span class="sr-only">Open Media</span>
                                </a>

                                <form method="POST" action="{{ route('admin.media.destroy') }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="path" value="{{ $file['path'] }}">
                                    <button class="btn-ghost h-9 w-9 justify-center px-0 text-rose-600 hover:bg-rose-50" data-confirm="Delete this media file?" title="Delete Media" aria-label="Delete Media">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Delete Media</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <x-empty-state title="No uploaded media" message="Uploaded images will appear here." />
    @endif
</x-layouts.admin>