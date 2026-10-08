<footer class="mt-24 border-t border-[#CFC1AE] bg-[#FBF7F0]">
    <!-- Top Footer Section -->
    <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 md:grid-cols-12 lg:px-8">
        <!-- Brand Info -->
        <div class="md:col-span-5 space-y-4">
            <a href="{{ route('home') }}" class="flex items-center font-extrabold text-[#30271F]">
                <img src="{{ asset('storage/logo1.png') }}" alt="{{ $siteName }}" class="h-16 w-48">
            </a>
            <p class="max-w-md text-sm leading-relaxed text-[#74685B]">
                {{ $siteSettings['website_description'] ?? 'A premier editorial publication dedicated to sharp ideas, tech insights, and practical guides for forward-thinking creators.' }}
            </p>
            <div class="flex items-center gap-3 pt-2">
                @foreach(['twitter_url' => 'X', 'linkedin_url' => 'LinkedIn', 'github_url' => 'GitHub', 'facebook_url' => 'Facebook', 'instagram_url' => 'Instagram'] as $key => $label)
                    @if(!empty($siteSettings[$key]))
                        <a href="{{ $siteSettings[$key] }}" target="_blank" rel="noopener" class="grid h-9 w-9 place-items-center rounded-xl border border-[#CFC1AE] bg-[#FBF7F0] text-[#30271F] shadow-xs transition hover:-translate-y-0.5 hover:border-[#654A32] hover:bg-[#E9D9C5] hover:text-[#654A32]" title="{{ $label }}" aria-label="{{ $label }}">
                            @switch($key)
                                @case('twitter_url')
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.657l-5.214-6.817-5.966 6.817H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.45-6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z"/></svg>
                                    @break
                                @case('linkedin_url')
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.447-2.136 2.942v5.664H9.351V9h3.414v1.561h.049c.476-.9 1.637-1.852 3.368-1.852 3.601 0 4.267 2.37 4.267 5.455v6.288ZM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124ZM7.114 20.452H3.558V9h3.556v11.452Z"/></svg>
                                    @break
                                @case('github_url')
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.59 2 12.253c0 4.529 2.865 8.371 6.839 9.728.5.094.683-.222.683-.494 0-.244-.009-.89-.014-1.747-2.782.62-3.369-1.376-3.369-1.376-.455-1.186-1.11-1.502-1.11-1.502-.908-.636.069-.623.069-.623 1.004.072 1.532 1.057 1.532 1.057.892 1.566 2.341 1.114 2.91.852.091-.662.35-1.114.636-1.37-2.221-.259-4.556-1.139-4.556-5.07 0-1.12.39-2.036 1.03-2.752-.103-.259-.446-1.302.098-2.714 0 0 .84-.276 2.75 1.051A9.316 9.316 0 0 1 12 6.956a9.3 9.3 0 0 1 2.504.347c1.909-1.327 2.747-1.051 2.747-1.051.546 1.412.203 2.455.1 2.714.64.716 1.028 1.632 1.028 2.752 0 3.941-2.339 4.808-4.567 5.062.359.317.678.943.678 1.9 0 1.371-.012 2.477-.012 2.814 0 .274.18.593.688.492C19.138 20.62 22 16.78 22 12.253 22 6.59 17.523 2 12 2Z" clip-rule="evenodd"/></svg>
                                    @break
                                @case('facebook_url')
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12.061C22 6.505 17.523 2 12 2S2 6.505 2 12.061c0 5.022 3.657 9.184 8.438 9.939v-7.03H7.898v-2.909h2.54V9.845c0-2.522 1.492-3.916 3.777-3.916 1.094 0 2.238.197 2.238.197v2.475h-1.261c-1.243 0-1.63.776-1.63 1.572v1.888h2.773l-.443 2.909h-2.33V22C18.343 21.245 22 17.083 22 12.061Z"/></svg>
                                    @break
                                @case('instagram_url')
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5h.01" stroke-linecap="round"/></svg>
                                    @break
                            @endswitch
                            <span class="sr-only">{{ $label }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Navigation Columns -->
        <div class="md:col-span-3">
            <h3 class="text-xs font-extrabold uppercase tracking-widest text-[#74685B]">Navigation</h3>
            <ul class="mt-4 space-y-2.5 text-sm font-semibold text-[#30271F]">
                <li><a href="{{ route('home') }}" class="transition hover:text-[#654A32]">Home</a></li>
                <li><a href="{{ route('blog.index') }}" class="transition hover:text-[#654A32]">Blog Archive</a></li>
                <li><a href="{{ route('about') }}" class="transition hover:text-[#654A32]">About Us</a></li>
                <li><a href="{{ route('contact.create') }}" class="transition hover:text-[#654A32]">Contact Us</a></li>
                <li><a href="{{ route('sitemap') }}" class="transition hover:text-[#654A32]">Sitemap XML</a></li>
            </ul>
        </div>

        <!-- Topics / Info -->
        <div class="md:col-span-4 space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-widest text-[#74685B]">Editorial Note</h3>
            <p class="text-xs leading-relaxed text-[#74685B]">
                All articles are published under our quality guidelines. Readers are invited to join thoughtful discussions and share their insights.
            </p>
            @if(!empty($siteSettings['contact_email']))
                <div class="rounded-xl border border-[#CFC1AE] bg-[#E9D9C5]/50 p-3.5">
                    <p class="text-xs font-bold text-[#74685B]">Need support or pitched an article?</p>
                    <a href="mailto:{{ $siteSettings['contact_email'] }}" class="text-xs font-bold text-[#654A32] hover:underline">
                        {{ $siteSettings['contact_email'] }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Bottom Copyright -->
    <div class="border-t border-[#CFC1AE] bg-[#E9D9C5]/60 py-6 text-center text-xs font-medium text-[#74685B]">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 sm:flex-row sm:px-6 lg:px-8">
            <p>{{ $siteSettings['footer_text'] ?? ('Copyright '.date('Y').' '.$siteName.'. All rights reserved.') }}</p>
            <p class="flex items-center gap-1 text-[#74685B]">
                Crafted with <span class="text-[#654A32]">&hearts;</span> for an exceptional reading experience
            </p>
        </div>
    </div>
</footer>


