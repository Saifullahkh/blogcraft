<x-layouts.app :title="'Server Error'">
    <section class="mx-auto max-w-3xl px-4 py-24 text-center sm:px-6 lg:px-8">
        <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">500</p>
        <h1 class="mt-3 text-4xl font-bold tracking-tight">Something went wrong.</h1>
        <p class="mt-4 text-slate-600">The application hit an unexpected error. Please try again shortly.</p>
        <a href="{{ route('home') }}" class="btn-primary mt-8">Return Home</a>
    </section>
</x-layouts.app>
