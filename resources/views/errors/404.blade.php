<x-layouts.app :title="'Page Not Found'">
    <section class="mx-auto max-w-3xl px-4 py-24 text-center sm:px-6 lg:px-8">
        <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">404</p>
        <h1 class="mt-3 text-4xl font-bold tracking-tight">This page slipped out of the archive.</h1>
        <p class="mt-4 text-slate-600">The link may be outdated, or the article may no longer be available.</p>
        <a href="{{ route('home') }}" class="btn-primary mt-8">Return Home</a>
    </section>
</x-layouts.app>
