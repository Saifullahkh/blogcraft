<x-layouts.app :title="'About Us'">
    <!-- Hero Header -->
    <section class="relative overflow-hidden bg-[#FBF7F0] py-20">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:px-8">
            <div class="lg:col-span-7">
                <span class="section-kicker">Our Story & Mission</span>
                <h1 class="mt-4 font-heading text-4xl font-extrabold leading-tight tracking-tight text-[#30271F] sm:text-5xl lg:text-6xl">
                    A publication built for clear thinking & useful stories.
                </h1>
                <p class="mt-6 text-lg leading-relaxed text-[#74685B]">
                    {{ $siteSettings['website_description'] ?? 'We publish practical ideas, editorial essays, and field notes for readers who enjoy substance without clutter.' }}
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('blog.index') }}" class="btn-primary">Browse Publication</a>
                    <a href="{{ route('contact.create') }}" class="btn-ghost">Get in Touch</a>
                </div>
            </div>
            <div class="relative lg:col-span-5">
                <div class="overflow-hidden rounded-3xl shadow-2xl shadow-[#30271F]/15 ring-1 ring-[#CFC1AE]">
                    <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80" alt="Editorial team workspace" class="h-[420px] w-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Pillar Cards -->
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="card p-8 lg:col-span-2">
                <span class="section-kicker">Purpose</span>
                <h2 class="mt-3 font-heading text-2xl font-bold text-[#30271F] sm:text-3xl">Designed for readers and creators.</h2>
                <p class="mt-4 text-base leading-relaxed text-[#74685B]">
                    This publication serves as a professional editorial workspace: searchable, accessible, performant, and clutter-free. Authors share deep insights, readers participate in moderated conversations, and editors maintain high publishing standards.
                </p>
            </div>
            <div class="rounded-2xl border border-[#654A32] bg-[#3C2C20] p-8 text-[#FBF7F0] shadow-2xl">
                <span class="text-xs font-bold uppercase tracking-widest text-[#A77B4F]">Core Mission</span>
                <h2 class="mt-3 font-heading text-2xl font-bold">Make great ideas effortless to discover.</h2>
                <p class="mt-4 text-sm leading-relaxed text-[#E9D9C5]">
                    We keep every article focused, clean, and immediately actionable for our reader community.
                </p>
            </div>
        </div>

        <!-- Values Grid -->
        <div class="mt-8 grid gap-6 sm:grid-cols-3">
            <div class="card p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#E9D9C5] text-[#654A32] font-heading font-bold text-xl mb-4">01</div>
                <h3 class="font-heading text-lg font-bold text-[#30271F]">Clarity & Depth</h3>
                <p class="mt-2 text-sm leading-relaxed text-[#74685B]">Readable typography, clean spacing, and well-structured arguments.</p>
            </div>
            <div class="card p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#E9D9C5] text-[#654A32] font-heading font-bold text-xl mb-4">02</div>
                <h3 class="font-heading text-lg font-bold text-[#30271F]">Practical Value</h3>
                <p class="mt-2 text-sm leading-relaxed text-[#74685B]">Field notes and tutorials that empower readers to build with confidence.</p>
            </div>
            <div class="card p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#E9D9C5] text-[#654A32] font-heading font-bold text-xl mb-4">03</div>
                <h3 class="font-heading text-lg font-bold text-[#30271F]">Thoughtful Dialogue</h3>
                <p class="mt-2 text-sm leading-relaxed text-[#74685B]">Moderated community discussions where ideas are challenged respectfully.</p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-[#3C2C20] py-20 text-[#FBF7F0]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($stats as $label => $value)
                    <div class="rounded-2xl border border-[#654A32]/50 bg-[#654A32]/20 p-6">
                        <p class="font-heading text-4xl font-extrabold text-[#A77B4F] sm:text-5xl">{{ number_format($value) }}</p>
                        <p class="mt-2 text-sm font-bold uppercase tracking-wider text-[#E9D9C5]">{{ str_replace('_', ' ', $label) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>