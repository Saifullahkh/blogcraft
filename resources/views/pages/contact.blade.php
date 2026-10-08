<x-layouts.app :title="'Contact Us'">
    <!-- Contact Header -->
    <section class="bg-[#FBF7F0] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <span class="section-kicker">Get In Touch</span>
            <h1 class="mt-4 font-heading text-4xl font-extrabold tracking-tight text-[#30271F] sm:text-5xl lg:text-6xl">
                Send a message to the editorial team.
            </h1>
            <p class="mt-4 max-w-2xl text-lg text-[#74685B]">
                Questions, pitch ideas, reader feedback, and partnership inquiries are always welcome.
            </p>
        </div>
    </section>

    <!-- Form & Info Section -->
    <section class="mx-auto grid max-w-7xl gap-12 px-4 py-12 sm:px-6 lg:grid-cols-12 lg:px-8">
        <!-- Contact Form Container -->
        <div class="lg:col-span-7">
            <form method="POST" action="{{ route('contact.store') }}" class="card p-8 sm:p-10 shadow-lg">
                @csrf
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="label">Your Name</label>
                        <input name="name" value="{{ old('name') }}" class="input h-12" placeholder="Jane Doe" required>
                    </div>
                    <div>
                        <label class="label">Email Address</label>
                        <input name="email" value="{{ old('email') }}" type="email" class="input h-12" placeholder="jane@example.com" required>
                    </div>
                </div>
                <div class="mt-6">
                    <label class="label">Subject</label>
                    <input name="subject" value="{{ old('subject') }}" class="input h-12" placeholder="Article pitch / General inquiry" required>
                </div>
                <div class="mt-6">
                    <label class="label">Message</label>
                    <textarea name="message" rows="7" class="input" placeholder="Write your details here..." required>{{ old('message') }}</textarea>
                </div>
                <button class="btn-primary mt-8 h-13 text-base font-bold w-full sm:w-auto">
                    Send Message
                </button>
            </form>
        </div>

        <!-- Info Sidebar Card -->
        <aside class="lg:col-span-5">
            <div class="overflow-hidden rounded-3xl bg-[#3C2C20] text-[#FBF7F0] shadow-2xl">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80" alt="Contact desk" class="h-56 w-full object-cover opacity-75">
                <div class="p-8">
                    <h2 class="font-heading text-2xl font-bold">Contact & Support</h2>
                    <p class="mt-3 text-sm leading-relaxed text-[#E9D9C5]">
                        Our editorial team reviews messages regularly. Expect a response within 1–2 business days.
                    </p>

                    <div class="mt-8 space-y-4 text-sm border-t border-[#654A32]/40 pt-6">
                        @if(!empty($siteSettings['contact_email']))
                            <div class="flex items-center gap-3">
                                <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#654A32]/30 text-[#A77B4F] font-bold">@</span>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-[#CFC1AE]">Direct Email</p>
                                    <p class="font-bold text-[#FBF7F0]">{{ $siteSettings['contact_email'] }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="flex items-center gap-3">
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#654A32]/30 text-[#A77B4F] font-bold">✓</span>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#CFC1AE]">Security</p>
                                <p class="text-xs text-[#E9D9C5]">Messages are processed securely via admin inbox.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </section>
</x-layouts.app>