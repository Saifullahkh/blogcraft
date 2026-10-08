<div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center">
    <h3 class="text-lg font-semibold">{{ $title ?? 'Nothing here yet' }}</h3>
    <p class="mt-2 text-sm text-slate-500">{{ $message ?? 'New content will appear here when it is available.' }}</p>
    @isset($action)
        <div class="mt-5">{{ $action }}</div>
    @endisset
</div>
